<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use App\Models\UserVerificationCode;
use App\Services\SMSGateWays\twilio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Services\Verification\VerificationCode as VerificationVerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserVerificationController extends Controller
{

    public $Verification, $SendSms;

    public function __construct(VerificationVerificationCode $Verification_Code, twilio $Send_SMS)
    {
        $this->Verification = $Verification_Code;
        $this->SendSms = $Send_SMS;
    }

    public function SendVerificationCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:7|max:15',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $checkTime = 7;
            $checkPhoneIsExist = User::where('phone', '=', $request->phone)->first();
            if (!$checkPhoneIsExist) {
                return response()->json(["message" => 'This mobile number does not belong to any user in the app'], 422);
            } elseif ($checkPhoneIsExist->verified == true) {
                return response()->json(["message" => 'This mobile number has already been verified'], 422);
            } else {
                $checkIfUserHasCode = UserVerificationCode::where("user_id", $checkPhoneIsExist->id)->first();
                if ($checkIfUserHasCode) {
                    if (Carbon::now()->addHours(2)->diffInMinutes($checkIfUserHasCode->date) < $checkTime) {
                        return response()->json(["message" => "OTP still valid"], 422);
                    } else {
                        $OTP = $this->Verification->SetVerificationCodeToUser($checkPhoneIsExist->id);
                        $this->SendSms->SendSms($checkPhoneIsExist, $OTP);
                        return response()->json([
                            "message" => "The code has been sent successfully", "notice" => "The code is valid for $checkTime minutes"
                        ], 201);
                    }
                }
            }
        }
    }
    public function CheckOTPByPhone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:7|max:15',
            'code' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $checkPhoneIsExist = User::where('phone', $request->phone)->first();
            if (!$checkPhoneIsExist) {
                return response()->json(["message" => 'This mobile number does not belong to any user in the app'], 422);
            } else {
                $checkIfUserHasCode = UserVerificationCode::where("user_id", $checkPhoneIsExist->id)->first();
                if (!$checkIfUserHasCode) {
                    return response()->json(["message" => "No verification code was sent to this number"], 422);
                } else {
                    if (Carbon::now()->addHours(2)->diffInMinutes($checkIfUserHasCode->date) > 7) {
                        return response()->json(["message" => "code has expired"], 422);
                    }
                }
                if ($checkIfUserHasCode->code != $request->code) {
                    return response()->json(["message" => "Invalid code number"], 422);
                } else if ($checkIfUserHasCode->code == $request->code) {
                    $checkPhoneIsExist->update([
                        "verified" => true,
                    ]);
                    return response()->json(["message" => "Confirmed successfully 👌"], 201);
                }
            }
        }
    }



    public function SendVerificationCodeToAuthUser()
    {

            $checkTime = 7;
            $checkPhoneIsExist = User::find(Auth::id());
            if (!$checkPhoneIsExist) {
                return response()->json(["message" => 'Token Error'], 422);
            } elseif ($checkPhoneIsExist->verified == true) {
                return response()->json(["message" => 'This mobile number has already been verified'], 422);
            } else {
                $checkIfUserHasCode = UserVerificationCode::where("user_id", $checkPhoneIsExist->id)->first();
                if ($checkIfUserHasCode) {
                    if (Carbon::now()->addHours(2)->diffInMinutes($checkIfUserHasCode->date) < $checkTime) {
                        return response()->json(["message" => "OTP still valid"], 422);
                    } else {
                        $OTP = $this->Verification->SetVerificationCodeToUser($checkPhoneIsExist->id);
                        $this->SendSms->SendSms($checkPhoneIsExist, $OTP);
                        return response()->json([
                            "message" => "The code has been sent successfully", "notice" => "The code is valid for $checkTime minutes"
                        ], 201);
                    }
                }
            }
        }
    }







