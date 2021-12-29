<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6|max:255',
            'confirm_password'=> 'required_with:password|same:password|string|min:6|max:255',
            'timezone' => 'required|timezone',
        ];
    }
}
