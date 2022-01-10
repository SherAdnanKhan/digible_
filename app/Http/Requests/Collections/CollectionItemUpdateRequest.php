<?php

namespace App\Http\Requests\Collections;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionItemUpdateRequest extends FormRequest
{
    public function authorize()
    {
        if (($this->collection && $this->collection_item->collection_id == $this->collection->id) &&
            ($this->user()->hasRole('admin') || $this->user()->id == $this->collection->user_id)) {
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
            'collection_item_type_id' => 'exists:collection_item_types,id',
            'name' => 'string|max:255',
            'image' => 'base64img',
            'description' => ['string', 'max:2000'],
            'edition' => ['string', 'max:255'],
            'price' => 'numeric|gte:0',
            'graded' => ['string', 'max:255'],
            'year' => 'digits:4|integer|min:1900|max:' . (date('Y') + 1) . '|' .
            Rule::unique('collection_items')->where(function ($query) {
                $query->where('name', $this->name)
                    ->where('year', $this->year);
            })->ignore($this->collection_item->id),
            'population' => ['integer'],
            'publisher' => ['string', 'max:255'],
            'available_for_sale' => 'integer|min:0|digits_between: 0,2',
            'available_at' => 'date_format:Y-m-d H:i:s|after:1 minute',
            'start_date' => 'date_format:Y-m-d H:i:s|after:1 minute',
            'end_date' => 'date_format:Y-m-d H:i:s|after:1 minute',
        ];
    }
    public function messages()
    {
        return [
            'year.unique' => 'Combination of name & year is not unique',
        ];
    }
}
