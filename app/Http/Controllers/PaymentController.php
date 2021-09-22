<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Services\Users\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService ;
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService ;
    }
    public function store(PaymentRequest $request)
    {
       $result = $this->paymentService->create($request) ;
       return $this->success($result, null, trans('messages.payment_create_success'));
    }
    public function salesDetails()
    {
        $result = $this->paymentService->salesDetails() ;
        return $this->success($result);
    }
}
