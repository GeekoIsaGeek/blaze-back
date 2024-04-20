<?php

namespace App\Http\Controllers;

use App\Http\Resources\MeetingUserResource;
use App\Services\PreferredUserRetrievalService;
use Illuminate\Http\JsonResponse;

class GetUsersController extends Controller
{
    public function __invoke(PreferredUserRetrievalService $preferredUserRetrievalService): JsonResponse
    {

        $users = $preferredUserRetrievalService->getUsers();

        return response()->json(MeetingUserResource::collection($users), 200);
    }
}
