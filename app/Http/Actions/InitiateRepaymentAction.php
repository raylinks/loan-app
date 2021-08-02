<?php

namespace App\Http\Actions;

use App\Models\Business;
use App\Support\Domains;
use App\Models\Repayment;
use App\Models\WalletType;
use App\Models\Transaction;
use App\Support\Currencies;
use Illuminate\Support\Str;
use App\Models\CryptoWallet;
use App\Http\Clients\Monnify;
use App\Contracts\CryptoClient;
use App\Models\PaymentReference;
use App\Models\CryptoTransaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoServiceWallet;
use App\Models\CryptoWalletTransfer;
use App\Http\Resources\BusinessWalletResource;
use App\Exceptions\InsufficientBalanceException;

class InitiateRepaymentAction
{
    public function execute($request)
    {
        $ref = $this->generateRef();

        // $transRef = md5(Str::random(20));

        //  Reference::create([
        //     'user_id' => auth()->user()->id,
        //     'payment_reference' => $ref,
        //     'transaction_reference' => $transRef,
        //     'amount' => $request->amount,
        //     'status' => PaymentReference::STATUSES['PENDING'],
        //     'transaction_type' => PaymentReference::TYPES['REPAYMENT'],
        // ]);

        // Repayment::create([
        //     'user_id' => auth()->user()->id,
        //     'transaction_id' => PaymentReference::generateCode(),
        //     'amount' => $request->amount,
        //     'status' => Repayment::STATUSES['PENDING'],
        //     'repay_type' => 'monnify_with_card',
        // ]);

        // Transaction::create([
        //     'user_id' => auth()->user()->id,
        //     'reference' => Transaction::generateReference(),
        //     'type' => $request->amount,
        //     'status' => Repayment::STATUSES['PENDING'],
        // ]);


        $response = (new Monnify())->initiateRepayment($request->amount, $ref);

    }

    public function generateRef()
    {
        $ref = time() . '_' . uniqid();

        // Ensure that the reference has not been used previously
        $validator = \Validator::make(['ref' => $ref], ['ref' => 'unique:payment_references,reference']);

        if ($validator->fails()) {
            return $this->generateRef();
        }

        return $ref;
    }
}
