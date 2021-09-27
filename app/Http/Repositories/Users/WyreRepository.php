<?php

namespace App\Http\Repositories\Users;
use App\Models\Transaction;
use App\Http\Repositories\HttpHandler ;
use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface ;
class WyreRepository extends HttpHandler implements PaymentRepositoryInterface
{
    protected $payment ;

    public function create($data)
    {
        /**
         * when will Api implement then data that it will return store in transaction table...
         */
        dd($data)  ;
    }

    public function salesDetails()
    {
       return Transaction::all() ;
    }
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
