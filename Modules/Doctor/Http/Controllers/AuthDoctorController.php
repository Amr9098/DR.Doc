<?php

namespace Modules\Doctor\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Modules\Doctor\Transformers\DoctorResource;

class AuthDoctorController extends Controller
{



    public function AuthDoctorProfile(){

        $authDoctorData = Doctor::where("user_id", Auth::id())->first();
        if (!$authDoctorData) {
            return response()->json(["message" => "Not Found"], 404);
        } else {
            return new DoctorResource($authDoctorData);
        }
    }
    public function AuthDoctorUpdateProfile(Request $request ){

        $validator = Validator::make($request->all(), [
            'specialization_id' => 'required|exists:specializations,id',
            'bio' => 'required|min:7|max:250',
            'gender' => 'required|in:Male,Female',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            $updateDoctor=Doctor::where("user_id", Auth::id())->first();
            if(!$updateDoctor){
                return response()->json(["message" => "Not Found"], 404);
            }
            $updateDoctor->update([
                "specialization_id"=>$request->specialization_id,
                "bio"=>$request->bio,
                "gender"=>$request->gender,
            ]);
            return response()->json(["message" => "Doctor Data Updated successfully"], 200);
        }
    }


}
