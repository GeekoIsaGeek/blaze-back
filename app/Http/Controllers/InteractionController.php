<?php

namespace App\Http\Controllers;

use App\Enums\InteractionType;
use App\Events\MatchedEvent;
use App\Http\Resources\MatchedUserResource;
use App\Http\Resources\MeetingUserResource;
use App\Http\Resources\UserResource;
use App\Models\Interaction;
use App\Models\User;
use App\Services\PreferredUserRetrievalService;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class InteractionController extends Controller
{
    public function dislikeUser(User $user, PreferredUserRetrievalService $preferredUserRetrievalService): JsonResponse
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

    public function likeUser(User $user, PreferredUserRetrievalService $preferredUserRetrievalService): JsonResponse
    {

        try {
            if($user->id === auth()->user()->id) {
                throw new BadRequestException();
            }

            $matched = in_array(auth()->user()->id, collect($user->likes)->pluck('interactee_id')->toArray());

            if($matched) {
                // $user->interactionsAsInteractor()
                //     ->where('interactee_id', auth()->user()->id)
                //     ->update(["type" => InteractionType::MATCH]);
                // info('matched');

                MatchedEvent::broadcast(MatchedUserResource::make(auth()->user()), $user->id);
                MatchedEvent::broadcast(MatchedUserResource::make($user), auth()->user()->id);
            } else {
                // Interaction::updateOrCreate([
                //     "type" => InteractionType::LIKE,
                //     "interactor_id" => auth()->user()->id,
                //     "interactee_id" => $user->id
                // ]);
            }

            $users = $preferredUserRetrievalService->getUsers();
            return response()->json(MeetingUserResource::collection($users), 200);
        } catch(Error $error) {
            return response()->json($error, 400);
        }
    }
}
