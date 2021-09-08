<?php

namespace App\Http\Controllers\API\V1\Collections;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\CollectionItemType;
use App\Http\Controllers\Controller;
use App\Http\Services\Collections\ItemTypeService;
use App\Http\Requests\Collections\ItemTypeSaveRequest;
use App\Http\Requests\Collections\ItemTypeUpdateRequest;

class ItemTypeController extends Controller {
 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 protected $service;

 public function __construct(ItemTypeService $service) {
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
 public function store(ItemTypeSaveRequest $request): JsonResponse {
  $data = $request->only(['name']);

  try {
   $this->service->saveItemType($data);
  } catch (Execption $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_item_type_create_success'));

 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\CollectionItemType  $CollectionItemType
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
  * @param  \App\Models\CollectionItemType  $CollectionItemType
  * @return \Illuminate\Http\Response
  */
 public function edit(CollectionItemType $CollectionItemType) {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\CollectionItemType  $CollectionItemType
  * @return \Illuminate\Http\Response
  */
 public function update(ItemTypeUpdateRequest $request, $id) {
  $data = $request->only(['name']);

  try {
   $result = $this->service->updateItemType($data, $id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([$result], null, trans('messages.collection_item_type_update_success'));
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\CollectionItemType  $CollectionItemType
  * @return \Illuminate\Http\Response
  */
 public function destroy($id) {

  try {
   $result = $this->service->deleteById($id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collection_item_type_delete_success'));
 }
}
