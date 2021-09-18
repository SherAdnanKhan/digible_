<?php

namespace App\Http\Controllers\API\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sellers\UpdateRequest;
use App\Http\Services\Sellers\SellerRequestService;
use App\Http\Transformers\Sellers\SellerTransformer;
use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;

class SellerProfileAdminController extends Controller
{
    protected $service;

    public function __construct(SellerRequestService $service, SellerTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;

    }

    public function index(): JsonResponse
    {
        $result = $this->service->getAll();
        return $this->service->paginate($result);
    }

    public function update(UpdateRequest $request, SellerProfile $sellerProfile): JsonResponse
    {
        $this->service->update($request->validated(), $sellerProfile);
        return $this->success([], null, trans('messages.seller_request_update_success'));
    }
}
