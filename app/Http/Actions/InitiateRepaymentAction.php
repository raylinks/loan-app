<?php

namespace App\Http\Actions;

use Exception;
use App\Models\Business;
use App\Support\Domains;
use App\Models\Reference;
use App\Models\Repayment;
use App\Models\WalletType;
use App\Models\Transaction;
use App\Support\Currencies;
use Illuminate\Support\Str;
use App\Models\CryptoWallet;
use App\Http\Clients\Monnify;
use App\Contracts\CryptoCslient;
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

        DB::beginTransaction();
        try {

            $ref = $this->generateRef();

            $transRef = md5(Str::random(20));

            Reference::create([
                'user_id' => auth()->user()->id,
                'payment_reference' => $ref,
                'transaction_reference' => $transRef,
                'amount' => $request->amount,
                'status' => Reference::STATUSES['PENDING'],
                'transaction_type' => Reference::TYPES['REPAYMENT'],
            ]);

            $trans = Transaction::create([
                'user_id' => auth()->user()->id,
                'reference' => Transaction::generateReference(),
                'type' => $request->amount,
                'status' => Repayment::STATUSES['PENDING'],
            ]);

            Repayment::create([
                'user_id' => auth()->user()->id,
                'transaction_id' => $trans->id,
                'amount' => $request->amount,
                'status' => Repayment::STATUSES['PENDING'],
                'repay_type' => 'paystack_popup',
            ]);

            Transaction::create([
                'user_id' => auth()->user()->id,
                'reference' => Transaction::generateReference(),
                'type' => $request->amount,
                'status' => Repayment::STATUSES['PENDING'],
            ]);

            DB::commit();
            return true;
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            abort(500, "Please try again later");
        }


        //   $response = (new Paystack())->initiateRepayment($request->amount, $ref);

    }

    public function generateRef()
    {
        $ref = time() . '_' . uniqid();

        // Ensure that the reference has not been used previously
        $validator = \Validator::make(['ref' => $ref], ['ref' => 'unique:references,payment_reference']);

        if ($validator->fails()) {
            return $this->generateRef();
        }

        return $ref;
    }
}
