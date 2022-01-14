<?php

namespace App\Http\Requests\Auction;

use App\Models\CollectionItem;
use Illuminate\Foundation\Http\FormRequest;

class AuctionSaveRequest extends FormRequest
{

    public function authorize()
    {
        $collection_item = CollectionItem::find($this->collection_item_id);
        if ($collection_item) {
            if ($this->user()->id == $collection_item->collection->user_id) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "collection_item_id" => 'required|exists:collection_items,id',
            "last_price" => 'required|numeric|gt:0',
        ];
    }
}
