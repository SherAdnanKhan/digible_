<?php

namespace App\Http\Repositories\Users\Interfaces;

interface PaymentRepositoryInterface
{
    public function PaymentMethodAuthentication($endPoint, $method, $param) ;
}
