<?php

namespace App\Http\Requests\Collections\Seller;

use Illuminate\Foundation\Http\FormRequest;

class CollectionItemUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'available_for_sale' => 'required|boolean',
        ];
    }
}
