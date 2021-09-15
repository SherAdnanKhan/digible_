<?php
namespace App\Http\Transformers\Sellers;

use App\Models\User;
use App\Models\SellerProfile;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Users\UserTransformer;

class SellerTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'user',
    ];

    public function transform(SellerProfile $sellerProfile)
    {
        return [
            'id' => $sellerProfile->id,
            'name' => $sellerProfile->name,
            'surname' => $sellerProfile->surname,
            'wallet_address' => $sellerProfile->wallet_address,
            'physical_address' => $sellerProfile->physical_address,
            'phone_number' => $sellerProfile->phone_number,
            'twitter_link' => $sellerProfile->twitter_link,
            'insta_link' => $sellerProfile->insta_link,
            'twitch_link' => $sellerProfile->twitch_link,
            'type' => $sellerProfile->type,
            'status' => $sellerProfile->status,
            'created_at' => $sellerProfile->created_at,
            'updated_at' => $sellerProfile->updated_at,

        ];
    }

    public function includeUser(SellerProfile $sellerProfile)
    {
        $user = $sellerProfile->user;
        return $this->item($user, new UserTransformer);
    }
}
