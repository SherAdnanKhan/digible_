<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmPasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:6|max:255',
        ];
    }
}
