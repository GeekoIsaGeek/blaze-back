<?php

namespace App\Broadcasting;

use App\Models\User;

class ChatChannel
{
    public function join(User $user, $chatId): array|bool
    {
        $isChatMember = $user->chats()->where('chat_id', $chatId)->exists();

        $isAuthorized =  (int) $user->id === (int) auth()->id() && $isChatMember;

        return $isAuthorized;
    }
}
