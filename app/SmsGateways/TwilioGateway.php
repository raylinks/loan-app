<?php

namespace App\SmsGateways;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Http;
use Twilio\Exceptions\ConfigurationException;

class TwilioGateway implements SmsGatewayProvider
{
    private $accountSid;

    private $authToken;

    private $twilioPhone;

    private $message;

    private $recipientPhone;


    public function __construct()
    {
        $this->client = Http::withHeaders(['Authorization' => 'Bearer '.config('flutterwave.secret_key')])
            ->baseUrl(config('flutterwave.payment_url'));
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public function send()
    {
        try {
            $client = new Client($this->accountSid, $this->authToken);
        } catch (ConfigurationException $exception) {
            return $exception->getMessage();
        }

        return $client->messages->create($this->recipientPhone, [
            'from' => $this->twilioPhone,
            'body' => $this->message,
        ]);
    }

    // /**
    //  * {@inheritdoc}
    //  */
    public function setMessageData(string $phoneNumber, string $message, string $channel = null)
    {
        $this->accountSid = config('twilio.twilio_account_sid');
        $this->authToken = config('twilio.twilio_auth_token');
        $this->twilioPhone = 0 === strpos($phoneNumber, '+234') || (0 === strpos($phoneNumber, '+233'))
            ? config('twilio.twilio_phone')
            : config('twilio.twilio_us_phone');
        $this->recipientPhone = $phoneNumber;
        $this->message = $message;

        return $this;
    }
}
