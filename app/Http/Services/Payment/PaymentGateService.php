<?php

namespace App\Http\Services\Payment;

use App\Http\Services\BaseService;
use ErrorException;

class PaymentGateService extends BaseService
{
    public function transaction($amount = "", $currency = "", $secretKey = "")
    {
        try {

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.testwyre.com/v3/orders/reserve', [
                'body' => '{"amount":"' . $amount . '","sourceCurrency":"' . $currency . '","destCurrency":"' . 'bitcoin' . '","dest":"' . config("app.btc_address") . '","firstName":"' . auth()->user()->name . '","lastName":"' . auth()->user()->name . '","referrerAccountId":"' . config("app.account_id") . '"}',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $secretKey,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response_body = $response->getBody()->getContents();
            $response = json_decode($response_body);
            if (isset($response->reservation)) {
                return $response->reservation;
            }

        } catch (ErrorException $e) {
            //log or print the error here.
            return false;
        } //end catch

    }
}
