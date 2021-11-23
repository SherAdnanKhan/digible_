<?php

namespace App\Http\Requests\Collections;

use App\Models\CollectionItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionItemSaveRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->collection && ($this->user()->hasRole('admin') ||
            $this->user()->id == $this->collection->user_id)) {
            return true;
        }
        return false;
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'collection_item_type_id' => 'required|exists:collection_item_types,id',
            'name' => 'required|string|max:255',
            'image' => 'base64img',
            'status' => ['string', 'max:255', Rule::in(array_keys(CollectionItem::statuses()))],
            'description' => ['string', 'max:400'],
            'edition' => ['string', 'max:255'],
            'price' => 'required|numeric|gte:0',
            'graded' => ['string', 'max:255'],
            'year' => 'required|digits:4|integer|min:1900|max:'.(date('Y')+1),
            'population' => ['integer'],
            'publisher' => ['string', 'max:255'],
            'available_for_sale' => 'required|integer|min:0|digits_between: 0,2',
            'available_at' => 'required_if:available_for_sale,==,1|date_format:Y-m-d H:i:s|after:1 minute',
            'start_date' => 'required_if:available_for_sale,==,2|date_format:Y-m-d H:i:s|after:1 minute',
            'end_date' => 'required_if:available_for_sale,==,2|date_format:Y-m-d H:i:s|after:1 minute',
        ];
    }
}
