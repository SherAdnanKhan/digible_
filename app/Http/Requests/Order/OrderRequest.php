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
            'secretKey' => 'required|string|min:3|max:255',
            "items"    => "required|array",
            'items.*.collection_item_id' => 'required|exists:collection_items,id',
            'items.*.quantity' => 'required|numeric|gt:0',
            'currency' => 'required|string|min:3|max:3',
            'items.*.discount' => 'numeric|gte:0',
            'items.*.auction' => 'boolean'
        ];
    }
}
