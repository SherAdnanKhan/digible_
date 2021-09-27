<?php
namespace App\Http\Services\Sellers;

use App\Http\Repositories\Sellers\SellerRequestRepository;
use App\Http\Services\BaseService;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SellerRequestService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(SellerRequestRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Seller data all fetched: ");
        $result = $this->repository->getAll();
        return $this->service->paginate($result);
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " -- Approved Sellers data all fetched: ");
        $result = $this->repository->getApproved();
        return $this->service->paginate($result);
    }

    public function save(array $data): void
    {
        $data['name'] = Auth::user()->name;
        $data['status'] = SellerProfile::STATUS_PENDING;
        $data['user_id'] = auth()->id();
        Log::info(__METHOD__ . " -- New Seller request info: ", $data);
        $this->repository->save($data);
    }

    public function update($data, SellerProfile $sellerProfile)
    {
        $sellerProfile->status = $data['status'];
        $sellerProfile->update();
        if ($data['status'] == 'approved') {
            $user = User::find($sellerProfile->user_id);
            $user->assignRole(['seller']);
        }
    }
}
