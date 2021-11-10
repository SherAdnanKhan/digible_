<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'email' => 'string|max:255|unique:users,email,' . auth()->id(),
            'timezone' => 'timezone',
            'addresses.*.address' => 'string|max:255',
            'addresses.*.id' => 'exists:wallet_addresses,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
}
