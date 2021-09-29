<?php

namespace App\Http\Services\Payment;
use App\Http\HttpHandler;

class PaymentGateService
{
    public function transaction($amount , $auth)
    {
        return rand(0,1);
    }
}