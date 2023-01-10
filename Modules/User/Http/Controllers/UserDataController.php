<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserDataController extends Controller
{

    public function  UpdateAuthUserData(Request $request ){

        $authUser = User::find(Auth::id());

        if(!$authUser){
            return response()->json(["message" => "Not Found "],404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3|max:50',
            'phone' => "required|min:7|max:15|unique:users,phone,$authUser->id",

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $authUser->update([
                "name" =>$request->name,
                "phone" =>$request->phone,
            ]);
            return response()->json(["message" =>"Data updated successfully"],200);
        }



    }


}
