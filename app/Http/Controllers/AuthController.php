<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use Error;
use Illuminate\Http\JsonResponse;

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
                return response()->json($user, 200);
            } else {
                throw new Error('Invalid credentials!');
            }

        } catch(Error $error) {
            return response()->json(['message' => $error->getMessage()], 404);
        }
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        session()->flush();
        return response()->json([], 200);
    }
}
