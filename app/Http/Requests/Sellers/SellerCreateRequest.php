<?php

namespace App\Http\Requests\Sellers;

use Illuminate\Foundation\Http\FormRequest;

class SellerCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

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
            'p_no' => 'required|string|max:255',
            'twitter_link' => 'required|string|max:255',
            'insta_link' => 'required|string|max:255',
            'twitch_link' => 'required|string|max:255',
            'type' => 'in:individual,cardhouse,digi',
        ];
    }
}
