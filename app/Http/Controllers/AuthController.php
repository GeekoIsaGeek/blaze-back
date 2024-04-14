<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Laravel\Sanctum\PersonalAccessToken;
use Error;

class AuthController extends Controller
{
    public function register(RegistrationRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            User::create([
                "username" => $validated['username'],
                "email" => $validated['email'],
                "password" => bcrypt($validated['password']),
                "birthdate" => $validated['birthdate']
            ]);
            return response()->json('User just registered successfully', 200);
        } catch(Error $error) {
            return response()->json(["message" => $error], 401);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            if(auth()->attempt($validated, true)) {
                $user = User::where('email', $validated['email'])->first();
                $token = $user->createToken('authToken')->plainTextToken;
                return response()->json(['user' => UserResource::make($user),'token' => $token], 200);
            } else {
                throw new Error('Invalid credentials!');
            }

        } catch(Error $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }

    public function logout(): JsonResponse
    {
        PersonalAccessToken::where('tokenable_id', auth()->user()->id)->delete();
        return response()->json([], 200);
    }
}
