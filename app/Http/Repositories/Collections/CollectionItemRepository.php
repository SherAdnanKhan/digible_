<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use Illuminate\Support\Arr;
use App\Models\CollectionItem;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CollectionItemRepository
{
    
    public function getAll(Collection $collection)
    {
       $collection_item = QueryBuilder::for(new CollectionItem)
        ->allowedFilters([AllowedFilter::exact("collection_item_type_id"),
            AllowedFilter::exact('nft_type')])->with('collection.user', 'collectionItemType')->get();
        
        return $collection_item;
    }

    public function save(array $data , Collection $collection): void
    {
       $collection->collectionitems()->create($data);
    }

    public function update(array $data, CollectionItem $collectionItem , Collection $collection)
    {
        $collection->collectionitems()->find($collectionItem->id)->update($data);
        return $collectionItem;
    }

}
