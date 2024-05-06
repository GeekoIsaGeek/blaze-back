<?php

namespace App\Broadcasting;

use App\Models\User;

class MatchChannel
{
    public function join(User $user, $id): array|bool
    {
        return (int) $user->id === (int) $id;
    }
}
