<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BvnVerification extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'email', 'firstname','last_name', 'bvn', 'phone', 'date_of_birth', 'enrollment_bank', 'enrollment_bank_branch'];
}
