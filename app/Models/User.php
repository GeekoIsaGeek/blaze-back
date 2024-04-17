<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\Dates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $guarded = [
        'id'
    ];

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);

    }

    public function interests(): BelongsToMany
    {
        return $this->belongsToMany(Interest::class, 'interests_users', 'user_id', 'interest_id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'languages' => 'array',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function preference(): HasOne
    {
        return $this->hasOne(Preference::class);
    }

    public function interactionsAsInteractor(): HasMany
    {
        return $this->hasMany(Interaction::class, 'interactor_id');
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

    public function getMatchesAttribute(): Collection
    {
        return $this->interactionsAsInteractor()->where('type', 'match')->get();
    }

    public function scopeSatisfyGenderPreference($query, string $gender): Builder
    {
        if(!$gender || $gender === 'everyone') {
            return $query;
        }

        return $query->where('gender', $gender);
    }

    public function scopeSatisfyAgePreference($query, $ageFrom, $ageTo): Builder
    {
        return $query->whereRaw('TIMESTAMPDIFF(YEAR, birthdate, CURDATE()) BETWEEN ? AND ?', [$ageFrom ?? 18, $ageTo ?? 90]);
    }

}
