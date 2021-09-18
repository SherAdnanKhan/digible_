<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use Illuminate\Support\Arr;
use App\Models\CollectionItem;

class CollectionItemRepository
{
    
    public function getAll(Collection $collection)
    {
        return $collection->collectionitems()->with('collection.user', 'collectionItemType')->get();
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
