<?php

namespace App\Http\Actions;

use Exception;
use App\Models\User;
use App\Models\UserWallet;
use App\Models\LoanRequest;
use App\Models\Transaction;
use App\Models\WalletHistory;
use Illuminate\Support\Facades\DB;

class ProcessLoanAction
{
    public function execute($loanTransaction)
    {
        DB::beginTransaction();
        try {


         $this->updateUserWallet($loanTransaction);
        

        $loanTransaction->update([
            'status' => LoanRequest::STATUSES['SUCCESFUL'],
        ]);

        $loanTransaction->transaction->update(['status' => 'successful']);
           


        DB::commit();

        return redirect()->route('perfect_money.processing')->with('success', 'Transaction confirmed Successfully');

    } catch (Exception $exception) {
        DB::rollBack();

        return redirect()->route('perfect_money.processing')->with('error', 'Operation failed');
    }

    }

    // private function updateUserWallet(User $user, float $amount, CryptoSale $pmTransaction)
    private function updateUserWallet($loanTransaction)
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();
        $previousAmount = (float) $wallet->actual_amount;
        $currentAmount = (float) $previousAmount + $amount;

        $wallet->update([
            'initial_amount' => $previousAmount,
            'actual_amount' => $currentAmount,
        ]);

        WalletHistory::create([
            'user_id' => $wallet->user_id,
            'transaction_id' => $pmTransaction->transaction_id,
            'status' => WalletHistory::STATUS_RECEIVED,
            'current_balance' => $currentAmount,
            'previous_balance' => $previousAmount,
        ]);

        return $wallet;
    }
}
