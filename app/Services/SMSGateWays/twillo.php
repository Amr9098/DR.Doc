<?php
namespace App\Http\Services\SMSGateWays;

use Twilio\Rest\Client;

class twilio{

    public function SendSms($user, $otp)
    {
        $SID = env('SID', '');
        $Token = env('Token', '');
        $Number = env('Number', '');
        $client = new Client($SID, $Token);
        $client->messages->create(
            $user->mobile,
            ['from' => $Number, 'body' => ['Hello 😊 , your code is : ' . $otp]]
        );
    }
}
