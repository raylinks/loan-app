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

    return $this->formatBvnDetails($verifyBvn);
    }

    /**
     * Retrieve the details of a response for a particular bvn.
     *
     * @param array $verifyBvn
     *
     * @return array
     */
    public function formatBvnDetails($verifyBvn)
    {
        $bvnDetails = [];
        $bvnDetails['first_name'] = ucfirst(strtolower(trim($verifyBvn['data']['first_name'])));
        $bvnDetails['last_name'] = ucfirst(strtolower(trim($verifyBvn['data']['last_name'])));
        $bvnDetails['email'] = validator(['email' => $verifyBvn['data']['email']], ['email' => 'string|email'])->passes() ? $verifyBvn['data']['email'] : null;
        $bvnDetails['date_of_birth'] = $verifyBvn['data']['date_of_birth'] ?? null;
        $bvnDetails['phone'] = substr_replace(($verifyBvn['data']['phone_number']) ? PhoneNumber::make($verifyBvn['data']['phone_number'], 'NG') : '', ' + 234', 0, 1);
        $bvnDetails['enrollmentBank'] = trim($verifyBvn['data']['enrollment_bank']);
        $bvnDetails['enrollmentBankBranch'] = trim($verifyBvn['data']['enrollment_branch']);

        return $bvnDetails;
    }
}
