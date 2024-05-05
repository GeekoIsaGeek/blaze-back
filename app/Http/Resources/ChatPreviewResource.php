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
        return [
            'photo' => $this->whenLoaded('users', $this->users[0]?->photos[0]?->url),
            'name' => $this->whenLoaded('users', $this->users[0]->username),
            'user_id' => $this->whenLoaded('users', $this->users[0]->id),
            'message' => $this->whenLoaded('messages', $this->messages[0]?->message)
        ];
    }
}
