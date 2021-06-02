<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    const TOKEN_EXPIRES_IN_HOURS = 1;

    protected $guarded = [];
}
