<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderCompleteRequest extends FormRequest
{

    public function rules()
    {
        return [
            'secretKey' => 'required|string|min:3|max:255',
            'currency' => 'required|string|min:3|max:3',
        ];
    }
}
