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
        $this->client = Http::withHeaders(['Authorization' =>   'Basic'  . rtrim(strtr(base64_encode(config('monnify.api_key').':'.config('monnify.secret_key')),'+/', '-_'), '=')])
            ->baseUrl(config('blacklist.base_url'));
    }

    public function createCustomAccount()
    {
        $requestData = $this->accountPayload();
        $res =  $this->client->post('/api/v2/bank-transfer/reserved-accounts', $requestData)->throw()->json();
        dd($res);
    }

    protected function accountPayload()
    {
        $ref = md5(Str::random(20));

        return [
            'accountReference' => $ref,
            'accountName' => "CredBolt",
            'currencyCode' => "NGN",
            'contractCode' => "1234",
            'customerEmail' => auth()->user()->email,
            'bvn' => "2221560913",
            'customerName' => auth()->user()->first_name,
            'getAllAvailableBanks' => true,
        ];
    }
}