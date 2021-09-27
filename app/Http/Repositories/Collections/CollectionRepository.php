<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use Illuminate\Support\Arr;

class CollectionRepository
{
    public function getAll()
    {
        return Collection::with('user')->get();
    }

    public function getPending()
    {
        return Collection::where(['status' => Collection::STATUS_PENDING])->get();
    }

    public function getApproved()
    {
        return Collection::where(['status' => Collection::STATUS_APPROVED])->get();
    }

    public function save(array $data): void
    {
        Collection::create($data);
    }

    public function update(Collection $collection, array $data)
    {
        $collection->update($data);
        return $collection;
    }
}
