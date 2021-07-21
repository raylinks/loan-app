<?php

namespace App\Http\Controllers\User;

use App\Models\LoanRequest;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function incomingTransactions()
    {
        $incoming = LoanRequest::where('user_id', auth()->id())->where('status', 'successful')->sum('amount');

        return $this->okResponse('Amount for incoming transactions.',$incoming);
    }

    public function outgoingTransactions()
    {
        $outgoing = LoanRequest::where('user_id', auth()->id())->sum('amount');

        return $this->okResponse('Amount for outgoing transactions.',$outgoing);
    }
}