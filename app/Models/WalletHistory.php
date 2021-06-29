<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    use HasFactory;

    protected $fillable = ['uuid','user_id', 'transaction_id','status','current_balance', 'previous_balance'];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
