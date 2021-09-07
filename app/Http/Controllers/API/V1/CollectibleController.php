<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectibleRequest;
use App\Http\Requests\Collections\CollectibleUpdateRequest;
use App\Http\Services\Collections\CollectibleService;
use App\Models\Collectible;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectibleController extends Controller {
 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 protected $service;

 public function __construct(CollectibleService $service) {
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
 public function store(CollectibleRequest $request): JsonResponse {
  $data = $request->only(['name']);

  try {
   $this->service->saveCollectibleData($data);
  } catch (Execption $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collectible_create_success'));

 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\Collectible  $collectible
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
  * @param  \App\Models\Collectible  $collectible
  * @return \Illuminate\Http\Response
  */
 public function edit(Collectible $collectible) {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Models\Collectible  $collectible
  * @return \Illuminate\Http\Response
  */
 public function update(CollectibleUpdateRequest $request, $id) {
  $data = $request->only(['name']);

  try {
   $result = $this->service->updatePost($data, $id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([$result], null, trans('messages.collectible_update_success'));
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Collectible  $collectible
  * @return \Illuminate\Http\Response
  */
 public function destroy($id) {

  try {
   $result = $this->service->deleteById($id);
  } catch (Exception $e) {
   return $this->failure([], null, trans('messages.general_error'));
  }

  return $this->success([], null, trans('messages.collectible_delete_success'));
 }
}
