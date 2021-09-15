<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\CollectionRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Collections\CollectionService;
use App\Http\Services\Images\ImageDeleteService;
use App\Http\Services\Images\ImageUploadService;
use App\Models\Collection;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CollectionService extends BaseService
{
    protected $repository;
    protected $uploadService;
    protected $deleteService;
    protected $service;

    public function __construct(CollectionRepository $repository, ImageUploadService $uploadService, ImageDeleteService $deleteService)
    {
        $this->repository = $repository;
        $this->uploadService = $uploadService;
        $this->deleteService = $deleteService;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Collection data all fetched: ");
        return $this->repository->getAll();
    }

    public function save($image, array $data): void
    {
        try {
            $newData['image'] = null;
            if (isset($data['image'])) {
                $image = $this->uploadService->uploadImage($image, 'collections');
                $newData['image'] = $image['image_url'];
            }
            $newData['name'] = $data['name'];
            $newData['status'] = Arr::exists($data, 'status') ? $data['status'] : "Pending";
            $newData['user_id'] = Auth::user()->id;

            Log::info(__METHOD__ . " -- New collection request info: ", $newData);
            $this->repository->save($newData);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function delete(Collection $collection)
    {
        if (isset($collection['image'])) {
            $this->deleteService->removeImage($collection['image']);
        }
        $collection->delete();
    }

    public function update(Collection $collection, $image, array $data)
    {
        try {
            if (isset($data['image'])) {
                if ($collection['image']) {
                    $this->deleteService->removeImage($collection['image']);
                }
                $image = $this->uploadService->uploadImage($image, 'collections');
                $data['image'] = $image['image_url'];
            }
            $newData['name'] = $data['name'];
            $newData['status'] = Arr::exists($data, 'status') ? $data['status'] : "Pending";
            $newData['user_id'] = Auth::user()->id;
            $newData['image'] = Arr::exists($data, 'image') ? $data['image'] : null;
            $collection = $this->repository->update($newData, $collection);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collection;
    }
}
