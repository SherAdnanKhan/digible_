<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCompleteRequest extends FormRequest
{

    public function rules()
    {
        return [
            'authenication.api_key' => 'required|string|min:3|max:255',
            'authenication.api_pass' => 'required|string|min:3|max:255',
            'currency' => 'required|string|min:3|max:3',
        ];
    }
}
