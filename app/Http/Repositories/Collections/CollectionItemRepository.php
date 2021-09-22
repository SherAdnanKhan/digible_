<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Support\Facades\Event;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

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

     public function updateAFS(CollectionItem $collectionItem, array $data)
    {
        $collectionItem->update($data);
        $data = $collectionItem->favoriteUsers();
        $users = $data->pluck('user');
        $data['collectionItem'] = $collectionItem;
        $data['users'] = $users;
        Event::dispatch('subscribers.notify', $data);
        return $collectionItem;
    }

}
