<?php

namespace App\Http\Controllers\API\V1\Seller;

use Illuminate\Http\Request;
use App\Models\SellerProfile;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sellers\CreateRequest;
use App\Http\Services\Sellers\SellerRequestService;
use App\Http\Transformers\Sellers\SellerTransformer;

class SellerRequestController extends Controller
{
    protected $service;

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
    public function store(CreateRequest $request)
    {
        $seller = SellerProfile::where('user_id', auth()->id())->first();
        if ($seller) {
            return $this->failure([], trans('messages.seller_request_exist'));
        }
        $data = $request->validated();
        $result = $this->service->save($data);
        return $this->success($result, $this->transformer, trans('messages.seller_request_create_success'));


    }
}
