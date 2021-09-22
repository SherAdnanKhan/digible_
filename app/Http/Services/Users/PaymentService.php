<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Users\PaymentRepository;

class PaymentService
{
    protected $paymentRepository ;
    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository ;
    }
    public function create($request)
    {
        $this->paymentRepository->create($request->all());
    }
    public function salesDetails()
    {
       return $this->paymentRepository->salesDetails();
    }
}
