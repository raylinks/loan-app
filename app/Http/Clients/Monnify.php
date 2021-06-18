<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Monnify
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders(['Authorization' =>   'Bearer'  .  $this->token])
            ->baseUrl(config('monnify.base_url'));
    }

    public function initiateRepayment()
    {
        $requestData = $this->initiatePayload();
        $res =  $this->client->post('v1/merchant/transactions/init-transaction', $requestData)->throw()->json();
        dd($res);
    }

    public function payWithcard()
    {
        $requestData = $this->cardPayload();
        $res =  $this->client->post('v1/merchant/cards/charge', $requestData)->throw()->json();
        dd($res);
    }

    protected function initiatePayload()
    {
        $ref = md5(Str::random(20));

        return [
            "amount" => 100.00,
            "customerName" => "Stephen Ikhane",
            "customerEmail" => "stephen@ikhane.com",
            "paymentReference" => "123031klsadkad",
            "paymentDescription" => "Trial transaction",
            "currencyCode" => "NGN",
            "contractCode" => config('monnify.contract-code'),
            "redirectUrl" => "https://my-merchants-page.com/transaction/confirm",
            "paymentMethods" => ["CARD","ACCOUNT_TRANSFER"]
        ];
    }

    protected function cardPayload()
    {
        $ref = md5(Str::random(20));

        return [
            "amount" => 100.00,
            "customerName" => "Stephen Ikhane",
            "customerEmail" => "stephen@ikhane.com",
            "paymentReference" => "123031klsadkad",
            "paymentDescription" => "Trial transaction",
            "currencyCode" => "NGN",
            "contractCode" => config('monnify.contract-code'),
            "redirectUrl" => "https://my-merchants-page.com/transaction/confirm",
            "paymentMethods" => ["CARD","ACCOUNT_TRANSFER"]
        ];
    }
}
