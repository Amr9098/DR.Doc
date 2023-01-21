<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function UpdateAuthUserPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => [
                'required',
                'different:old_password',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {

            if (!Hash::check($request->old_password, Auth::user()->password)) {
                return response()->json(["message"=> "Old Password Doesn't match!"], 402);
            } else {
                User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
                return response()->json(["message"=> "Password changed successfully!"], 201);
            }
        }
    }


}
