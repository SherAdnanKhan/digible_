<?php
namespace App\Http\Transformers\Users;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\HearAboutUs\HearAboutUsPlatformTransformer;
use App\Models\User;

class UserTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'country', 'status'
    ];

    protected $availableIncludes = [
        'hearAboutUsPlatform'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'username' => $user->username,
            'email' => $user->email,
            'phone' => $user->phone,
            'address' => $user->address,
            'address2' => $user->address2,
            'address3' => $user->address3,
            'county' => $user->county,
            'postcode' => $user->postcode,
            'city' => $user->city,
            'is_kyc_verified' => $user->is_kyc_verified,
            'is_viewed' => $user->is_viewed,
            'is_admin' => $user->is_admin,
            'dob' => $user->dob,
            'profile_image' => (isset($user->profile_image) && !empty($user->profile_image)) ? asset("storage/$user->profile_image") : null,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ];
    }

    public function includeStatus(User $user)
    {
        $item = [
            'id' => $user->status,
            'name' => data_get(User::statuses(), $user->status)
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeCountry(User $user)
    {
        $item = [
            'id' => $user->country->id,
            'name' => $user->country->label
        ];

        return $this->item($item, new ConstantTransformer);
    }

    public function includeHearAboutUsPlatform(User $user)
    {
        if ($user->hearAboutUsPlatform) {
            return $this->item($user->hearAboutUsPlatform, new HearAboutUsPlatformTransformer);
        }
    }
}
