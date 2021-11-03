<?php

namespace App\Http\Repositories\Sellers;

use App\Models\SellerProfile;

class SellerRequestRepository
{
    public function getAll()
    {
        return SellerProfile::where(['status' => "pending"])->with('user','addresses')->get();
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
}
