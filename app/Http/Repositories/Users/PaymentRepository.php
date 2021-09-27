<?php

namespace App\Http\Repositories\Users;

use App\Models\Transaction;

class PaymentRepository
{
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

}
