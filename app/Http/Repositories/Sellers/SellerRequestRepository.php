<?php

namespace App\Http\Repositories\Sellers;

use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class SellerRequestRepository
{
    protected $seller;
    /**
     * @param array $
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;

    }

    public function getAll()
    {
        return $this->seller->where(['status' => "pending"])->with('user')->get();
    }

    public function getById($id)
    {
        return $this->seller
            ->where('id', $id)->with('user')
            ->get();
    }

    public function save(array $data): void
    {
        $seller = new $this->seller;
        $seller->name = Auth::user()->name;
        $seller->surname = $data['surname'];
        $seller->wallet_address = $data['wallet_address'];
        $seller->physical_address = $data['physical_address'];
        $seller->p_no = $data['p_no'];
        $seller->twitter_link = $data['twitter_link'];
        $seller->insta_link = $data['insta_link'];
        $seller->twitch_link = $data['twitch_link'];
        $seller->type = $data['type'];
        $seller->status = 'Pending';
        $seller->user_id = Auth::user()->id;
        $seller->save();
    }

    public function update($data, $id)
    {
        $seller = Seller::find($id);
        $seller->status = $data['status'];
        $seller->update();
        if ($data['status'] == 'Approved') {
            $user = User::find($seller->user_id);
            $user->assignRole(['seller']);
        }
    }

    public function delete($id)
    {
        $seller = $this->seller->find($id);
        $seller->delete();
        return $seller;
    }
}
