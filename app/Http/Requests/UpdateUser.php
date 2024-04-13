<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    public function rules(): array
    {
        return [
            'bio' => 'string|max:650',
            'location' => 'string|max:100'
        ];
    }
}