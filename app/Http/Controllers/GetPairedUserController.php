<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeetingUserResource;
use App\Models\Pair;
use App\Models\User;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GetPairedUserController extends Controller
{
    public function __invoke(User $user): JsonResponse
    {
        try {
            $matches = auth()->user()->matches ?? [];
            $isMatched = in_array($user->id, $matches->pluck('id')->toArray());

            if(!$isMatched) {
                throw new BadRequestException();
            }

            return response()->json(MeetingUserResource::make($user), 200);

        } catch(Error $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
