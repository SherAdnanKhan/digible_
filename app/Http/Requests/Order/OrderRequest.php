<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'authenication.api_key' => 'required|string|min:3|max:255',
            'authenication.api_pass' => 'required|string|min:3|max:255',
            'items.*.collection_item_id' => 'required|exists:collection_items,id',
            'items.*.quantity' => 'required|numeric|gt:0',
            'items.*.currency' => 'required|string|min:3|max:3',
            'items.*.discount' => 'numeric|gte:0',
        ];
    }
}
