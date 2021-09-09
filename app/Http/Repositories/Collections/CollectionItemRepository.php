<?php

namespace App\Http\Repositories\Collections;

use App\Models\CollectionItem;
use App\Traits\RemoveImageTrait;
use Illuminate\Support\Arr;

class CollectionItemRepository {
 use RemoveImageTrait;
 protected $collectionItem;
 /**
  * @param array $
  */
 public function __construct(CollectionItem $collectionItem) {
  $this->collectionItem = $collectionItem;

 }

 public function getAll() {
  return $this->collectionItem->with('collection', 'collectionItemType')
   ->get();
 }

 public function getById($id) {
  return $this->collectionItem
   ->where('id', $id)->with('collection')
   ->get();
 }

 public function save(array $data): void {
  $collectionItem = new $this->collectionItem;
  $collectionItem->collection_item_type_id = $data['collection_item_type_id'];
  $collectionItem->collection_id = $data['collection_id'];
  $collectionItem->physical = Arr::exists($data, 'physical') ? $data['physical'] : false;
  $collectionItem->name = $data['name'];
  $collectionItem->image = Arr::exists($data, 'image_url') ? $data['image_url'] : null;
  $collectionItem->description = Arr::exists($data, 'description') ? $data['description'] : null;
  $collectionItem->edition = Arr::exists($data, 'edition') ? $data['edition'] : null;
  $collectionItem->graded = Arr::exists($data, 'graded') ? $data['graded'] : null;
  $collectionItem->year = Arr::exists($data, 'year') ? $data['year'] : null;
  $collectionItem->population = Arr::exists($data, 'population') ? $data['population'] : null;
  $collectionItem->publisher = Arr::exists($data, 'publisher') ? $data['publisher'] : null;
  $collectionItem->status = Arr::exists($data, 'status') ? $data['status'] : "Pending";
  $collectionItem->save();
 }

 public function update($data, $id) {
  $collectionItem = $this->collectionItem->find($id);
  $collectionItem->collection_item_type_id = $data['collection_item_type_id'];
  $collectionItem->collection_id = $data['collection_id'];
  $collectionItem->physical = Arr::exists($data, 'physical') ? $data['physical'] : false;
  $collectionItem->name = $data['name'];
  $collectionItem->image = Arr::exists($data, 'image_url') ? $data['image_url'] : null;
  $collectionItem->description = Arr::exists($data, 'description') ? $data['description'] : null;
  $collectionItem->edition = Arr::exists($data, 'edition') ? $data['edition'] : null;
  $collectionItem->graded = Arr::exists($data, 'graded') ? $data['graded'] : null;
  $collectionItem->year = Arr::exists($data, 'year') ? $data['year'] : null;
  $collectionItem->population = Arr::exists($data, 'population') ? $data['population'] : null;
  $collectionItem->publisher = Arr::exists($data, 'publisher') ? $data['publisher'] : null;
  $collectionItem->status = Arr::exists($data, 'status') ? $data['status'] : "Pending";
  $collectionItem->update();
  return $collectionItem;
 }

 public function delete($id) {
  $collectionItem = $this->collectionItem->find($id);
  if ($collectionItem['image']) {
   $this->removeImage($collectionItem['image']);
  }
  $collectionItem->delete();
  return $collectionItem;
 }
}
