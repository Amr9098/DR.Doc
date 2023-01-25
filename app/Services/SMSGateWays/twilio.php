<?php
namespace App\Services\SMSGateWays;


use Twilio\Rest\Client;

class twilio{

    public function SendSms($user, $otp)
    {
        $SID = env('SID');
        $Token = env('Token');
        $Number = env('Number');
        $client = new Client($SID, $Token);
        $client->messages->create(
            $user->phone,
            ['from' => $Number, 'body' => ['Hello 😊 , your code is : ' . $otp]]
        );
    }
}
