<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectionSaveRequest;
use App\Http\Requests\Collections\CollectionUpdateRequest;
use App\Http\Services\Collections\CollectionService;
use App\Models\Collection;
use App\Traits\ImageUploadTrait;
use App\Traits\RemoveImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CollectionController extends Controller {
 use ImageUploadTrait;
 use RemoveImageTrait;
 protected $service;

 public function __construct(CollectionService $service) {
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
 public function store(CollectionSaveRequest $request): JsonResponse {
  $data = $request->all();
  $image = null;

  try {
   if ($request->hasFile('image')) {
    $image = $this->uploadImage($request->image, 'collections');
    $data['image_url'] = $image['image_url'];
   }
   $this->service->saveCollection($data);
  } catch (Execption $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_create_success'));

 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\Collection  $Collection
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
  * @param  \App\Models\Collection  $Collection
  * @return \Illuminate\Http\Response
  */
 public function edit(Collection $Collection) {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\Collection  $Collection
  * @return \Illuminate\Http\Response
  */
 public function update(CollectionUpdateRequest $request, $id) {
  $data = $request->all();
  $collection = Collection::find($id);
  $data['image'] = Arr::exists($collection, 'image') ? $collection['image'] : null;
  try {
   if ($request->hasFile('image')) {
    if ($collection['image']) {
     $this->removeImage($collection['image']);
    }
    $image = $this->uploadImage($request->image, 'collections');
    $data['image'] = $image['image_url'];
   }
   $result = $this->service->updateCollection($data, $id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([$result], null, trans('messages.collection_update_success'));
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Collection  $Collection
  * @return \Illuminate\Http\Response
  */
 public function destroy($id) {

  try {
   $result = $this->service->deleteById($id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_delete_success'));
 }
}
