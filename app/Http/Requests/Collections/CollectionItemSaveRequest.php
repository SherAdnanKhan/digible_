<?php

namespace App\Http\Requests\Collections;

use App\Models\CollectionItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionItemSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collection_item_type_id' => 'required|exists:collection_item_types,id',
            'nft_type' => ['required', Rule::in(array_keys(CollectionItem::nfttype()))],
            'name' => 'required|string|max:255|unique:collection_items',
            'image' => 'base64img',
            'status' => ['string', 'max:255', Rule::in(array_keys(CollectionItem::statuses()))],
            'description' => ['string', 'max:255'],
            'edition' => ['string', 'max:255'],
            'graded' => ['string', 'max:255'],
            'year' => ['string', 'max:255'],
            'population' => ['string', 'max:255'],
            'publisher' => ['string', 'max:255'],
            'available_for_sale' => 'boolean',
        ];
    }
}
