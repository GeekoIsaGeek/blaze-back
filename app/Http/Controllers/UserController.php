<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\Request;

class UserController extends Controller
{
    public function setInterests(Request $request): JsonResponse
    {
        return response()->json([], 200);
    }
}
