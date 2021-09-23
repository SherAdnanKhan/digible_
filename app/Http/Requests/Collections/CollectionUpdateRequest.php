<?php

namespace App\Http\Requests\Collections;

use App\Models\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollectionUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:collections',
            'image' => 'base64img',
            'status' => ['string', 'max:255', Rule::in(array_keys(Collection::statuses()))],
        ];
    }

}
