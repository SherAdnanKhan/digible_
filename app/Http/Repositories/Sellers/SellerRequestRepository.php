<?php

namespace App\Http\Repositories\Sellers;

use App\Models\SellerProfile;

class SellerRequestRepository
{
    protected $sellerProfile;
    /**
     * @param array $
     */
    public function __construct(SellerProfile $sellerProfile)
    {
        $this->sellerProfile = $sellerProfile;

    }

    public function getAll()
    {
        return $this->sellerProfile->where(['status' => "pending"])->with('user')->get();
    }

    public function save(array $data): void
    {
        $this->sellerProfile->create($data);
    }
}
