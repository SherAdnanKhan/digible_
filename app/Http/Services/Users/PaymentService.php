<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface;
use App\Http\Repositories\Users\PaymentRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Payment\PaymentMethodService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\DocBlock\Tags\Method;

class PaymentService extends BaseService
{
    private $paymentRepository ;
    protected $paymentMethodService ;

    public function __construct(PaymentMethodService $paymentMethodService, PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository ;
        $this->paymentMethodService = $paymentMethodService ;
    }
    public function paymentMethodAuthentication($request, $url, $method, $param)
    {
       $data['transaction_data'] = $this->paymentMethodService->paymentMethodAuthentication($url, $method, $param) ;
       $data['request'] = $request ;
       return $this->paymentRepository->create($data) ;
    }
    public function salesDetails()
    {
       Log::info(__METHOD__ . " -- payment or transaction data all fetched: ");
       return $this->paymentRepository->salesDetails();
    }

}
