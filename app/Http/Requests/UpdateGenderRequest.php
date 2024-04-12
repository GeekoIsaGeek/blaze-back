<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGenderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'gender' => 'string|in:male,female,other'
        ];
    }
}
