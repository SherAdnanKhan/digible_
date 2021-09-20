<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use Illuminate\Support\Arr;

class CollectionRepository
{
    protected $collection;
    /**
     * @param array $
     */
    public function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }

    public function getAll()
    {
        return $this->collection->get();
    }

    public function getPending()
    {
        return $this->collection->where(['status' => Collection::STATUS_PENDING])->get();
    }

     public function getApproved()
    {
        return $this->collection->where(['status' => Collection::STATUS_APPROVED])->get();
    }

    public function save(array $data): void
    {
        $this->collection->create($data);
    }

    public function update(array $data, Collection $collection)
    {
        $collection->update($data);
        return $collection;
    }
}
