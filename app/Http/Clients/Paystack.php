<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Paystack
{
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders(['Authorization' => config('blacklist.secret_key')])
            ->baseUrl(config('blacklist.base_url'));
    }


    public function searchWithBvn(string $bvn)
    {

        try {
            return $verifyBvn = $this->client->get()->throw()->json();
        } catch (Exception $exception) {
        }
    }
}
