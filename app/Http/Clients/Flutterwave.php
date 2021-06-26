<?php

namespace App\Http\Clients;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Traits\HasBvnProviderResponse;
use Illuminate\Http\Client\PendingRequest;

class Flutterwave
{
    use HasBvnProviderResponse;
    
    protected PendingRequest $client;

    public function __construct()
    {
      //  dd(config('flutterwave.payment_url'));
        $this->client = Http::withHeaders(['Authorization' => 'Bearer '.config('flutterwave.secret_key')])
            ->baseUrl(config('flutterwave.payment_url'));
    }

    /**
     * Calls Flutterwave'S provider api.
     *
     * @param string $bvn
     *
     * @returns array
     */
    public function verifyBvn(string $bvn)
    {
       // dd($bvn);
        try {
            $verifyBvn = $this->client->get("kyc/bvns/{$bvn}")->throw()->json();
            dd($verifyBvn->response->json());
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
        $data = $this->flutterWave($verifyBvn);
        $bvnDetails = [];

        $bvnDetails['first_name'] = $data->firstName;
        $bvnDetails['last_name'] = $data->lastName;
        $bvnDetails['phone'] = $data->phone;
        $bvnDetails['email'] = $data->email;
        $bvnDetails['date_of_birth'] = $data->dateOfBirth;
        $bvnDetails['enrollment_bank'] = $data->enrollmentBank;
        $bvnDetails['enrollment_bank_branch'] = $data->enrollmentBankBranch;

        return $bvnDetails;
    }

    public function getAccountName(string $account_number, string $bank_code)
    {
        $response = $this->post('gpx/transfers/beneficiaries/create', [
            'json' => [
                'account_number' => $account_number,
                'account_bank' => $bank_code,
                'seckey' => config('flutterwave.secretKey'),
            ],
        ]);

        return $response;
    }
}
