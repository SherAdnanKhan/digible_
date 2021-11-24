<?php

namespace App\Http\Controllers;

use ErrorException;
use Illuminate\Http\Request;

class WyreTestController extends Controller
{
    public function createAccount()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.testwyre.com/v3/accounts', [
            'body' => '{"sourceCurrency":"BTC","destCurrency":"ETH","dest":"0x571fa494b5390001c5cecf4b4a49a54b7c623c3f","refundTo":"account:WA_RXHY6M3V69E","notifyUrl":"https://sunshinemeatmarket.com/webhook"}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $response->getBody()->getContents();
        dd($response);
    }

    public function createWallet()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.testwyre.com/v2/wallets', [
            'body' => '{"type":"DEFAULT","name":"user:1234567","callbackUrl":"https://sunshinemeatmarket.com/webhook","notes":"This is user wallet"}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        dd($response->getBody()->getContents());
    }

    public function getWallet()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('GET', 'https://api.testwyre.com/v2/wallet/WA_RXHY6M3V69E', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
            ],
        ]);

        dd($response->getBody()->getContents());
    }

    public function swap()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.testwyre.com/v3/swaps', [
            'body' => '{"sourceCurrency":"BTC","destCurrency":"USDT","dest":"account:WA_RXHY6M3V69E","refundTo":"account:WA_RXHY6M3V69Eaccount:","notifyUrl":"https://sunshinemeatmarket.com/webhook\\""}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        dd($response->getBody()->getContents());
    }

    public function transfer()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.testwyre.com/v2/paymentMethods', [
            'body' => '{"plaidProcessorToken":"public-sandbox-7591d7cc-b0fe-4bc5-9f8b-478ad09ed390|mQwVMRLKKmHj3PbvRRwWTReRgXrjrDtgzgJnk","paymentMethodType":"LOCAL_TRANSFER","country":"US"}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json',
            ],
        ]);

        dd($response->getBody()->getContents());
    }

    public function make_authenticated_request($endpoint, $method, $body)
    {
        $url = 'https://api.sendwyre.com';
        $api_key = "AK-7Y9AZAF4-WWUPDEHW-V7YELGCA-EQCE2UCC";
        $secret_key = "SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR";

        $timestamp = floor(microtime(true) * 1000);
        $request_url = $url . $endpoint;

        if (strpos($request_url, "?")) {
            $request_url .= '&timestamp=' . $timestamp;
        } else {
            $request_url .= '?timestamp=' . $timestamp;
        }

        if (!empty($body)) {
            $body = json_encode($body, JSON_FORCE_OBJECT);
        } else {
            $body = '';
        }

        $headers = array(
            "Content-Type: application/json",
            "X-Api-Key: " . $api_key,
            "X-Api-Signature: " . $this->calc_auth_sig_hash($secret_key, $request_url . $body),
            "X-Api-Version: 2",
        );
        $curl = curl_init();

        if ($method == "POST") {
            $options = array(
                CURLOPT_URL => $request_url,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $body,
                CURLOPT_RETURNTRANSFER => true);
        } else {
            $options = array(
                CURLOPT_URL => $request_url,
                CURLOPT_RETURNTRANSFER => true);
        }
        curl_setopt_array($curl, $options);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($curl);
        curl_close($curl);
        var_dump($result);
        return json_decode($result, true);
    }

    public function calc_auth_sig_hash($seckey, $val)
    {
        $hash = hash_hmac('sha256', $val, $seckey);
        return $hash;
    }

    public function makeTransfer()
    {

        return $this->make_authenticated_request("/account", "GET", array());
        $transfer = array(
            "sourceCurrency" => "USD",
            "dest" => "wallet:WA_RXHY6M3V69E",
            "destAmount" => 1,
            "destCurrency" => "EUR",
            "message" => "buy sam pizza",
        );
        echo $this->make_authenticated_request("/transfers", "POST", $transfer);
    }

    public function transaction($amount = 0.15, $currency = "USD", $secretKey = "")
    {
            $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'https://api.testwyre.com/v3/orders/reserve', [
                'body' => '{"amount":"' . $amount . '","sourceCurrency":"' . $currency . '","destCurrency":"' . 'bitcoin' . '","dest":"' . config("app.btc_address") . '","firstName":"Willie", "lastName":"Baker","referrerAccountId":"' . config("app.account_id") . '"}',
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $secretKey,
                    'Content-Type' => 'application/json',
                ],
            ]);
            $response_body = $response->getBody()->getContents();
            $response = json_decode($response_body);
            if (isset($response->reservation)) {
                $result = [];
                $result[0] = ["order_id" => 140, "collection_item_id" => 6, "quantity" => 5];
                $result[1] = [
                    "order_id" => 141,
                    "collection_item_id" => 7,
                    "quantity" => 4,
                ];
                $result[2] = [
                    "order_id" => 142,
                    "collection_item_id" => 8,
                    "quantity" => 1,
                ];
                $result["reservation"] = $response->reservation;
                return view('payment.creditcard')->with(compact('result'));
                return $response->reservation;
            }
    }

}
