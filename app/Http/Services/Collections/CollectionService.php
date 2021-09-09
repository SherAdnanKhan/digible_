<?php
namespace App\Http\Services\Collections;

use App\Http\Repositories\Collections\CollectionRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CollectionService extends BaseService {
 protected $repository;

 public function __construct(CollectionRepository $repository) {
  $this->repository = $repository;
 }

 public function getAll() {
  Log::info(__METHOD__ . " -- Collection data all fetched: ");
  return $this->repository->getAll();
 }

 public function getById($id) {
  Log::info(__METHOD__ . " -- Collection data fetched ");
  return $this->repository->getById($id);
 }

 public function saveCollection(array $data): void {
  Log::info(__METHOD__ . " -- New collection request info: ", $data);
  $this->repository->save($data);
 }

 public function deleteById($id) {
  DB::beginTransaction();

  try {
   Log::info(__METHOD__ . " -- Collection data deleted ");
   $collection = $this->repository->delete($id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to delete collection data');
  }

  DB::commit();
  return $collection;
 }

 public function updateCollection($data, $id) {
  DB::beginTransaction();
  try {
   $collection = $this->repository->update($data, $id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to update collection data');
  }

  DB::commit();
  return $collection;
 }
}
