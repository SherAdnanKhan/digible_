<?php

namespace App\Http\Requests\Collections\Admin;

use App\Models\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CollectionUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(Collection::statuses()))],
        ];
    }
}
