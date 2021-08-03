<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;

    protected $guarded = [];
//     protected $fillable = [
//         'user_id', 'account_number', 'bank_name',  'bank_id', 'account_name',
 
//    ];

   protected $hidden = [
        'user_id', 'created_at', 'updated_at', 'id'
   ];
}
