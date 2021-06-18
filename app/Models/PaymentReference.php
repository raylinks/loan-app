<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReference extends Model
{
    use HasFactory;

    public $fillable = ['user_id', 'status', 'reference','status'];

    public const TYPES = [
        'REPAYMENT' => 'repayment',
    ];

    public const STATUSES = [
        'PENDING' => 'pending',
        'PROCESSING' => 'processing',
        'SUCCESSFUL' => 'successful',
    ];

    public static function generateCode()
    {
        do {
            $paymentCode = rand(100000, 999999);
        } while (self::where('code', $paymentCode)->exists());

        return $paymentCode;
    }
}
