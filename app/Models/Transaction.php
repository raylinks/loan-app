<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
         'user_id', 'reference', 'type',  'status', 'response_message',
    ];

    protected $hidden = [
        'id', 'user_id', 'deleted_at', 'updated_at', 'delay',
    ];

    public const STATUSES = [
        'PENDING' => 'pending',
        'INITIATED' => 'initiated',
        'PROCESSING' => 'processing',
        'SUCCESSFUL' => 'successful',
        'DECLINED' => 'declined',
        'FAILED' => 'failed',
        'ABANDONED' => 'abandoned',
    ];

    public static function generateReference(): string
    {
        do {
            $reference = 'TRANS_'.Str::random(15);
        } while (self::whereReference($reference)->exists());

        return $reference;
    }

}
