<?php

namespace App\Http\Resources;

use App\Helpers\Dates;
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
            'age' => $this?->age,
            'location' => $this->location,
            'bio' => $this->bio,
            'gender' => $this->gender,
            'languages' => $this->languages,
            'preference' => $this->preference,
            'interests' => InterestResource::collection($this->interests),
            'photos' =>  PhotoResource::collection($this->photos),
        ];
    }
}
