<?php

namespace App\Http\Repositories\Sellers;

use App\Models\SellerProfile;

class SellerRequestRepository
{
    public function getAll()
    {
        return SellerProfile::where(['status' => "pending"])->with('user')->get();
    }
    
    public function getApproved()
    {
        return SellerProfile::where(['status' => "approved"])->with('user')->get();
    }

    public function save(array $data): void
    {
        SellerProfile::create($data);
    }
}
