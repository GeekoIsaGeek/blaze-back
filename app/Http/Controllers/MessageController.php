<?php

namespace App\Http\Controllers;

use App\Events\MessageProcessedEvent;
use App\Http\Requests\CreateMessageRequest;
use App\Http\Resources\MessageResoure;
use App\Models\Chat;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(CreateMessageRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $senderId = auth()->id();
            $receiverId = $validated['receiver_id'];

            $chat = Chat::whereHas('users', function ($query) use ($senderId, $receiverId) {
                $query->where('users.id', $senderId)->orWhere('users.id', $receiverId);
            }, '=', 2)->with('users')->first();


            if(!$chat) {
                $chat = Chat::create();
                $chat->users()->syncWithoutDetaching([$senderId, $receiverId]);
            }

            $message = $chat->messages()->create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'message' => $validated['content'],
            ]);

            MessageProcessedEvent::broadcast(MessageResoure::make($message), $chat->id);

            return response()->json(['message' => 'The message has been created'], 201);
        } catch(Error $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
