<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\UserRegistered as UserRegisteredMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $data = ['firstname' => $event->user->firstname, 'email' => $event->user->email, 'token' => $event->user->email_token, 'url' => $event->callback];

        Mail::to($data['email'])->send(new UserRegisteredMail($data));
    }
}
