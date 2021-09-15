<?php

namespace App\Http\Requests\Collections;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionSaveRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:collections',
            'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:20000',
            'status' => ['string', 'max:255', Rule::in(array_keys(Collection::statuses()))],
        ];
    }
}
