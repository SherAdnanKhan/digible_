<?php

namespace App\Http\Repositories\Sellers;

use App\Models\SellerProfile;

class SellerRequestRepository
{
    public function getAll()
    {
        return SellerProfile::where(['status' => "pending"])->with('user','addresses')->get();
    } 

    public function getCurrent()
    {
        return SellerProfile::where('user_id', auth()->user()->id)->with('user','addresses')->get();
    } 
    
    public function getApproved()
    {
        return SellerProfile::where(['status' => "approved"])->with('user','addresses')->get();
    }

    public function save(array $data): void
    {
       $sellerProfile = SellerProfile::create($data);
       $sellerProfile->addresses()->create($data);
    }

    public function reSave(SellerProfile $sellerProfile, array $data): void
    {
       $sellerProfile->update($data);
       $allowedKeys = ['address', 'address2', 'country', 'state', 'city', 'postalcode', 'kind'];
       $filteredAddressData = array_filter(
        $data,
        function ($key) use ($allowedKeys) {
            return in_array($key, $allowedKeys);
        },
        ARRAY_FILTER_USE_KEY
    );
       $sellerProfile->addresses()->update($filteredAddressData);
    }
}
