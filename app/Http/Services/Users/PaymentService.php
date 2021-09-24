<?php

namespace App\Http\Services\Users;

use App\Http\Repositories\Users\Interfaces\PaymentRepositoryInterface;
use App\Http\Repositories\Users\PaymentRepository;
use App\Http\Services\BaseService;
use App\Http\Services\Payment\PaymentMethodService;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService extends BaseService
{
    private $paymentRepository ;
    protected $paymentMethodService ;

    public function __construct(PaymentMethodService $paymentMethodService, PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository ;
        $this->paymentMethodService = $paymentMethodService ;
    }
    public function PaymentMethodAuthentication($request)
    {
       $data['transaction_data'] = $this->paymentMethodService->PaymentMethodAuthentication(WYRE_AUTH_URL, METHOD, PARAM_A) ;
       $data['request'] = $request ;
       return $this->paymentRepository->create($data) ;
    }
    public function salesDetails()
    {
       Log::info(__METHOD__ . " -- payment or transaction data all fetched: ");
       return $this->paymentRepository->salesDetails();
    }

    public function submitWyreAuth($secret_kay)
    {
        $response = Http::post(WYRE_AUTH_URL, [
            'secretKey' => $secret_kay,
        ]);
        return $response ;
    }
}
