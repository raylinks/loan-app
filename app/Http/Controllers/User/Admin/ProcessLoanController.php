<?php

namespace App\Http\Controllers\Admin;

use App\Http\Actions\ProcessLoanAction;
use App\Models\LoanRequest;
use App\Models\Transaction;
use App\Http\Controllers\Controller;

class ProcessLoanController extends Controller
{
    public function index()
    {
        $pending = LoanRequest::where('status', LoanRequest::STATUSES['PENDING'])->get();

        return view('admin.loan-requests.index', compact('pending'));
    }

    public function processLoan(Transaction $transaction)
    {
        $loanTransaction = LoanRequest::where('transaction_id', $transaction->work)->first();

        if (is_null($loanTransaction)) {
            return redirect()->route('perfect_money.processing')->with('error', 'Transaction not found');
        }

        $response = (new ProcessLoanAction())->execute($loanTransaction);

        return view('admin.loan-requests.index', compact('response'));

    }
}