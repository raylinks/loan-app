<?php

namespace App\Http\Actions;

use App\Models\Business;
use App\Support\Domains;
use App\Models\Repayment;
use App\Models\WalletType;
use App\Models\Transaction;
use App\Support\Currencies;
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
         PaymentReference::create([
            'user_id' => auth()->user()->id,
            'refwerence' => PaymentReference::generateCode(),
            'amount' => $request->amount,
            'status' => PaymentReference::STATUSES['PENDING'],
            'transaction_type' => PaymentReference::TYPES['REPAYMENT'],
        ]);

        Repayment::create([
            'user_id' => auth()->user()->id,
            'transaction_id' => PaymentReference::generateCode(),
            'amount' => $request->amount,
            'status' => Repayment::STATUSES['PENDING'],
            'repay_type' => 'monnify_with_card',
        ]);

        Transaction::create([
            'user_id' => auth()->user()->id,
            'reference' => Transaction::generateReference(),
            'type' => $request->amount,
            'status' => Repayment::STATUSES['PENDING'],
        ]);


        $response = (new Monnify())->payWithCard();

    }
}
