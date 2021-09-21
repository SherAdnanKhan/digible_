<?php

namespace App\Http\Repositories\Favourites;

use App\Models\CollectionItem;
use Illuminate\Support\Facades\Auth;

class FavouriteRepository
{
    public function favourite(CollectionItem $collectionItem)
    {
        if (!Auth::user()->favourites->contains($collectionItem->id)) {
            Auth::user()->favourites()->attach($collectionItem->id);
        }
    }

    public function unfavourite(CollectionItem $collectionItem)
    {
        if (Auth::user()->favourites->contains($collectionItem->id)) {
            Auth::user()->favourites()->detach($collectionItem->id);
        }
    }

    public function myFavorites()
    {
        $myFavorites = Auth::user()->favourites;
        return $myFavorites;
    }
}