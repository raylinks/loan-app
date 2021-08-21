<?php

namespace App\Http\Clients;

use Exception;
use App\Models\Reference;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;
use Illuminate\Http\Client\PendingRequest;

class Monnify
{
    protected PendingRequest $client;

    public function __construct($token)
    {
        $this->client = Http::withHeaders(['Authorization' =>   'Bearer'  .  $token])
            ->baseUrl(config('monnify.base_url'));
    }

    public function initiateRepayment($amount, $ref)
    {
        $requestData = $this->initiatePayload($amount, $ref);
        $res =  $this->client->post('v1/merchant/transactions/init-transaction', $requestData)->throw()->json();
        dd($res);
    }

    public function payWithcard()
    {
        $requestData = $this->cardPayload();
        $res =  $this->client->post('v1/merchant/cards/charge', $requestData)->throw()->json();
        dd($res);
    }

    protected function initiatePayload($amount, $ref)
    {

        return [
            "amount" => $amount,
            "customerName" => "raymond ray",
            "customerEmail" => "ray@gmail.com",
            "paymentReference" => $ref,
            "paymentDescription" => "Trial transaction",
            "currencyCode" => "NGN",
            "contractCode" => config('monnify.contract-code'),
            "redirectUrl" => "https://my-merchants-page.com/transaction/confirm",
            "paymentMethods" => ["CARD", "ACCOUNT_TRANSFER"]
        ];
    }

    protected function cardPayload()
    {
        $trans = Reference::where('user_id', auth()->user()->id)->where('status', false)->first();

        return [
            "transactionReference" => $trans->transaction_reference,
            "collectionChannel" => "API_NOTIFICATION",
            // "card": {
            //     "number": "5061040000000000215",
            //     "expiryMonth": "09",
            //     "expiryYear": "2022",
            //     "pin": "1234",
            //     "cvv": "122"
            // }
        ];
    }
}
