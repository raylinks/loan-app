<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class AuthRequest
{   
    protected PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::withHeaders(['Authorization' => 'Basic' . $this->getEncodedAuth() ])
            ->baseUrl(config('monnify.base_url'));
    }

    public function token()
    {
        try {
           $token  = $this->client->post("v1/auth/login");
          return $token;
      
    } catch (Exception $exception) {
       
    }

    }


    /**
     * Get the encoded data for requests authorization
     *
     * @return string
     */
    private function getEncodedAuth(): string
    {
        return base64_encode(
            sprintf(
                '%s:%s',
                config('monnify.api_key'),
                config('monnify.secret_key')
            )
        );
    }
}   