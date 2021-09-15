<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\ItemTypeSaveRequest;
use App\Http\Requests\Collections\ItemTypeUpdateRequest;
use App\Http\Services\Collections\ItemTypeService;
use App\Http\Transformers\Collections\ItemTypeTransformer;
use App\Models\CollectionItemType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $service;
    protected $transformer;

    public function __construct(ItemTypeService $service, ItemTypeTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();
        if (count($result) == 0) {
            return $this->success($result, $this->transformer, trans('messages.general_empty_data'));
        }

        return $this->success($result, $this->transformer);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemTypeSaveRequest $request): JsonResponse
    {
        $data = $request->validated();
        $result = $this->service->save($data);
        return $this->success($result, $this->transformer, trans('messages.collection_item_type_create_success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CollectionItemType  $CollectionItemType
     * @return \Illuminate\Http\Response
     */
    public function show(CollectionItemType $collectionItemType)
    {
        return $this->success($collectionItemType, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CollectionItemType  $CollectionItemType
     * @return \Illuminate\Http\Response
     */
    public function update(ItemTypeUpdateRequest $request, CollectionItemType $collectionItemType)
    {
        $data = $request->validated();
        $result = $this->service->update($collectionItemType, $data);
        return $this->success($result, $this->transformer, trans('messages.collection_item_type_update_success'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CollectionItemType  $CollectionItemType
     * @return \Illuminate\Http\Response
     */
    public function destroy(CollectionItemType $collectionItemType)
    {
        $collectionItemType->delete();
        return $this->success([], null, trans('messages.collection_item_type_delete_success'));

    }
}
