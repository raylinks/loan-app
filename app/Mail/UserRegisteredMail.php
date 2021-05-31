<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        $address = 'noreply@lazynerd.com.ng';
        $subject = 'Welcome To Lazy Nerd';
        $name = 'Susan from Lazy Nerd';

        return $this->view('emails.user-registered')
            ->from($address, $name)
            ->subject($subject)
            ->with([
                'firstname' => $this->data['firstname'],
                'email' => $this->data['email'],
                'token' => $this->data['token'],
                'url' => $this->data['url'],
            ]);
    }
}
