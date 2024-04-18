<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeetingUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetUsersController extends Controller
{
    public function __invoke()
    {
        $preferences = auth()->user()->preference;

        $users = User::whereNot('id', auth()->user()->id)
            ->satisfyGenderPreference($preferences->show)
            ->satisfyAgePreference($preferences?->age_from, $preferences?->age_to)
            ->whereHas('photos')
            ->limit(10)
            ->get();

        return response()->json(MeetingUserResource::collection($users), 200);
    }
}
