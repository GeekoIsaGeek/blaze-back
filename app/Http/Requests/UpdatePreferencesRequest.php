<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreferencesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'show' => 'string|in:male,female,everyone',
            'age_from' => 'integer|min:18',
            'age_to' => 'integer|min:19',
        ];
    }
}
