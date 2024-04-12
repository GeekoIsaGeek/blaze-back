<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateGenderRequest;
use App\Models\Interest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function addInterest(Request $request, Interest $interest): JsonResponse
    {
        try {
            $isAlreadyAttached = $request->user()->interests()->where('interest_id', $interest->id)->exists();
            if($isAlreadyAttached) {
                return response()->json(["error" => "$interest->interest is already included in interests"], 400);
            }
            if($request->user()->interests()->count() >= 5) {
                return response()->json(["error" => "Only 5 interests can be selected"], 400);
            }
            $request->user()->interests()->attach($interest);
            return response()->json([], 201);
        } catch(Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function deleteInterest(Request $request, Interest $interest): JsonResponse
    {
        try {
            $isInterestAttached = $request->user()->interests()->where('interest_id', $interest->id)->exists();
            if(!$isInterestAttached) {
                return response()->json(["error" => "User interests does not include $interest->interest"], 400);
            }

            $request->user()->interests()->detach($interest);
            return response()->json([], 204);
        } catch(Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function updateGender(UpdateGenderRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            $request->user()->update(['gender' => $validated['gender']]);
            return response()->json([], 204);
        } catch(Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function addLanguage(Request $request, string $languageCode): JsonResponse
    {
        try {
            $languages = $request->user()->languages ?? [];
            if(in_array($languageCode, $languages)) {
                return response()->json(["error" => "Language is already added"], 400);
            }
            $request->user()->languages = array_merge($languages ?? [], [$languageCode]);
            $request->user()->save();
            return response()->json([], 204);
        } catch(Exception $error) {
            return response()->json($error, 500);
        }
    }

    public function deleteLanguage(Request $request, string $languageCode): JsonResponse
    {
        try {
            $languages = $request->user()->languages ?? [];
            if(!in_array($languageCode, $languages)) {
                return response()->json(["error" => "Language is not added"], 400);
            }
            $request->user()->languages = array_diff($languages, [$languageCode]);
            $request->user()->save();
            return response()->json([], 204);
        } catch(Exception $error) {
            return response()->json($error, 500);
        }
    }
}
