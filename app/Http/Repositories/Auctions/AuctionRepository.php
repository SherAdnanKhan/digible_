<?php

namespace App\Http\Repositories\Auctions;

use App\Models\Auction;
use App\Models\User;

class AuctionRepository
{
    public function getWonBets()
    {
        $auctions = Auction::where(['buyer_id' => auth()->user()->id, 'status' => Auction::STATUS_PENDING])
            ->with('collectionItem')->get()->groupBy('collection_item_id');
        return $auctions;
    }

    public function save(array $data)
    {
        return Auction::create($data);
    }

    public function getByUser()
    {
        $auctions = Auction::where(['buyer_id' => auth()->user()->id, 'status' => Auction::STATUS_PENDING])
            ->with('collectionItem')->get()->groupBy('collection_item_id');
        return $auctions;
    }
}
