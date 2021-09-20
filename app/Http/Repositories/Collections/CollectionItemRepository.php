<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use App\Models\CollectionItem;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class CollectionItemRepository
{

    public function getAll()
    {
        $collectionItems = QueryBuilder::for(new CollectionItem)
                ->allowedFilters([AllowedFilter::exact("collection_item_type_id"),
                    AllowedFilter::exact('nft_type')])->with('collection.user', 'collectionItemType')->get();
        return $collectionItems;
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

}
