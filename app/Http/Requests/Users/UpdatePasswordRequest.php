<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Validation\Rule;
use App\Models\User;


class UpdatePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required|string|min:6|max:255',
            'new_password'=> 'required_with:password|string|min:6|max:255',
            'confirm_password'=> 'required_with:new_password|same:new_password|string|min:6|max:255',
        ];
    }
}
