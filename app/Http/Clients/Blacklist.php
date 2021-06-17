<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class Blacklist
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
           return $verifyBvn = $this->client->get("/bvn/{$bvn}")->throw()->json();
      
    } catch (Exception $exception) {
        dd($exception);
        $response = $exception->response->json();
        $message = Arr::get($response, 'message');

        if (Str::contains(strtolower($message), 'Invalid')) {
            abort('Invalid Bvn');
        }
        if (Str::contains(strtolower($message), 'not available')) {
            abort('please try again');
        }
    }

    }
}