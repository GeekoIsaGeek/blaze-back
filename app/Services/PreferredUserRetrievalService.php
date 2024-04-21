<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PreferredUserRetrievalService
{
    public function getUsers(int $limit = 2): Collection | null
    {
        $preferences = auth()->user()->preference;

        $users = User::whereNot('id', auth()->user()->id)
            ->whereHas('photos')
            ->filterByGenderPreference($preferences?->show)
            ->filterByAgePreference($preferences?->age_from, $preferences?->age_to)
            ->excludeAlreadySwipedUsers()
            ->excludeDislikers()
            ->excludeMatches()
            ->limit($limit)
            ->get();

        return $users;

    }
}
