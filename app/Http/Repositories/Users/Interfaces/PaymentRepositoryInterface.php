<?php

namespace App\Http\Repositories\Users\Interfaces;

interface PaymentRepositoryInterface
{
    public function paymentMethodAuthentication($endPoint, $method, $param) ;
}
