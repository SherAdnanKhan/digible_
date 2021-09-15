<?php

namespace App\Http\Repositories\Collections;

use App\Models\CollectionItemType;

class ItemTypeRepository
{
    protected $collectionItemType;
    /**
     * @param array $
     */
    public function __construct(CollectionItemType $collectionItemType)
    {
        $this->collectionItemType = $collectionItemType;

    }

    public function getAll()
    {
        return $this->collectionItemType
            ->get();
    }

    public function save(array $data): void
    {
        $this->collectionItemType->create($data);
    }

    public function update(array $data, CollectionItemType $collectionItemType)
    {
        $collectionItemType->update($data);
        return $collectionItemType;
    }

}
