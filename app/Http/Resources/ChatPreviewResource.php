<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->whenLoaded('users', $this->users[0]);

        return [
            'photo' => $this->whenNotNull($user->photos[0]?->url),
            'name' => $user?->username,
            'user_id' => $user?->id,
            'message' => $this->whenLoaded('messages', [
                "text" => $this->messages[0]->message,
                "sender_id" => $this->messages[0]->sender_id,
            ]),
            'chat_id' => $this->id
        ];
    }
}
