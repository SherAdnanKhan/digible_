<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderCompleteRequest;
use App\Http\Requests\Order\OrderRequest;
use App\Http\Services\Users\OrderService;
use App\Http\Transformers\Orders\OrderTransformer;
use App\Models\Order;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    protected $service;
    protected $transformer;
    public function __construct(OrderService $service, OrderTransformer $transformer)
    {
        $this->service = $service;
        $this->transformer = $transformer;
    }

    public function show(Order $order): JsonResponse
    {
        return $this->success($order, $this->transformer);
    }

    public function store(OrderRequest $request)
    {
        $result = $this->service->create($request->validated());
        if ($result) {
            return $this->success($result, $this->transformer, trans('messages.order_create_success'));
        } else {
            return $this->failure('', trans('messages.order_create_failed'));
        }
    }

    public function update(Order $order, OrderCompleteRequest $request)
    {
        $result = $this->service->completed($order, $request->validated());
    }

    public function salesDetails()
    {
        $result = $this->service->salesDetails();
        return $this->success($result);
    }
}
