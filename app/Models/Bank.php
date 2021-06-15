<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
         'name', 'code',
    ];

    protected $hidden = [
        'id', 'created_at', 'updated_at',
    ];

    protected $casts = [
        'is_available' => 'boolean',
    ];

    public static function getBankWithCode($bank_code)
    {
        return self::where('code', $bank_code)->first();
    }
}
