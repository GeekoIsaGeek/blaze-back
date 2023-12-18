<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => ['required','min:6', 'unique:users,username'],
            'email' => ['required','email', 'unique:users,email'],
            'birthdate' => ['required','date'],
            'password' => ['required','min:8']
        ];
    }
}
