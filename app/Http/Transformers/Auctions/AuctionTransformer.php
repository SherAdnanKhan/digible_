<?php
namespace App\Http\Transformers\Auctions;

use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Http\Transformers\Users\UserTransformer;
use App\Models\Auction;
use App\Models\User;

class AuctionTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'seller', 'buyer',
    ];

    public function transform(Auction $auction)
    {
        return [
            'id' => $auction->id,
            'collection_item_id' => $auction->collection_item_id,
            'buyer_id' => $auction->buyer_id,
            'seller_id' => $auction->seller_id,
            'base_price' => $auction->base_price,
            'last_price' => $auction->last_price,
            'status' => $auction->status,
            'created_at' => $auction->created_at,
            'updated_at' => $auction->updated_at,
        ];
    }

    public function includeSeller(Auction $auction)
    {
        $user = User::where('id', $auction->seller_id)->first();
        if ($user) {
            return $this->item($user, new UserTransformer);
        }
    }

    public function includeBuyer(Auction $auction)
    {
        $user = User::where('id', $auction->buyer_id)->first();
        if ($user) {
            return $this->item($user, new UserTransformer);
        }
    }

    public function includeStatus(Auction $auction)
    {
        $item = [
            'id' => $auction->id,
            'name' => data_get(Auction::statuses(), $auction->status),
        ];
        return $this->item($item, new ConstantTransformer);
    }
}
