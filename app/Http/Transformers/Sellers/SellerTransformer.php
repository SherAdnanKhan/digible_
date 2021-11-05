<?php
namespace App\Http\Transformers\Sellers;

use App\Models\User;
use App\Models\SellerProfile;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Http\Transformers\Addresses\AddressTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;

class SellerTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'addresses'
    ];

    protected $availableIncludes = [
        'user',
    ];

    public function transform(SellerProfile $sellerProfile)
    {
        return [
            'id' => $sellerProfile->id,
            'name' => $sellerProfile->name,
            'surname' => $sellerProfile->surname,
            'wallet_address' => $sellerProfile->wallet_address,
            'phone_number' => $sellerProfile->phone_number,
            'twitter_link' => $sellerProfile->twitter_link,
            'insta_link' => $sellerProfile->insta_link,
            'twitch_link' => $sellerProfile->twitch_link,
            'type' => $sellerProfile->type,
            'status' => $sellerProfile->status,
            'id_image' => $sellerProfile->id_image,
            'address_image' => $sellerProfile->address_image,
            'insurance_image' => $sellerProfile->insurance_image,
            'code_image' => $sellerProfile->code_image,
            'created_at' => $sellerProfile->created_at,
            'updated_at' => $sellerProfile->updated_at,

        ];
    }

    public function includeUser(SellerProfile $sellerProfile)
    {
        $user = $sellerProfile->user;
        return $this->item($user, new UserTransformer);
    }

    public function includeAddresses(SellerProfile $sellerProfile)
    {
        $user = $sellerProfile->addresses;
        return $this->item($user, new AddressTransformer);
    }

    public function includeStatus(SellerProfile $sellerProfile)
    {
        $item = [
            'id' => $sellerProfile->id,
            'name' => data_get(SellerProfile::statuses(), $sellerProfile->status),
        ];
        return $this->item($item, new ConstantTransformer);
    }
}
