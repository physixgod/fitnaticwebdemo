<?php

namespace App\Service;

use Twilio\Rest\Client;

class TwilioService
{
    private $accountSid = 'ACaeed792b6d4ddbea85a7094f8fe5e2b2';
    private $authToken = '70a03b9845c4099898d3a9da2f15d17f';
    private $twilioPhoneNumber = '+12408959360';

    public function sendSMS($to, $body)
    {
        $client = new Client($this->accountSid, $this->authToken);
        $client->messages->create(
            $to,
            [
                'from' => $this->twilioPhoneNumber,
                'body' => $body,
            ]
        );
    }
}
