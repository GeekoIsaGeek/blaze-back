<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'bio' => 'string|max:650',
            'location' => 'string|max:100',
            'email' => 'string|email:strict',
            'username' => 'string|min:3|max:60',
        ];
    }
}
