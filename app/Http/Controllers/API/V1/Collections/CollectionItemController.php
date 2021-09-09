<?php

namespace App\Http\Controllers\API\V1\Collections;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\CollectionItem;
use App\Traits\ImageUploadTrait;
use App\Traits\RemoveImageTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Collections\CollectionItemService;
use App\Http\Requests\Collections\CollectionItemSaveRequest;
use App\Http\Requests\Collections\CollectionItemUpdateRequest;

class CollectionItemController extends Controller {
 use ImageUploadTrait;
 use RemoveImageTrait;
 protected $service;

 public function __construct(CollectionItemService $service) {
  $this->service = $service;
 }
 public function index(): JsonResponse {

  try {
   $result = $this->service->getAll();
   if (count($result) == 0) {
    return $this->success([], null, trans('messages.general_empty_data'));
   }
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success($result);
 }

 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create() {
  //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(CollectionItemSaveRequest $request): JsonResponse {
  $data = $request->all();
  $image = null;

  try {
   if ($request->hasFile('image')) {
    $image = $this->uploadImage($request->image, 'collectionItems');
    $data['image_url'] = $image['image_url'];
   }
   $this->service->saveCollectionItem($data);
  } catch (Execption $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_item_create_success'));

 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\CollectionItem  $CollectionItem
  * @return \Illuminate\Http\Response
  */
 public function show($id) {

  try {
   $result = $this->service->getById($id);
   if (count($result) == 0) {
    return $this->success([], null, trans('messages.general_empty_data'));
   }
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success($result);
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Models\CollectionItem  $CollectionItem
  * @return \Illuminate\Http\Response
  */
 public function edit(CollectionItem $CollectionItem) {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\CollectionItem  $CollectionItem
  * @return \Illuminate\Http\Response
  */
 public function update(CollectionItemUpdateRequest $request, $id) {
  $data = $request->all();
  $collectionItem = CollectionItem::find($id);
  $data['image'] = Arr::exists($collectionItem, 'image') ? $collectionItem['image'] : null;
  try {
   if ($request->hasFile('image')) {
    if ($collectionItem['image']) {
     $this->removeImage($collectionItem['image']);
    }
    $image = $this->uploadImage($request->image, 'collectionItems');
    $data['image_url'] = $image['image_url'];
   }
   $result = $this->service->updateCollectionItem($data, $id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([$result], null, trans('messages.collection_item_update_success'));
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\CollectionItem  $CollectionItem
  * @return \Illuminate\Http\Response
  */
 public function destroy($id) {

  try {
   $result = $this->service->deleteById($id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_item_delete_success'));
 }
}
