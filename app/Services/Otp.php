<?php

namespace App\Services;

use Throwable;
use App\Models\User;
use App\Events\ProcessOtpSuccess;

class Otp
{
    public const DEFAULT_SMS_CHANNEL = 'sms';

    public const DEFAULT_CODE = '+234';
   
     /**
     * The channel with which the OTP is sent to the customer.
     *
     * @var
     */
    public $channel;

    public function sendOTP($phone, $token, $text, $user, $isRegistration = false)
    {
        try {
            /*
             *User receives OTP in their email if they are registered already
             *@param user object email, UserOtp class, OTP token, User object
             */
            if ($isRegistration) {
                return null;
            }

           $otp = event(new ProcessOtpSuccess([
                'token' => $token,
                'user' => $user,
                'phone' => $phone,
                'text' => $text,
                'channel' => $this->channel,
            ]));

             return $otp;
        } catch (Throwable $e) {
            abort(503, 'Unable to validate information.');
        }
    }

    /**
     * handles re-formating of phone num to the accepted format of twilio
     * sends OTP to user phone
     * verifies OTP.
     *
     * @param $phone
     * @param $user_id
     * @param null $calling_code
     *
     * @return string|null
     */
    public function formatPhone($phone, $user_id, $calling_code = null): ?string
    {
        $user = User::where('id', $user_id)->first();

        if (null !== $calling_code && '0' === $phone[0]) {
            // check if calling code was sent then append to number if number begins with "0"
            return $calling_code . substr($phone, 1);
        }

        if ('0' === $phone[0] && is_null($calling_code)) {
            // if no calling code was sent use user country dailing code
            return $user->country->dialing_code . substr($phone, 1);
        }

        if ('0' !== $phone[0] && '+' !== $phone[0] && ! is_null($calling_code)) {
            return $calling_code . $phone;
        }

        if ('0' !== $phone[0] && '+' !== $phone[0] && is_null($calling_code)) {
            return '+' . $phone;
        }

        if ('+' === $phone[0]) {
            //check if phone number contains + then return it like that
            return $phone;
        }
    }
}
