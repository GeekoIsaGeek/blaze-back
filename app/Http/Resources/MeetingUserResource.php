<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helpers\Dates;

class MeetingUserResource extends JsonResource
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
            'location' => $this->location,
            'age' => $this->whenNotNull($this->birthdate, Dates::ageFromBirthdate($this->birthdate)),
            'bio' => $this->bio,
            'languages' => $this->languages,
            'gender' => $this->gender,
            'interests' => InterestResource::collection($this->interests),
            'photos' =>  PhotoResource::collection($this->photos),
        ];

    }
}
