<?php

namespace App\Http\Services\Payment;
use App\Http\HttpHandler;
use App\Http\Services\BaseService;

class PaymentGateService extends BaseService
{
    public function transaction($amount , $auth)
    {
        return rand(0,1);
    }
}