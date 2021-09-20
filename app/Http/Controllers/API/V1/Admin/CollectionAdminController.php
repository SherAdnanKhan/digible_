<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\Admin\CollectionUpdateRequest;
use App\Http\Services\Collections\CollectionService;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Models\Collection;

class CollectionAdminController extends Controller
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
        $result = $this->service->getPending();
        return $this->service->paginate($result);
    }

    public function update(CollectionUpdateRequest $request, Collection $collection)
    {
        $collection->update($request->validated());
        return $this->success([], null, trans('messages.collection_update_success'));
    }

    public function approved()
    {
        $result = $this->service->getApproved();
        return $this->service->paginate($result);
    }
}
