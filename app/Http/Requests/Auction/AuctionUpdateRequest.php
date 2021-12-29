<?php

namespace App\Http\Requests\Auction;

use Illuminate\Foundation\Http\FormRequest;

class AuctionUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "collection_item_id" => 'required|exists:collection_items,id',
        ];
    }
}
