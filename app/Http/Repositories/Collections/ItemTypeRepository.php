<?php

namespace App\Http\Repositories\Collections;

use App\Models\CollectionItemType;

class ItemTypeRepository {
 protected $collectionItemType;
 /**
  * @param array $
  */
 public function __construct(CollectionItemType $collectionItemType) {
  $this->collectionItemType = $collectionItemType;

 }

 public function getAll() {
  return $this->collectionItemType
   ->get();
 }

 public function getById($id) {
  return $this->collectionItemType
   ->where('id', $id)
   ->get();
 }

 public function save(array $data): void {
  $collectionItemType = new $this->collectionItemType;
  $collectionItemType->name = $data['name'];
  $collectionItemType->save();
 }

 public function update($data, $id) {
  $collectionItemType = $this->collectionItemType->find($id);
  $collectionItemType->name = $data['name'];
  $collectionItemType->update();
  return $collectionItemType;
 }

 public function delete($id) {
  $collectionItemType = $this->collectionItemType->find($id);
  $collectionItemType->delete();
  return $collectionItemType;
 }
}
