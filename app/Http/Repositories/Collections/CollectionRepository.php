<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;

class CollectionRepository
{
    public function getAll()
    {
        return Collection::approved()->with('user')->get();
    }

    public function getCurrentAll()
    {
        return Collection::where("user_id", auth()->user()->id)->get();
    }

    public function getPending()
    {
        return Collection::pending()->get();
    }

    public function getApproved()
    {
        return Collection::approved()->get();
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
