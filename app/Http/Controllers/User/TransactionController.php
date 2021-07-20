<?php

namespace App\Http\Controllers\User;

use App\Models\Transaction;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::where('user_id', auth()->user()->id)->with('user')->get();

        return $this->okResponse("Transaction retrieved successfully", $transaction);
    }
}