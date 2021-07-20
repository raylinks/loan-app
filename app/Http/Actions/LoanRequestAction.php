<?php

namespace App\Http\Actions;

use Exception;
use App\Models\User;
use App\Models\LoanRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class LoanRequestAction
{
    public function execute($request)
    {
        DB::beginTransaction();
        try {

        $user = User::with('loanEligible')->where('id', auth()->user()->id)->first();

        $trans = Transaction::create([
            'user_id' => auth()->user()->id,
            'reference' => Transaction::generateReference(),
            'type' => "LOAN",
            'status' => Transaction::STATUSES['PENDING'],
        ]);
    

       $loan =  LoanRequest::create([
            'user_id' => auth()->user()->id,
            'transaction_id' => $trans->id,
            'amount' => $request->amount,
            'status' => LoanRequest::STATUSES['PENDING']
        ]);

        DB::commit();

        return $loan;

    } catch (Exception $exception) {
        dd($exception);
        DB::rollBack();

        abort(503, "Service is unavailable to process loan request");
    }

    }
}
