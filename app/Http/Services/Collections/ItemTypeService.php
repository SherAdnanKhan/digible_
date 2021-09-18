<?php
namespace App\Http\Services\Collections;

use App\Exceptions\ErrorException;
use App\Http\Repositories\Collections\ItemTypeRepository;
use App\Http\Services\BaseService;
use App\Models\CollectionItemType;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class ItemTypeService extends BaseService
{
    protected $repository;

    public function __construct(ItemTypeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        Log::info(__METHOD__ . " -- Collection item type data all fetched: ");
        return $this->repository->getAll();
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
            $collectionItemType = $this->repository->update($data, $collectionItemType);

        } catch (Exception $e) {
            Log::info($e->getMessage());
            throw new ErrorException(trans('messages.general_error'));
        }
        return $collectionItemType;

    }
}
