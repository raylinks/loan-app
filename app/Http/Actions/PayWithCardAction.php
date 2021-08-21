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
use App\Models\Reference;
use App\Models\CryptoTransaction;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Models\CryptoServiceWallet;
use App\Models\CryptoWalletTransfer;
use App\Http\Resources\BusinessWalletResource;
use App\Exceptions\InsufficientBalanceException;

class PayWithCardAction
{
    public function execute($request)
    {
    }
}
