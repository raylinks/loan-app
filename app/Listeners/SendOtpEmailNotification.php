<?php

namespace App\Listeners;

use App\Mail\UserOtp;
use App\Mail\RegisterSendOtp;
use App\Events\ProcessOtpSuccess;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOtpEmailNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\ProcessOtpSuccess $event
     *
     * @return void
     */
    public function handle(ProcessOtpSuccess $event): void
    {
        Mail::send(new RegisterSendOtp($event->data));
    }
}
