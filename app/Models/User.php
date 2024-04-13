<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    protected $with = [
        'photos',
        'interests'
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
}
