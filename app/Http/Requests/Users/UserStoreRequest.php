<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'country_id' => 'required|integer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|max:255|email|unique:users',
            'password' => 'required|string|min:6|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'address2' => 'string|max:255|nullable',
            'address3' => 'string|max:255|nullable',
            'county' => 'string|max:255|nullable',
            'postcode' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            "dob" => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
            'ic' => 'string|max:255',
            'hear_about_us_platform_id' => 'integer|nullable|exists:hear_about_us_platforms,id'
        ];
    }

    public function messages()
    {
        return [
            'dob.before_or_equal' => trans('messages.date_of_birth_error'),
        ];
    }
}
