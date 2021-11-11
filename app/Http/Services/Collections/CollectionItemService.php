<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\CollectionItemRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Images\ImageService;
use App\Models\Collection;
use App\Models\CollectionItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
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
        // return $this->imageService->paginate($result);
    }

    public function afsAll()
    {
        Log::info(__METHOD__ . " -- Collection item data that are available for sale fetched all: ");
        return $this->repository->afsAll();
        // return $this->imageService->paginate($result);
    }

    public function getPending()
    {
        Log::info(__METHOD__ . " -- Pending Collection Item data all fetched: ");
        return $this->repository->getPending();
        // return $this->imageService->paginate($result);
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " -- Approved Collection Item data all fetched: ");
        return $this->repository->getApproved();
        // return $this->imageService->paginate($result);
    }

    public function save(Collection $collection, array $data): void
    {
        try {
            if (isset($data['image'])) {
                $image = $this->imageService->uploadImage($data['image'], 'collectionItems');
                $data['image'] = $image;
            }
            $data['status'] = CollectionItem::STATUS_PENDING;
            Log::info(__METHOD__ . " -- New collection request info: ", $data);
            $this->repository->save($collection, $data);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function delete(CollectionItem $collectionItem)
    {
        try {
            if (isset($collectionItem['image'])) {
                $this->imageService->removeImage($collectionItem['image']);
            }
            $collectionItem->delete();

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function update(CollectionItem $collectionItem, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($collectionItem['image']) {
                    $this->imageService->removeImage($collectionItem['image']);
                }
                $image = $this->imageService->uploadImage($data['image'], 'collectionItems');
                $data['image'] = $image;
            }
            $data['status'] = Arr::exists($data, 'status') ? $data['status'] : CollectionItem::STATUS_PENDING;
            $collectionItem = $this->repository->update($collectionItem, $data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collectionItem;
    }

    public function updateAFS(CollectionItem $collectionItem, array $data)
    {
        Log::info(__METHOD__ . " -- Collection item data updated: ");
        $collectionItem = $this->repository->updateAFS($collectionItem, $data);
        $data = $collectionItem->favoriteUsers();
        $users = $data->pluck('user');
        if ($this->imageService->dateComparision($collectionItem->available_at, Carbon::now()->toDateTimeString(), 'gt') &&
            $this->imageService->dateComparision($collectionItem->available_at, Carbon::now()->addDays(1), 'lt')) {
            $data['collectionItem'] = $collectionItem;
            $data['users'] = $users;
            Event::dispatch('subscribers.notify', $data);
        }
        // if ($this->imageService->dateComparision($collectionItem->available_at, Carbon::now()->addDays(1), 'gt')) {
        //     Favourite::query()
        //         ->where(['collection_item_id' => $collectionItem->id])
        //         ->each(function ($oldRecord) {
        //             $newDailyEmails = $oldRecord->replicate();
        //             $newDailyEmails->setTable('send_daily_emails');
        //             $newDailyEmails->save();
        //         });
        // }
        return $collectionItem;

    }
}
