<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collection_item_id' => 'required|exists:collection_items,id',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required',
            'quantity' => 'required',
        ];
    }
}
