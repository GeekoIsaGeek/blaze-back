<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatPreviewResource;
use App\Http\Resources\MessageResoure;
use App\Models\Chat;
use App\Models\User;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getPreviews(): JsonResponse
    {
        try {
            $chats = auth()->user()->chats->load(['messages' => function ($query) {
                $query->latest()->limit(1);
            },'users' => function ($query) {
                $query->whereNot('users.id', auth()->id());
            }]);
            return response()->json(ChatPreviewResource::collection($chats), 200);
        } catch(Error $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getChatMessages(User $user): JsonResponse
    {
        try {
            $chat = Chat::whereSecondParticipantIs($user->id)->first();

            return response()->json(MessageResoure::collection($chat->messages), 200);
        } catch(Error $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
