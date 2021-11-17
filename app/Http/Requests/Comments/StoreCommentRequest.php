<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'comment' => 'required|string|max:255',
            'collection_id' => 'required_without:collection_item_id|exists:collections,id',
            'collection_item_id' => 'required_without:collection_id|exists:collection_items,id',
        ];
    }

    public function messages()
    {
        return [
            'collection_id.required_without' => trans('validation.required'),
            'collection_item_id.required_without' => trans('validation.required'),
        ];
    }
}
