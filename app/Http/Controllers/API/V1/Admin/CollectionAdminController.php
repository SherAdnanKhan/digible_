<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collections\Admin\CollectionUpdateRequest;
use App\Http\Services\Collections\CollectionService;
use App\Http\Transformers\Collections\CollectionTransformer;
use App\Models\Collection;
use Illuminate\Http\JsonResponse;

class CollectionAdminController extends Controller
{
    protected $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }
    
    public function index()
    {
        return $this->service->getPending();
    }

    public function update(CollectionUpdateRequest $request, Collection $collection): JsonResponse
    {
        $collection->update($request->validated());
        return $this->success([], null, trans('messages.collection_update_success'));
    }

    public function approved()
    {
        return $this->service->getApproved();
    }
}
