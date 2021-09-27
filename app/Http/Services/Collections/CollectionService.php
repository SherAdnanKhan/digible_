<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\CollectionRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Images\ImageService;
use App\Models\Collection;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CollectionService extends BaseService
{
    protected $repository;
    protected $imageService;

    public function __construct(CollectionRepository $repository, ImageService $imageService)
    {
        $this->repository = $repository;
        $this->imageService = $imageService;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Collection data all fetched: ");
        $result = $this->repository->getAll();
        return $this->imageService->paginate($result);
    }

    public function getPending()
    {
        Log::info(__METHOD__ . " -- Pending Collection data all fetched: ");
        $result = $this->repository->getPending();
        return $this->imageService->paginate($result);
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " -- Approved Collection data all fetched: ");
        $result = $this->repository->getApproved();
        return $this->imageService->paginate($result);
    }

    public function save(array $data): void
    {
        try {
            if (isset($data['image'])) {
                $image = $this->imageService->uploadImage($data['image'], 'collections');
                $data['image'] = $image;
            }
            $data['status'] = Collection::STATUS_PENDING;
            $data['user_id'] = Auth::user()->id;
            Log::info(__METHOD__ . " -- New collection request info: ", $data);
            $this->repository->save($data);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function delete(Collection $collection)
    {
        if (isset($collection['image'])) {
            $this->imageService->removeImage($collection['image']);
        }
        $collection->delete();
    }

    public function update(Collection $collection, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($collection['image']) {
                    $this->imageService->removeImage($collection['image']);
                }
                $image = $this->imageService->uploadImage($data['image'], 'collections');
                $data['image'] = $image;
            }
            $data['status'] = Arr::exists($data, 'status') ? $data['status'] : Collection::STATUS_PENDING;
            $data['user_id'] = Auth::user()->id;
            $collection = $this->repository->update($collection, $data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collection;
    }
}
