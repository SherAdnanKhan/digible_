<?php
namespace App\Http\Services\Sellers;

use App\Models\User;
use App\Models\SellerProfile;
use App\Http\Services\BaseService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Images\ImageService;
use App\Http\Repositories\Sellers\SellerRequestRepository;

class SellerRequestService extends BaseService
{
    protected $repository;
    protected $service;
    protected $imageService;

    public function __construct(SellerRequestRepository $repository, BaseService $service, ImageService $imageService)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->imageService = $imageService;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Seller data all fetched: ");
        return $this->repository->getAll();
        // return $this->service->paginate($result);
    }

    public function getCurrent()
    {
        Log::info(__METHOD__ . " -- Seller data fetched: ");
        return $this->repository->getCurrent();
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " -- Approved Sellers data all fetched: ");
        return $this->repository->getApproved();
        // return $this->service->paginate($result);
    }

    public function save(array $data): void
    {
        $data['name'] = Auth::user()->name;
        $data['status'] = SellerProfile::STATUS_PENDING;
        $data['user_id'] = auth()->id();
        Log::info(__METHOD__ . " -- New Seller request info: ", $data);
        $this->repository->save($data);
    }

    public function reSave(SellerProfile $sellerProfile, array $data): void
    {
        $data['name'] = Auth::user()->name;
        $data['status'] = SellerProfile::STATUS_PENDING;
        $data['user_id'] = auth()->id();
        
        if (isset($data['id_image'])) {
            if ($sellerProfile['id_image']) {
                $this->imageService->removeImage($sellerProfile['id_image']);
            }
            $image = $this->imageService->uploadImage($data['id_image'], 'sellerProfiles');
            $data['id_image'] = $image;
        }

        if (isset($data['address_image'])) {
            if ($sellerProfile['address_image']) {
                $this->imageService->removeImage($sellerProfile['address_image']);
            }
            $image = $this->imageService->uploadImage($data['address_image'], 'sellerProfiles');
            $data['address_image'] = $image;
        }

        if (isset($data['insurance_image'])) {
            if ($sellerProfile['insurance_image']) {
                $this->imageService->removeImage($sellerProfile['insurance_image']);
            }
            $image = $this->imageService->uploadImage($data['insurance_image'], 'sellerProfiles');
            $data['insurance_image'] = $image;
        }

        if (isset($data['code_image'])) {
            if ($sellerProfile['code_image']) {
                $this->imageService->removeImage($sellerProfile['code_image']);
            }
            $image = $this->imageService->uploadImage($data['code_image'], 'sellerProfiles');
            $data['code_image'] = $image;
        }

        Log::info(__METHOD__ . " -- Update Seller request info: ", $data);
        $this->repository->reSave($sellerProfile,$data);
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
