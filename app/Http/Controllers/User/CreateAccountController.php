<?php

namespace App\Http\Controllers\User;

use App\Models\BankAccount;
use Illuminate\Support\Str;
use App\Http\Clients\AuthRequest;
use App\Models\CustomBankAccount;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Resources\Business\Team\CreateAccountResource;

class CreateAccountController extends Controller
{

    protected PendingRequest $client;
    protected $virtualAccountEndpoint = 'v1/bank-transfer/reserved-accounts';
    protected $token;
    private $authEndpoint = 'v1/auth/login';
    private $userAccount;
    private $request;
   
    public function store(CreateAccountRequest $request): JsonResponse
    {
        $this->request = $request;

        //checks if customer already have an account
        $exists = CustomBankAccount::hasAccount($this->request->email);
        if ($exists) {
            return $this->forbiddenResponse('Account exists for customer');
        }

  
        $response =   (new AuthRequest())->token(); 
       
        $this->authRequestResponse();
        $response = $this->requestResponse();

        if (isset($response) && $response->requestSuccessful === false) {
            return $this->serverErrorResponse('Unable to create virtual account');
        }

        $account = $this->saveAccountDetails($response);
        return $this->okResponse('Account created successfully', new CreateAccountResource($account));
    }

     /**
     * Get the response from making request to log in .
     *
     * @return mixed
     * @throws \Exception
     */
    private function authRequestResponse(): self
    {

        $url = config('monnify.base_url') . $this->authEndpoint;
        $response = (new CurlService())->appendRequestHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . $this->getEncodedAuth(),
        ])->post($url)->asObject();
        $this->token = $response->responseBody->accessToken;

        return $this;
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

  
     /**
     * Send request to monnify
     *
     * @return mixed
     * @throws \Exception
     */
    private function requestResponse()
    {
        $endpoint = config('monnify.base_url') . $this->virtualAccountEndpoint;

        return (new CurlService())
            ->appendRequestHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->token,
            ])->post(
                $endpoint, $this->requestData()
            )->asObject();
    }
 
    /**
     * Get request data for virtual account creation
     *
     */
    private function requestData(): string
    {
        return json_encode([
            'accountReference' => $this->generateReference(),
            'accountName' => $this->request->accountName,
            'currencyCode' => "NGN",
            'contractCode' => config('vaunt.monnify.contract_code'),
            'customerEmail' => $this->request->email,
            'customerBvn' => $this->request->bvn,
            "customerName" => $this->request->customerName,
        ]);
    }

    /**
     * @return string
     */
    private function generateReference(): string
    {
        $splitName = explode(' ', trim($this->request->accountName));
        $lastName = $splitName[count($splitName) - 1];

        return Str::upper(sprintf('%s%s%s%s',
            str_replace(' ', '', $lastName),
            'CLACKWEB', 'MF',
            rand(1000, 9999)
        ));

    }

    /**
     * @param $response
     * @return mixed
     */
    private function saveAccountDetails($response)
    {
        return BankAccount::create([
            'account_number' => $response->responseBody->accountNumber,
            'account_name' => $this->request->accountName,
            'user_id' => $this->clientId,
            'bvn' => $this->request->bvn,
            'customer_name' => $response->responseBody->customerName,
            'email' => $response->responseBody->customerEmail,
            'status' => $response->responseBody->status
        ]);
    }
}
