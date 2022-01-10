<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use Illuminate\Support\Facades\Auth;

class CollectionRepository
{
    public function getAll()
    {
        return Collection::approved()->with('user')->get();
    }

    public function getCurrentAll()
    {
        return Collection::where("user_id", auth()->user()->id)->with('user')->get();
    }

    public function getPending()
    {
        if (Auth::user()->hasRole(['seller'])) {
            return Collection::pending()->where('user_id', Auth::user()->id)->get();
        }
        return Collection::pending()->get();

    }

    public function getApproved()
    {
        if (Auth::user()->hasRole(['seller'])) {
            return Collection::approved()->where('user_id', Auth::user()->id)->get();
        }
        return Collection::approved()->get();
    }

    public function getRejected()
    {
        if (Auth::user()->hasRole(['seller'])) {
            return Collection::rejected()->where('user_id', Auth::user()->id)->get();
        }
        return Collection::rejected()->get();
    }

    public function getSold()
    {
        if (Auth::user()->hasRole(['seller'])) {
            return Collection::sold()->where('user_id', Auth::user()->id)->get();
        }
        return Collection::sold()->get();
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
