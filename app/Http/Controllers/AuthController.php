<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Error;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Request;

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
                return response()->json(['user' => $user,'token' => $token], 200);
            } else {
                throw new Error('Invalid credentials!');
            }

        } catch(Error $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        auth()->logout();
        $request->user()->token()->revoke();
        return response()->json([], 200);
    }
}
