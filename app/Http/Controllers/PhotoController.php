<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UploadPhotoRequest;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Error;

class PhotoController extends Controller
{
    public function uploadPhoto(UploadPhotoRequest $request): JsonResponse
    {
        try {
            $validatedImage = $request->validated()['image'];

            $photos = $request->user()->photos  ?? [];

            if(count($photos) > 5) {
                throw new Error("Gallery limit reached!");
            }

            $imageName = $validatedImage->hashName();
            $photo = $validatedImage->storeAs('photos', $imageName);

            $photo = Photo::create(['user_id' => $request->user()->id, 'url' => $photo]);
            return response()->json(["image" => $photo], 200);
        } catch(Error $e) {
            return response()->json($e->getMessage(), 400);
        }
    }

    public function deletePhoto(int $id): JsonResponse
    {
        try {
            $photo = Photo::find($id);
            if(!$photo) {
                throw new Error("Photo not found!");
            }
            if(Storage::exists($photo->url)) {
                Storage::delete($photo->url);
            }
            $photo->delete();
            return response()->json([], 200);
        } catch(Error $e) {
            return response()->json(["error" => $e->getMessage()], 400);
        }
    }
}
