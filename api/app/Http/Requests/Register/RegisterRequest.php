<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize() {
        return true;
    }

    public function rules() {
        return [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols() ],
            'password_confirmation' => ['required']
        ];
    }
}