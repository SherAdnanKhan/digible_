<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Services\Users\PaymentService;
use App\Models\Transaction;
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
        /**
         * adding dummy data for just now in $endPoint, $method, $param variable when get api credentials replace these with...
         */

        $result = $this->paymentService->paymentMethodAuthentication($request->validated(), Transaction::WYRE_AUTH_URL, Transaction::METHOD, Transaction::PARAMS) ;
       /**
        * above method store all data that received and below code return success message to user...
        */
       // return $this->success($result, null, trans('messages.payment_create_success'));
    }
    public function salesDetails()
    {
        $result = $this->paymentService->salesDetails() ;
        return $this->success($result);
    }
}
