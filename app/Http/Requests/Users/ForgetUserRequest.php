<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ForgetUserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|string|max:255|email|exists:users,email'
        ];
    }
}
