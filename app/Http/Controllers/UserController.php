<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UploadPhotoRequest;
use Error;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function uploadPhoto(UploadPhotoRequest $request): JsonResponse
    {
        try {
            $validatedImage = $request->validated()['image'];

            $imageName = $validatedImage->hashName();
            $image = $validatedImage->storeAs('images', $imageName);

            $photos = $request->user()->photos  ?? [];
            if(count($photos) > 5) {
                throw new Error("Gallery limit reached!");
            }
            $photos [] = ['id' => $image,'src' => $image];

            $request->user()->update(['photos' => $photos]);
            return response()->json(["image" => ['id' => $image,'src' => $image]], 200);

        } catch(Error $e) {
            return response()->json($e->getMessage(), 400);
        }
    }
}
