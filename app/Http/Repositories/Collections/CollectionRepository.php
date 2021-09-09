<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collection;
use App\Traits\RemoveImageTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CollectionRepository {
 use RemoveImageTrait;
 protected $collection;
 /**
  * @param array $
  */
 public function __construct(Collection $collection) {
  $this->collection = $collection;

 }

 public function getAll() {
  return $this->collection->with('user')
   ->get();
 }

 public function getById($id) {
  return $this->collection
   ->where('id', $id)->with('user')
   ->get();
 }

 public function save(array $data): void {
  $collection = new $this->collection;
  $collection->name = $data['name'];
  $collection->status = Arr::exists($data, 'status') ? $data['status'] : "Pending";
  $collection->user_id = Auth::user()->id;
  $collection->image = Arr::exists($data, 'image_url') ? $data['image_url'] : null;
  $collection->save();
 }

 public function update($data, $id) {
  $collection = $this->collection->find($id);
  $collection->name = $data['name'];
  $collection->status = Arr::exists($data, 'status') ? $data['status'] : "Pending";
  $collection->user_id = Auth::user()->id;
  $collection->image = $data['image'];
  $collection->update();
  return $collection;
 }

 public function delete($id) {
  $collection = $this->collection->find($id);
  if ($collection['image']) {
   $this->removeImage($collection['image']);
  }
  $collection->delete();
  return $collection;
 }
}
