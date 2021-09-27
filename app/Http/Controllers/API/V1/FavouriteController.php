<?php

namespace App\Http\Controllers\API\V1;

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Http\Controllers\Controller;
use App\Http\Services\Favourites\FavouriteService;

class FavouriteController extends Controller
{
    protected $service;

    public function __construct(FavouriteService $service)
    {
        $this->service = $service;
    }

    public function favourite(Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->favourite($collectionItem);
        return $this->success([], null, trans('messages.collection_item_favourite_success'));
    }

    public function unFavourite(Collection $collection, CollectionItem $collectionItem)
    {
        $this->service->unFavourite($collectionItem);
        return $this->success([], null, trans('messages.collection_item_unfavourite_success'));
    }

    public function myFavorites(CollectionItem $collectionItem)
    {
        $result = $this->service->myFavorites($collectionItem);
        return $result;
    }
}
