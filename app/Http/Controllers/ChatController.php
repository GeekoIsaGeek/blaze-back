<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatPreviewResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getPreviews(): JsonResponse
    {
        $chats = auth()->user()->chats->load(['messages' => function ($query) {
            $query->latest()->limit(1);
        },'users' => function ($query) {
            $query->whereNot('users.id', auth()->id());
        }]);

        return response()->json(ChatPreviewResource::collection($chats), 200);
    }
}
