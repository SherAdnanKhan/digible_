<?php

namespace App\Http\Repositories\Collections;

use App\Models\CollectionItemType;

class ItemTypeRepository
{
    public function getAll()
    {
        return CollectionItemType::get();
    }

    public function save(array $data): void
    {
        CollectionItemType::create($data);
    }

    public function update(CollectionItemType $collectionItemType, array $data)
    {
        $collectionItemType->update($data);
        return $collectionItemType;
    }

}
