<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:users,name,'. auth()->id(),
            'email' => 'required|string|max:255|email|unique:users,email,'. auth()->id(),
            'password' => 'confirmed|string|min:6|max:255',
            'timezone' => 'timezone',
        ];
    }
}
