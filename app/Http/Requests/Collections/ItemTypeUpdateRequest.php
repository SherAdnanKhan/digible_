<?php

namespace App\Http\Requests\Collections;

use Illuminate\Foundation\Http\FormRequest;

class ItemTypeUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:collection_item_types',
            'label' => ['string', 'max:255'],
        ];
    }
}
