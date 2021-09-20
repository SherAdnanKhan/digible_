<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectionItemSaveRequest;
use App\Http\Requests\Collections\CollectionItemUpdateRequest;
use App\Http\Services\Collections\CollectionItemService;
use App\Http\Transformers\Collections\CollectionItemTransformer;
use App\Models\Collection;
use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionItemController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(CollectionItemService $service, CollectionItemTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function index(Collection $collection)
    {
        return $this->service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionItemSaveRequest $request, Collection $collection): JsonResponse
    {
        $result = $this->service->save($request->validated(), $collection);
        return $this->success($result, $this->transformer, trans('messages.collection_item_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectionItem  $CollectionItem
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection, CollectionItem $collectionItem): JsonResponse
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
    public function update(CollectionItemUpdateRequest $request, Collection $collection, CollectionItem $collectionItem): JsonResponse
    {
        $result = $this->service->update($collectionItem, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_item_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionItem  $CollectionItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection, CollectionItem $collectionItem): JsonResponse
    {
        $this->service->delete($collectionItem);
        return $this->success([], null, trans('messages.collection_item_delete_success'));
    }
}
