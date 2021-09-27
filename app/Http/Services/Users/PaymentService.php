<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface;
use App\Http\Repositories\Users\WyreRepository;
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

    public function __construct(PaymentMethodService $paymentMethodService, WyreRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository ;
        $this->paymentMethodService = $paymentMethodService ;
    }
    public function paymentMethodAuthentication($data, $url, $method, $param)
    {
       $data['transaction_data'] = $this->paymentMethodService->paymentMethodAuthentication($url, $method, $param) ;
       $data['request'] = $data ;
       return $this->paymentRepository->create($data) ;
    }
    public function salesDetails()
    {
       Log::info(__METHOD__ . " -- payment or transaction data all fetched: ");
       return $this->paymentRepository->salesDetails();
    }

}
