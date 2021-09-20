<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\ItemTypeRepository;
use App\Http\Services\BaseService;
use App\Models\CollectionItemType;
use Exception;
use Illuminate\Support\Facades\Log;

class ItemTypeService extends BaseService
{
    protected $repository;
    protected $service;

    public function __construct(ItemTypeRepository $repository, BaseService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Collection item type data all fetched: ");
        $result = $this->repository->getAll();
        return $this->service->paginate($result);
    }

    public function save(array $data): void
    {
        try {
            Log::info(__METHOD__ . " -- New collection item type request info: ", $$data);
            $this->repository->save($data);
        } catch (Exception $e) {
            throw new ErrorException(trans('messages.general_error'));
        }
    }

    public function update(CollectionItemType $collectionItemType, array $data)
    {
        try {
            $collectionItemType = $this->repository->update($collectionItemType, $data);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collectionItemType;
    }

    public function delete(CollectionItemType $collectionItemType)
    {
        $collectionItemType->delete();
    }
}
