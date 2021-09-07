<?php
namespace App\Http\Services\Collections;

use App\Http\Repositories\Collections\CollectibleRepository;
use App\Http\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class CollectibleService extends BaseService {
 protected $repository;

 public function __construct(CollectibleRepository $repository) {
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

 public function saveCollectibleData(array $data): void {
  Log::info(__METHOD__ . " -- New collection request info: ", $data);
  $this->repository->save($data);
 }

 public function deleteById($id) {
  DB::beginTransaction();

  try {
   Log::info(__METHOD__ . " -- Collection data deleted ");
   $collectible = $this->repository->delete($id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to delete collectible data');
  }

  DB::commit();
  return $collectible;
 }

 public function updatePost($data, $id) {
  DB::beginTransaction();

  try {
   $collectible = $this->repository->update($data, $id);
  } catch (Exception $e) {
   DB::rollBack();
   Log::info($e->getMessage());
   throw new InvalidArgumentException('Unable to update collectible data');
  }

  DB::commit();
  return $collectible;
 }
}
