<?php

namespace App\Http\Repositories\Users;
use App\Models\Transaction;
use App\Http\Repositories\HttpHandler ;
use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface ;
class WyreService extends HttpHandler implements PaymentRepositoryInterface
{
    public function paymentMethodAuthentication($endPoint, $method, $param)
    {
        return $this->call($endPoint, $method, $param) ;
    }
    public function validateConfig()
    {
        /**
         * use in future to validate the secret and client keys in case of wrong, threw exception
         */
    }
}
