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
            'available_for_sale' => 'required|integer|min:0|digits_between: 0,2',
            'available_at' => 'required_if:available_for_sale,==,1|date_format:Y-m-d H:i:s|after:1 minute',
            'start_date' => 'required_if:available_for_sale,==,2|date_format:Y-m-d H:i:s',
            'end_date' => 'required_if:available_for_sale,==,2|date_format:Y-m-d H:i:s',
        ];
    }
}
