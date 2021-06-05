<?php

namespace App\SmsGateways;

interface SmsGatewayProvider
{
    /**
     * Initialize the parameters needed to send message.
     *
     * @param string $phoneNumber
     * @param string $message
     * @param string|null $channel
     *
     * @return mixed
     */
    public function setMessageData(string $phoneNumber, string $message, string $channel = null);

    /**
     * This method implements the sending of SMS for each gateway.
     *
     * @return mixed
     */
    public function send();
}
