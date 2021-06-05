<?php

namespace App\Mail;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $reset;

    public $urlQuery;

    /**
     * Create a new message instance.
     *
     * @param \App\Model\User $user
     * @param \App\Models\PasswordReset $reset
     *
     * @return void
     */
    public function __construct(User $user, PasswordReset $reset)
    {
        $data = [
            'token' => $reset->token,
        ];

        $urlQuery = http_build_query($data);

        $this->urlQuery = $urlQuery;
        $this->user = $user;
        $this->reset = $reset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reset Password')->markdown('emails.reset');
    }
}
