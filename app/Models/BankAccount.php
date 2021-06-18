<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Crypt;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','customer_name','account_name','account_number','bvn','email','status'];



    /**
     * Returns the client that the account belongs to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Encrypt customer BVN.
     *
     * @param string $bvn
     * @return void
     */
    public function setBvnAttribute(string $bvn)
    {
        $this->attributes['bvn'] = Crypt::encryptString($bvn);
    }

    /**
     * Decrypt customer BVN.
     *
     * @param string $bvn
     * @return string
     */
    public function getBvnAttribute(string $bvn): string
    {
        return Crypt::decryptString($bvn);
    }

    /*
    * Gets account
    *
    * @param $accountNumber
    * @param $clientId
    * @return self
    */
    public static function getAccount($accountNumber, $userId)
    {
        return self::where('account_number', $accountNumber)
                    ->where('user_id', $userId)
                    ->first();
    }

    /**
     * @param string $email
     * @return bool
     */
    public static function hasAccount(string $email): bool
    {
        return self::where('email', $email)->exists();

    }

}