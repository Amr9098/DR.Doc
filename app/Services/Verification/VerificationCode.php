<?php

namespace App\Services\Verification;

use App\Models\UserVerificationCode;
use Carbon\Carbon;

class VerificationCode
{

    public function SetVerificationCodeToUser($user_id)
    {
        $code = mt_rand(1000, 9999);
        $date = Carbon::now()->addHours(2)->format("Y-m-d H:i:s");

        UserVerificationCode::whereNotNull("user_id")->where(['user_id' => $user_id])->delete();
        UserVerificationCode::create([
            "user_id" => $user_id,
            "code" => $code,
            "date" => $date,
        ]);
        return $code;
    }


}


