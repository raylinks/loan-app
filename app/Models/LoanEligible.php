<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanEligible extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'amount', 'range_from', 'range_to'];

}
