<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\InteractionType;
use App\Helpers\Dates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection as SupportCollection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'languages' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'interests_users', 'user_id', 'interest_id');
    }

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    public function chats(): BelongsToMany
    {
        return $this->belongsToMany(Chat::class, 'chat_user', 'user_id', 'chat_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function interactionsAsInteractor(): HasMany
    {
        return $this->hasMany(Interaction::class, 'interactor_id');
    }

    public function interactionsAsInteractee(): HasMany
    {
        return $this->hasMany(Interaction::class, 'interactee_id');
    }

    public function getAgeAttribute(): int
    {
        return Dates::getAgeFromBirthdate($this->birthdate);
    }

    public function getLikesAttribute(): Collection
    {
        return $this->interactionsAsInteractor()->where('type', 'like')->get();
    }

    public function getDislikesAttribute(): Collection
    {
        return $this->interactionsAsInteractor()->where('type', 'dislike')->get();
    }

    public function matchesAsMatcher(): HasMany
    {
        return $this->hasMany(Pair::class, 'matcher_id');
    }

    public function matchesAsMatchee(): hasMany
    {
        return $this->hasMany(Pair::class, 'matchee_id');
    }

    public function getMatchesAttribute(): SupportCollection
    {
        return $this->matchesAsMatchee->merge($this->matchesAsMatcher);
    }

    public function getNewMatchesAttribute(): SupportCollection
    {
        $matchesAsMatchee = $this->getNewMatches($this->matchesAsMatchee(), 'matcher');
        $matchesAsMatcher = $this->getNewMatches($this->matchesAsMatcher(), 'matchee');

        return $matchesAsMatchee->merge($matchesAsMatcher);
    }

    public function scopeFilterByGenderPreference($query, string | null $gender): Builder
    {
        if (!$gender || $gender === 'everyone') {
            return $query;
        }

        return $query->where('gender', $gender);
    }

    public function scopeFilterByAgePreference($query, $ageFrom, $ageTo): Builder
    {
        return $query->whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN ? AND ?', [$ageFrom ?? 18, $ageTo ?? 90]);
    }

    public function scopeExcludeAlreadySwipedUsers($query): Builder
    {
        return $query->whereDoesntHave('interactionsAsInteractee', fn ($query) => $query->where('interactor_id', auth()->user()->id));
    }

    public function scopeExcludeDislikers($query): Builder
    {
        return $query->whereDoesntHave('interactionsAsInteractor', function ($query) {
            $query->where('type', InteractionType::DISLIKE)
                ->where('interactee_id', auth()->user()->id);
        });
    }

    public function scopeExcludeMatches($query): Builder
    {
        return $query->whereDoesntHave('matchesAsMatcher', fn ($q) => $q->where('matchee_id', auth()->user()->id))
            ->whereDoesntHave('matchesAsMatchee', fn ($q) => $q->where('matcher_id', auth()->user()->id));
    }

    private function getNewMatches($query, $role): SupportCollection
    {
        return $query->with($role)
            ->whereDoesntHave("$role.sentMessages", function ($query) {
                $query->where('receiver_id', auth()->user()->id);
            })
            ->whereDoesntHave("$role.receivedMessages", function ($query) {
                $query->where('sender_id', auth()->user()->id);
            })
            ->get()->pluck($role);
    }
}
