<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterSendOtp extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $token;
    public $user;

    /**
     * Sends otp to user email.
     *
     * @param $data
     */
    public function __construct($data)
    {
        //dd($data);
        $this->token = $data['token'];
        $this->user = $data['user'];
    }

    /**
     * Build the otp email message.
     *
     * @return $this email message view
     */
    public function build(): self
    {
      // dd('iii');
        return $this->view('emails.register-send-otp')
            ->to($this->user->email)
            ->subject('Your OTP PIN')
            ->with([
                'token' => $this->token,
                'firstname' => $this->user->first_name,
            ]);
    }
}
