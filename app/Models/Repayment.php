<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_id', 'repay_type', 'amount', 'status'];

    public const TYPES = [
        'REPAYMENT' => 'repayment',
    ];

    public const STATUSES = [
        'PENDING' => 'pending',
        'PROCESSING' => 'processing',
        'SUCCESSFUL' => 'successful',
    ];
}
