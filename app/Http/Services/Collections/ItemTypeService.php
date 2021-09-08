<?php
namespace App\Http\Services\Collections;

use App\Http\Repositories\Collections\ItemTypeRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ItemTypeService extends BaseService {
 protected $repository;

 public function __construct(ItemTypeRepository $repository) {
  $this->repository = $repository;
 }

 public function getAll() {
  Log::info(__METHOD__ . " -- Collection item type data all fetched: ");
  return $this->repository->getAll();
 }

 public function getById($id) {
  Log::info(__METHOD__ . " -- Collection item type data fetched ");
  return $this->repository->getById($id);
 }

 public function saveItemType(array $data): void {
  Log::info(__METHOD__ . " -- New collection item type request info: ", $data);
  $this->repository->save($data);
 }

 public function deleteById($id) {
  DB::beginTransaction();

  try {
   Log::info(__METHOD__ . " -- Collection item type data deleted ");
   $itemType = $this->repository->delete($id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to delete collection item type data');
  }

  DB::commit();
  return $itemType;
 }

 public function updateItemType($data, $id) {
  DB::beginTransaction();

  try {
   $itemType = $this->repository->update($data, $id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to update collection item type data');
  }

  DB::commit();
  return $itemType;
 }
}
