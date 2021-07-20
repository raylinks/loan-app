<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes,  Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array?
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'eligible_amount',
        'email_token',
        'phone_number',
        'registration_completed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

        /**
     * Relationship with the UserDetails model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function details(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(UserDetail::class, 'user_id');
    }

    public function token(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Token::class, 'user_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction\Transaction');
    }

    public function bvn()
    {
        return $this->hasOne(BvnVerification::class, 'user_id');
    }

    public function bankAccount()
    {
        return $this->hasOne(UserBankAccount::class, 'user_id');
    }

    public function userWallet()
    {
        return $this->hasOne('App\Models\UserWallet');
    }

    public function loanEligible()
    {
        return  $this->belongsTo(LoanEligible::class, 'loan_eligible_id');
    }
}
