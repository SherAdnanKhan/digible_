<?php

namespace App\Http\Requests\Sellers;

use App\Models\SellerProfile;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'surname' => 'required|string|max:255',
            'wallet_address' => 'required|string|max:255',
            'physical_address' => 'required|string|max:255',
            'phone_no' => 'required|string|max:255',
            'twitter_link' => 'required|string|max:255',
            'insta_link' => 'required|string|max:255',
            'twitch_link' => 'required|string|max:255',
            'type' => ['string', 'max:255', Rule::in(array_keys(SellerProfile::typees()))],
        ];
    }
}
