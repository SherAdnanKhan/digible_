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
            'name' => 'string|max:255|unique:collections',
            'logo_image' => 'base64img',
            'featured_image' => 'base64img',
            'banner_image' => 'base64img',
            'external_url' => ['string', 'max:255'],
            'description' => 'string|max:1000',
            'categories' => ['string', 'max:255'],
            'website' => ['string', 'max:255'],
            'discord' => ['string', 'max:255'],
            'twitter' => ['string', 'max:255'],
            'instagram' => ['string', 'max:255'],
            'medium' => ['string', 'max:255'],
            'telegram' => ['string', 'max:255'],
            'status' => ['string', 'max:255', Rule::in(array_keys(Collection::statuses()))],
        ];
    }

}
