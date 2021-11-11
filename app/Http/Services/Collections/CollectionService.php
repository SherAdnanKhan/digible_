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
        return $this->repository->getAll();
        // return $this->imageService->paginate($result);
    }

    public function getCurrentAll()
    {
        Log::info(__METHOD__ . " -- Collection data all fetched: ");
        return $this->repository->getCurrentAll();
        // return $this->imageService->paginate($result);
    }

    public function getPending()
    {
        Log::info(__METHOD__ . " -- Pending Collection data all fetched: ");
        return $this->repository->getPending();
        // return $this->imageService->paginate($result);
    }

    public function getApproved()
    {
        Log::info(__METHOD__ . " -- Approved Collection data all fetched: ");
        return $this->repository->getApproved();
        // return $this->imageService->paginate($result);
    }

    public function save(array $data): void
    {
        try {
            if (isset($data['logo_image'])) {
                $image = $this->imageService->uploadImage($data['logo_image'], 'collections');
                $data['logo_image'] = $image;
            }
            if (isset($data['featured_image'])) {
                $image = $this->imageService->uploadImage($data['featured_image'], 'collections');
                $data['featured_image'] = $image;
            }
            if (isset($data['banner_image'])) {
                $image = $this->imageService->uploadImage($data['banner_image'], 'collections');
                $data['banner_image'] = $image;
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
            if (isset($data['logo_image'])) {
                if ($collection['logo_image']) {
                    $this->imageService->removeImage($collection['logo_image']);
                }
                $image = $this->imageService->uploadImage($data['logo_image'], 'collections');
                $data['logo_image'] = $image;
            }

            if (isset($data['featured_image'])) {
                if ($collection['featured_image']) {
                    $this->imageService->removeImage($collection['featured_image']);
                }
                $image = $this->imageService->uploadImage($data['featured_image'], 'collections');
                $data['featured_image'] = $image;
            }
            
            if (isset($data['banner_image'])) {
                if ($collection['banner_image']) {
                    $this->imageService->removeImage($collection['banner_image']);
                }
                $image = $this->imageService->uploadImage($data['banner_image'], 'collections');
                $data['banner_image'] = $image;
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
