<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\CollectionItemRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Images\ImageDeleteService;
use App\Http\Services\Images\ImageUploadService;
use App\Models\CollectionItem;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CollectionItemService extends BaseService
{
    protected $repository;
    protected $uploadService;
    protected $deleteService;
    protected $service;

    public function __construct(CollectionItemRepository $repository, ImageUploadService $uploadService, ImageDeleteService $deleteService)
    {
        $this->repository = $repository;
        $this->uploadService = $uploadService;
        $this->deleteService = $deleteService;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Collection item data all fetched: ");
        return $this->repository->getAll();
    }

    public function filter()
    {

        Log::info(__METHOD__ . " -- Filter collection item data all fetched: ");
        return $this->repository->filter();
    }

    public function save($image, array $data): void
    {
        try {
            $newData['image'] = null;
            if (isset($data['image'])) {
                $image = $this->uploadService->uploadImage($image, 'collectionsItem');
                $newData['image'] = $image['image_url'];
            }
            $newData['collection_item_type_id'] = $data['collection_item_type_id'];
            $newData['collection_id'] = $data['collection_id'];
            $newData['nft_type'] = Arr::exists($data, 'nft_type') ? $data['nft_type'] : 'non_nft';
            $newData['name'] = $data['name'];
            $newData['description'] = Arr::exists($data, 'description') ? $data['description'] : null;
            $newData['edition'] = Arr::exists($data, 'edition') ? $data['edition'] : null;
            $newData['graded'] = Arr::exists($data, 'graded') ? $data['graded'] : null;
            $newData['year'] = Arr::exists($data, 'year') ? $data['year'] : null;
            $newData['population'] = Arr::exists($data, 'population') ? $data['population'] : null;
            $newData['publisher'] = Arr::exists($data, 'publisher') ? $data['publisher'] : null;
            $newData['status'] = Arr::exists($data, 'status') ? $data['status'] : "Pending";
            Log::info(__METHOD__ . " -- New collection request info: ", $newData);
            $this->repository->save($newData);
        } catch (Exception $e) {
            throw new ErrorException($e);
        }
    }

    public function delete(CollectionItem $collectionItem)
    {
        try {
            if (isset($collectionItem['image'])) {
                $this->deleteService->removeImage($collectionItem['image']);
            }
            $collectionItem->delete();

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function update(CollectionItem $collectionItem, $image, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($collectionItem['image']) {
                    $this->deleteService->removeImage($collectionItem['image']);
                }
                $image = $this->uploadService->uploadImage($image, 'collectionsItem');
                $data['image'] = $image['image_url'];
            }
            $newData['collection_item_type_id'] = $data['collection_item_type_id'];
            $newData['collection_id'] = $data['collection_id'];
            $newData['nft_type'] = Arr::exists($data, 'nft_type') ? $data['nft_type'] : 'non_nft';
            $newData['name'] = $data['name'];
            $newData['image'] = Arr::exists($data, 'image') ? $data['image'] : null;
            $newData['description'] = Arr::exists($data, 'description') ? $data['description'] : null;
            $newData['edition'] = Arr::exists($data, 'edition') ? $data['edition'] : null;
            $newData['graded'] = Arr::exists($data, 'graded') ? $data['graded'] : null;
            $newData['year'] = Arr::exists($data, 'year') ? $data['year'] : null;
            $newData['population'] = Arr::exists($data, 'population') ? $data['population'] : null;
            $newData['publisher'] = Arr::exists($data, 'publisher') ? $data['publisher'] : null;
            $newData['status'] = Arr::exists($data, 'status') ? $data['status'] : "Pending";

            $collectionItem = $this->repository->update($newData, $collectionItem);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collectionItem;

    }
}
