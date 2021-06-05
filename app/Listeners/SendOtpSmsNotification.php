<?php

namespace App\Listeners;

use App\Events\ProcessOtpSuccess;
use App\SmsGateways\TwilioGateway;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendOtpSmsNotification implements ShouldQueue
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
        (new TwilioGateway())->setMessageData(
            $event->data['phone'],
            $event->data['text'],
            $event->data['channel']
        )->send();
    }
}
