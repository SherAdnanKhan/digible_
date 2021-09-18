<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\CollectionItemRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Images\ImageService;
use App\Models\Collection;
use App\Models\CollectionItem;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class CollectionItemService extends BaseService
{
    protected $repository;
    protected $imageService;

    public function __construct(CollectionItemRepository $repository, ImageService $imageService)
    {
        $this->repository = $repository;
        $this->imageService = $imageService;
    }

    public function getAll(Collection $collection)
    {
        Log::info(__METHOD__ . " -- Collection item data all fetched: ");
        return $this->repository->getAll($collection);
    }

    public function save(array $data, Collection $collection): void
    {
        try {
            if (isset($data['image'])) {
                $image = $this->imageService->uploadImage($data['image'], 'collectionItems');
                $data['image'] = $image;
            }
            $data['status'] = CollectionItem::STATUS_PENDING;
            $data['nft_type'] = 'non_nft';
            Log::info(__METHOD__ . " -- New collection request info: ", $data);
            $this->repository->save($data, $collection);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function delete(CollectionItem $collectionItem)
    {
        try {
            if (isset($collectionItem['image'])) {
                $this->imageService->removeImage($collection['image']);
            }
            $collectionItem->delete();

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function update(CollectionItem $collectionItem, Collection $collection, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($collectionItem['image']) {
                    $this->imageService->removeImage($collection['image']);
                }
                $image = $this->imageService->uploadImage($data['image'], 'collectionItems');
                $data['image'] = $image;
            }
            $data['status'] = Arr::exists($data, 'status') ? $data['status'] : CollectionItem::STATUS_PENDING;
            $data['nft_type'] = 'non_nft';
            $collectionItem = $this->repository->update($data, $collectionItem, $collection);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collectionItem;

    }
}
