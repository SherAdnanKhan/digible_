<?php
namespace App\Http\Services\Favourites;

use App\Http\Repositories\Favourites\FavouriteRepository;
use App\Http\Services\BaseService;
use App\Models\CollectionItem;
use Illuminate\Support\Facades\Log;

class FavouriteService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(FavouriteRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function favourite(CollectionItem $collectionItem)
    {
        Log::info(__METHOD__ . " -- User favourited an collection item: ");
        $this->repository->favourite($collectionItem);
    }

    public function unfavourite(CollectionItem $collectionItem)
    {
        Log::info(__METHOD__ . " -- User unFavourited an collection item: ");
        $this->repository->unFavourite($collectionItem);
    }

    public function myFavorites()
    {
        Log::info(__METHOD__ . " -- User unFavourited an collection item: ");
        $result = $this->repository->myFavorites();
        return $this->service->paginate($result);
    }

}
