<?php

namespace App\Http\Repositories\Users;

use App\Models\Transaction;

class PaymentRepository
{
    protected $payment ;
    public function create($request)
    {
        return true ;
       // Transaction::created($request);
    }
    public function salesDetails()
    {
       return Transaction::all() ;
    }
}
