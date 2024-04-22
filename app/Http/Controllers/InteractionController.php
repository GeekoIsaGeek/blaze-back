<?php

namespace App\Http\Controllers;

use App\Enums\InteractionType;
use App\Http\Resources\MeetingUserResource;
use App\Http\Resources\UserResource;
use App\Models\Interaction;
use App\Models\User;
use App\Services\PreferredUserRetrievalService;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class InteractionController extends Controller
{
    public function addToDislikes(User $user, PreferredUserRetrievalService $preferredUserRetrievalService): JsonResponse
    {
        try {
            if($user->id === auth()->user()->id) {
                throw new BadRequestException();
            }
            Interaction::updateOrCreate([
                "type" => InteractionType::DISLIKE,
                "interactor_id" => auth()->user()->id,
                "interactee_id" => $user->id
            ]);

            $users = $preferredUserRetrievalService->getUsers();
            return response()->json(MeetingUserResource::collection($users), 200);
        } catch(Error $error) {
            return response()->json($error, 400);
        }
    }

    public function addToLikes(User $user, PreferredUserRetrievalService $preferredUserRetrievalService): JsonResponse
    {
        try {
            if($user->id === auth()->user()->id) {
                throw new BadRequestException();
            }
            Interaction::updateOrCreate([
                "type" => InteractionType::LIKE,
                "interactor_id" => auth()->user()->id,
                "interactee_id" => $user->id
            ]);

            $users = $preferredUserRetrievalService->getUsers();
            return response()->json(MeetingUserResource::collection($users), 200);
        } catch(Error $error) {
            return response()->json($error, 400);
        }
    }
}
