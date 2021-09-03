<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name'        => 'string|max:255',
            'last_name'         => 'string|max:255',
            'email'             => 'string|max:255|unique:users,email,'.auth()->id(),
            'country_id'        => 'integer|exists:countries,id',
            'username'          => 'string|max:255|unique:users,username,'.auth()->id(),
            'phone'             => 'string|max:255',
            'address'           => 'string|max:255',
            'address2'          => 'string|nullable|max:255',
            'address3'          => 'string|nullable|max:255',
            'county'            => 'string|nullable|max:255',
            'postcode'          => 'string|max:255',
            'city'              => 'string|max:255',
            'profile_image'     => 'base64img'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'base64img' => 'The image must be a type of png, jpg, jpeg',
        ];
    }
}
