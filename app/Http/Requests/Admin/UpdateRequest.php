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
            'name' => 'string|max:255|unique:users',
            'email' => 'string|max:255|email|unique:users',
            'password' => 'confirmed|string|min:6|max:255',
            'timezone' => 'timezone',
        ];
    }
}
