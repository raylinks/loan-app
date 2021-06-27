<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_id', 'amount', 'loan_eligible_id', 'status'];

    public const STATUSES = [
        'PENDING' => 'pending',
        'INITIATED' => 'initiated',
        'PROCESSING' => 'processing',
        'SUCCESSFUL' => 'successful',
        'DECLINED' => 'declined',
        'FAILED' => 'failed',
        'ABANDONED' => 'abandoned',
    ];

}
