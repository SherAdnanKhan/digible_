<?php
namespace App\Http\Transformers\Collections;

use App\Http\Transformers\Auctions\AuctionTransformer;
use App\Http\Transformers\BaseTransformer;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Http\Transformers\Collections\ItemTypeTransformer;
use App\Http\Transformers\Constants\ConstantTransformer;
use App\Models\CollectionItem;

class CollectionItemTransformer extends BaseTransformer
{
    protected $defaultIncludes = [
        'status', 'auction', 'lastbet', 'collectionItemtype',
    ];

    public function transform(CollectionItem $collectionItem)
    {
        return [
            'id' => $collectionItem->id,
            'name' => $collectionItem->name,
            'label' => $collectionItem->label,
            'image' => $collectionItem->image,
            'image_path' => $collectionItem->image_path,
            'description' => $collectionItem->description,
            'edition' => $collectionItem->edition,
            'graded' => $collectionItem->graded,
            'year' => $collectionItem->year,
            'price' => $collectionItem->price,
            'population' => $collectionItem->population,
            'publisher' => $collectionItem->publisher,
            'status' => $collectionItem->status,
            'available_for_sale' => $collectionItem->available_for_sale,
            'available_at' => $collectionItem->available_at,
            'start_date' => $collectionItem->start_date,
            'end_date' => $collectionItem->end_date,
            'created_at' => $collectionItem->created_at,
            'updated_at' => $collectionItem->updated_at,
            'favorites_count' => $collectionItem->favorites_count,
            'collection' => $collectionItem->collection

        ];
    }

    public function includeCollectionItemType(CollectionItem $collectionItem)
    {
        $collectionItemType = $collectionItem->collectionItemType;
        return $this->item($collectionItemType, new ItemTypeTransformer);
    }

    public function includeStatus(CollectionItem $collectionItem)
    {
        $item = [
            'id' => $collectionItem->id,
            'name' => data_get(CollectionItem::statuses(), $collectionItem->status),
        ];
        return $this->item($item, new ConstantTransformer);
    }

    public function includeAuction(CollectionItem $collectionItem)
    {
        if (isset($collectionItem->auction)) {
            $auctions = $collectionItem->auction;
            return $this->collection($auctions, new AuctionTransformer);
        }
    }

    public function includeLastBet(CollectionItem $collectionItem)
    {
        if (isset($collectionItem->lastBet)) {
            $lastBet = $collectionItem->lastBet;
            return $this->item($lastBet, new AuctionTransformer);
        }
    }

}
