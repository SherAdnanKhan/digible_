<?php

namespace App\Http\Controllers\API\V1\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sellers\CreateRequest;
use App\Http\Services\Sellers\SellerRequestService;
use App\Http\Transformers\Sellers\SellerTransformer;
use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SellerRequestController extends Controller
{
    protected $service;
    protected $transformer;

    public function __construct(SellerRequestService $service, SellerTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request): JsonResponse
    {
        $user = auth()->user();
        if ($user->sellerProfile) {
            return $this->failure([], trans('messages.seller_request_exist'));
        }
        $result = $this->service->save($request->validated());
        return $this->success($result, $this->transformer, trans('messages.seller_request_create_success'));
    }
}
