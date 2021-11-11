<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WyreTestController extends Controller
{
    public function createAccount()
    {
        $secretKey = 'SK-FV3CFCGM-TN3PZ4XW-CDYGWZAC-M6EAEMVR';

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://api.testwyre.com/v3/accounts', [
            'body' => '{"profileFields":[{"value":"1990-06-12","fieldId":"individualDateOfBirth"},{"fieldId":"individualCellphoneNumber","value":"+1234567890"},{"fieldId":"individualLegalName","value":"Mohsin Developer"},{"fieldId":"individualEmail","value":"mohsindev@gmail.com"},{"fieldId":"individualResidenceAddress","value":{"street1":"1236 Main St","street2":"stree 2","city":"los angeles","state":"CA","postalCode":"91604","country":"US"}}],"type":"INDIVIDUAL","country":"US"}',
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '. $secretKey,
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
                'Authorization' => 'Bearer '. $secretKey,
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
                'Authorization' => 'Bearer '. $secretKey,
            ],
        ]);

        dd($response->getBody()->getContents());
    }
}
