<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Http\Resources\MeetingUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetUsers extends Controller
{
    public function __invoke()
    {
        $preferences = auth()->user()->preference;

        $users = User::whereNot('id', auth()->user()->id)
            ->satisfyGenderPreference($preferences->show)
            ->satisfyAgePreference($preferences?->age_from, $preferences?->age_to)
            ->get();

        return response()->json(MeetingUserResource::collection($users), 200);
    }
}