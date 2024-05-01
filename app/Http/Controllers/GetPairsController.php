<?php

namespace App\Http\Controllers;

use App\Enums\InteractionType;
use App\Http\Resources\MeetingUserResource;
use App\Http\Resources\UserResource;
use App\Models\Interaction;
use App\Models\Message;
use App\Models\User;
use Error;
use Illuminate\Http\Request;

class GetPairsController extends Controller
{
    public function __invoke()
    {
        try {
            $matches = auth()->user()->matches;
            dd($matches);
            return response()->json(MeetingUserResource::collection($matches), 200);
        } catch(Error $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
