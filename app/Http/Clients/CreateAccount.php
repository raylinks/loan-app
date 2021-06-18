<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class CreateAccount
{   
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders(['Authorization' => 'Bearer ' . $this->token,])
            ->baseUrl(config('blacklist.base_url'));
    }


    public function searchWithBvn(string $bvn)
    {
        try {
           return $verifyBvn = $this->client->post("v1/bank-transfer/reserved-accounts")->throw()->json();
      
        } catch (Exception $exception) {}
       
    }

    
}