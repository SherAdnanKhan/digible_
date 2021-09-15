<?php

namespace App\Http\Requests\Sellers;

use App\Models\SellerProfile;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'status' => ['string', 'max:255', Rule::in(array_keys(SellerProfile::statuses()))],
        ];
    }
}
