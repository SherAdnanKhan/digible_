<?php

namespace App\Http\Controllers\API\V1\Collections;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\CollectionSaveRequest;
use App\Http\Requests\Collections\CollectionUpdateRequest;
use App\Http\Services\Collections\CollectionService;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(CollectionService $service, CollectionTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CollectionSaveRequest $request): JsonResponse
    {
        $result = $this->service->save($request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Collection  $Collection
     * @return \Illuminate\Http\Response
     */
    public function show(Collection $collection)
    {
        return $this->success($collection, $this->transformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Collection  $Collection
     * @return \Illuminate\Http\Response
     */
    public function update(CollectionUpdateRequest $request, Collection $collection)
    {
        $result = $this->service->update($collection, $request->validated());
        return $this->success($result, $this->transformer, trans('messages.collection_update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Collection  $Collection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Collection $collection)
    {
        $this->service->delete($collection);
        return $this->success([], null, trans('messages.collection_delete_success'));
    }
}
