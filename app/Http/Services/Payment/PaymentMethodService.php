<?php

namespace App\Http\Services\Payment;

use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface;
use Illuminate\Support\Facades\Log;

class PaymentMethodService
{
    private $paymentRepository ;
    public function __construct(PaymentRepositoryInterface $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository ;
    }
    public function paymentMethodAuthentication($endPoint, $method, $param)
    {
        return $this->paymentRepository->paymentMethodAuthentication($endPoint, $method, $param);
    }
}
