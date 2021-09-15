<?php

namespace App\Http\Repositories\Collections;

use App\Models\CollectionItem;
use Illuminate\Support\Arr;

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
        return $this->collectionItem->get();
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
