<?php
namespace App\Http\Services\Sellers;

use App\Http\Repositories\Sellers\SellerRequestRepository;
use App\Http\Services\BaseService;
use App\Models\SellerProfile;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SellerRequestService extends BaseService
{
    protected $repository;

    public function __construct(SellerRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Seller data all fetched: ");
        return $this->repository->getAll();
    }

    public function save(array $data): void
    {
        $newData['name'] = Auth::user()->name;
        $newData['surname'] = Arr::exists($data, 'surname') ? $data['surname'] : null;
        $newData['wallet_address'] = Arr::exists($data, 'wallet_address') ? $data['wallet_address'] : null;
        $newData['physical_address'] = Arr::exists($data, 'physical_address') ? $data['physical_address'] : null;
        $newData['phone_no'] = Arr::exists($data, 'phone_no') ? $data['phone_no'] : null;
        $newData['twitter_link'] = Arr::exists($data, 'twitter_link') ? $data['twitter_link'] : null;
        $newData['insta_link'] = Arr::exists($data, 'insta_link') ? $data['insta_link'] : null;
        $newData['twitch_link'] = Arr::exists($data, 'twitch_link') ? $data['twitch_link'] : null;
        $newData['type'] = Arr::exists($data, 'type') ? $data['type'] : null;
        $newData['status'] = 'Pending';
        $newData['user_id'] = auth()->id();

        Log::info(__METHOD__ . " -- New Seller request info: ", $data);
        $this->repository->save($newData);
    }

    public function update($data, $id)
    {
        $sellerProfile = SellerProfile::find($id);
        $sellerProfile->status = $data['status'];
        $sellerProfile->update();
        if ($data['status'] == 'approved') {
            $user = User::find($sellerProfile->user_id);
            $user->assignRole(['seller']);
        }
    }
}
