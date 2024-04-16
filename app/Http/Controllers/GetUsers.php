<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeetingUserResource;
use App\Models\User;
use Illuminate\Http\Request;

class GetUsers extends Controller
{
    public function __invoke()
    {
        return MeetingUserResource::collection(User::all());
    }
}
