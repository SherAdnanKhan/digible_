<?php

namespace App\Http\Requests\Sellers;

use App\Models\SellerProfile;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ReverifyCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id_image' => 'required|base64img',
            'address_image' => 'required|base64img',
            'insurance_image' => 'required|base64img',
            'code_image' => 'required|base64img',
            'surname' => 'string|max:255',
            'wallet_address' => 'string|max:255',
            'address' => 'string|max:255',
            'address2' => 'string|max:255',
            'country' => 'string|max:255',
            'state' => 'string|max:255',
            'city' => 'string|max:255',
            'postalcode' => 'string|max:255',
            'phone_no' => 'required|string|max:255',
            'twitter_link' => 'string|max:255',
            'insta_link' => 'string|max:255',
            'twitch_link' => 'string|max:255',
            'type' => ['string', 'max:255', Rule::in(array_keys(SellerProfile::types()))],
        ];
    }
}
