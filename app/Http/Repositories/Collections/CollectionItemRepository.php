<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Support\Facades\Event;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;

class CollectionItemRepository
{

    public function getAll(Collection $collection)
    {
        $collectionItems = QueryBuilder::for(new CollectionItem)
                ->where('collection_id', $collection->id)
                ->allowedFilters([AllowedFilter::exact("collection_item_type_id"),
                                 AllowedFilter::callback('priceBetween', function (Builder $query, $priceBetween) {
                                    $query->where('price', '>=', $priceBetween[0]);
                                    $query->where('price', '<=', $priceBetween[1]);
                                }),
                                AllowedFilter::callback('status', function (Builder $query, $status) {
                                    $query->where('available_for_sale', $status);
                                }),
                ])
                ->with('collection.user', 'collectionItemType', 'auction', 'auction.seller', 
                       'auction.buyer', 'lastBet', 'lastBet.seller', 'lastBet.buyer')->withCount('favorites')->get();
        return $collectionItems;
    }

    public function afsAll()
    {

        $collectionItems = QueryBuilder::for(new CollectionItem)
                ->allowedFilters([AllowedFilter::exact("collection_item_type_id"),
                                 AllowedFilter::callback('priceBetween', function (Builder $query, $priceBetween) {
                                    $query->where('price', '>=', $priceBetween[0]);
                                    $query->where('price', '<=', $priceBetween[1]);
                                }),
                                AllowedFilter::callback('status', function (Builder $query, $status) {
                                    $query->where('available_for_sale', $status);
                                }),
                ])
                ->with('collection.user', 'collectionItemType', 'auction', 'auction.seller', 
                'auction.buyer', 'lastBet', 'lastBet.seller', 'lastBet.buyer')->withCount('favorites')->get();
        return $collectionItems;
    }

    public function getPending()
    {
        return CollectionItem::where(['status' => CollectionItem::STATUS_PENDING])->with('collection.user', 'collectionItemType', 'auction', 'auction.seller', 
        'auction.buyer', 'lastBet', 'lastBet.seller', 'lastBet.buyer')->get();
    }

    public function getApproved()
    {
        return CollectionItem::where(['status' => CollectionItem::STATUS_APPROVED])->with('collection.user', 'collectionItemType', 'auction', 'auction.seller', 
        'auction.buyer', 'lastBet', 'lastBet.seller', 'lastBet.buyer')->get();
    }

    public function save(Collection $collection, array $data): void
    {
        $collection->collectionitems()->create($data);
    }

    public function update(CollectionItem $collectionItem, array $data)
    {
        $collectionItem->update($data);
        return $collectionItem;
    }

     public function updateAFS(CollectionItem $collectionItem, array $data)
    {
        $collectionItem->update($data);
        return $collectionItem;
    }

}
