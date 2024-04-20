<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PreferredUserRetrievalService
{
    public function getUsers(int $limit = 1): Collection
    {
        $preferences = auth()->user()->preference;

        $users = User::whereNot('id', auth()->user()->id)
            ->whereHas('photos')
            ->satisfyGenderPreference($preferences->show)
            ->satisfyAgePreference($preferences?->age_from, $preferences?->age_to)
            ->excludeAlreadySwipedUsers()
            ->excludeDislikers()
            ->limit($limit)
            ->get();

        return $users;
    }
}
