<?php

namespace App\Http\Repositories\Collections;

use Illuminate\Support\Arr;
use App\Models\CollectionItem;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class CollectionItemRepository
{
    protected $collectionItem;
    /**
     * @param array $
     */
    public function __construct(CollectionItem $collectionItem)
    {
        $this->collectionItem = $collectionItem;

    }

    public function getAll()
    {
       $collection_item = QueryBuilder::for($this->collectionItem)
        ->allowedFilters([AllowedFilter::exact("collection_item_type_id"),
            AllowedFilter::exact('nft_type')])->get();
        
        return $collection_item;
    }

    public function save(array $data): void
    {
        $this->collectionItem->create($data);
    }

    public function update(array $data, CollectionItem $collectionItem)
    {
        $collectionItem->update($data);
        return $collectionItem;
    }

}
