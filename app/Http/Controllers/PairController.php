<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeetingUserResource;
use App\Models\Pair;
use App\Models\User;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PairController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $matches = auth()->user()->newMatches;
            return response()->json(MeetingUserResource::collection($matches), 200);
        } catch(Error $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    public function show(User $user): JsonResponse
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

    public function destroy(User $user): JsonResponse
    {
        try {
            Pair::where(function ($subQuery) use ($user) {
                $subQuery->where('matchee_id', auth()->user()->id)
                    ->where('matcher_id', $user->id);
            })
            ->orWhere(function ($subQuery) use ($user) {
                $subQuery->where('matchee_id', $user->id)
                    ->where('matcher_id', auth()->user()->id);
            })->first()->delete();

            return response()->json([], 200);
        } catch(Error $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }
}
