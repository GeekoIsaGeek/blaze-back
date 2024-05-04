<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMessageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'receiver_id' => 'required',
            'content' => 'required|string|max:600',
        ];
    }
}
