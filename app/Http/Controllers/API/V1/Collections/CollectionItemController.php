<?php

namespace App\Http\Controllers\API\V1\Collections;

use Illuminate\Http\Request;
use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Services\Collections\CollectionItemService;
use App\Http\Requests\Collections\CollectionItemSaveRequest;
use App\Http\Requests\Collections\CollectionItemUpdateRequest;
use App\Http\Transformers\Collections\CollectionItemTransformer;

class CollectionItemController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(CollectionItemService $service, CollectionItemTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }
    public function index(): JsonResponse
    {

        $result = $this->service->getAll();
        return $this->success($result, $this->transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionItemSaveRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->service->save(isset($request->image) ? $request->image : null , $data);
        return $this->success($result, $this->transformer, trans('messages.collection_item_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectionItem  $CollectionItem
     * @return \Illuminate\Http\Response
     */
    public function show(CollectionItem $collectionItem)
    {
        return $this->success($collectionItem, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollectionItem  $CollectionItem
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionItemUpdateRequest $request, CollectionItem $collectionItem)
    {
        $data = $request->validated();
        $result = $this->service->update($collectionItem, isset($request->image) ? $request->image : null , $data);
        return $this->success($result, $this->transformer, trans('messages.collection_item_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionItem  $CollectionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollectionItem $collectionItem)
    {
        $result = $this->service->delete($collectionItem);
        return $this->success([], null, trans('messages.collection_item_delete_success'));
    }
}
