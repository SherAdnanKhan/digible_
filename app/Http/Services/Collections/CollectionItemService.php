<?php
namespace App\Http\Services\Collections;

use App\Http\Repositories\Collections\CollectionItemRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CollectionItemService extends BaseService {
 protected $repository;

 public function __construct(CollectionItemRepository $repository) {
  $this->repository = $repository;
 }

 public function getAll() {
  Log::info(__METHOD__ . " -- Collection item data all fetched: ");
  return $this->repository->getAll();
 }

 public function getById($id) {
  Log::info(__METHOD__ . " -- Collection item data fetched ");
  return $this->repository->getById($id);
 }

 public function saveCollectionItem(array $data): void {
  Log::info(__METHOD__ . " -- New collection item request info: ", $data);
  $this->repository->save($data);
 }

 public function deleteById($id) {
  DB::beginTransaction();

  try {
   Log::info(__METHOD__ . " -- Collection item data deleted ");
   $collectionItem = $this->repository->delete($id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to delete collection item data');
  }

  DB::commit();
  return $collectionItem;
 }

 public function updateCollectionItem($data, $id) {
  DB::beginTransaction();
  try {
   $collection = $this->repository->update($data, $id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to update collection item data');
  }

  DB::commit();
  return $collection;
 }
}
