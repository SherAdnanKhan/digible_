<?php

namespace App\Http\Controllers\API\V1\Admin;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sellers\UpdateRequest;
use App\Http\Services\Sellers\SellerRequestService;
use App\Http\Transformers\Sellers\SellerTransformer;

class SellerProfileAdminController extends Controller
{
    protected $service;

    public function __construct(SellerRequestService $service , SellerTransformer $transformer)
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

    public function update(UpdateRequest $request, $id)
    {

        $data = $request->only('status');
        $this->service->update($data, $id);
        return $this->success([], null, trans('messages.seller_request_update_success'));
    }
}
