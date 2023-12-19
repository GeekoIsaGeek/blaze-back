<?php

namespace App\Http\Requests\Photo;

use Illuminate\Foundation\Http\FormRequest;

class UploadPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => ['required','image','max:2048','mimes:png,jpg,webp']
        ];
    }
}
