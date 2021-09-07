<?php

namespace App\Http\Repositories\Collections;

use App\Models\Collectible;

class CollectibleRepository {
 protected $collectible;
 /**
  * @param array $
  */
 public function __construct(Collectible $collectible) {
  $this->collectible = $collectible;

 }

 public function getAll() {
  return $this->collectible
   ->get();
 }

 public function getById($id) {
  return $this->collectible
   ->where('id', $id)
   ->get();
 }

 public function save(array $data): void {
  $collectible = new $this->collectible;
  $collectible->name = $data['name'];
  $collectible->save();
 }

 public function update($data, $id) {
  $collectible = $this->collectible->find($id);
  $collectible->name = $data['name'];
  $collectible->update();
  return $collectible;
 }

 public function delete($id) {
  $collectible = $this->collectible->find($id);
  $collectible->delete();
  return $collectible;
 }
}
