<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date_of_birth', 'user_id', 'title', 'marital_status', 'address', 'current_employment' , 'occupation', 'years_of_employment', 'monthly_income'
    ];

    protected $keyType = 'string';
}
