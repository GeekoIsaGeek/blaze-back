<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'location' => $this->location,
            'bio' => $this->bio,
            'gender' => $this->gender,
            'languages' => $this->languages,
            'preferences' => $this->preferences,
            'interests' => $this->interests,
            'photos' => $this->photos,
        ];
    }
}
