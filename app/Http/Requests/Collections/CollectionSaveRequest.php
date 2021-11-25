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
            'logo_image' => 'required|base64img',
            'featured_image' => 'nullable|base64img',
            'banner_image' => 'nullable|base64img',
            'external_url' => ['nullable', 'string', 'max:255'],
            'description' => 'required|string|max:1000',
            'categories' => ['nullable','string', 'max:255'],
            'website' => ['nullable','string', 'max:255'],
            'discord' => ['nullable','string', 'max:255'],
            'twitter' => ['nullable','string', 'max:255'],
            'instagram' => ['nullable','string', 'max:255'],
            'medium' => ['nullable','string', 'max:255'],
            'telegram' => ['nullable','string', 'max:255'],
            'status' => ['nullable','string', 'max:255', Rule::in(array_keys(Collection::statuses()))],
        ];
    }
}
