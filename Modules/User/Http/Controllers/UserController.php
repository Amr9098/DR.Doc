<?php

namespace Modules\User\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:7|max:15',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        } else {
            $cer = $request->only('phone', 'password');
            try {
                if (!JWTAuth::attempt($cer)) {
                    return response()->json(['message' => 'Phone Number Or Password incorrect'], 422);
                } elseif (JWTAuth::attempt($cer) && JWTAuth::user()->suspended == "true") {
                    return response()->json(['message' => 'Your Account is suspended, please contact us.'], 422);
                }
            } catch (JWTException $e) {
                $response['data'] = null;
                $response['code'] = 0;
                $response['error'] = 'could not create token';
                return response()->json([$response, $e], 400);
            }

            // Check if the user is multiple users
            $user = User::find(Auth::id());
            if ($user->multiuser == 'false') {
                    if(!is_null($user->remember_token )){
                        auth()->setToken( $user->remember_token )->logout();
                    }
            }

            //create a new token
            JWTAuth::factory()->setTTL(60 * 24 * 100);
            $token = auth()->attempt($cer);


            $user->update([
                'remember_token' => $token,
            ]);
            return $this->createNewToken($token);


        }
    }

    public function me(){
        $user=User::find(Auth::id());

        $response['user'] = [
            "data" => $user,
            "roles"=>$user->getRoleNames(),
            "permissions"=>$user->getAllPermissions()->pluck('name'),
        ];

        if(!$user){
            return response()->json(['message'=>'Your Account is UNAUTHORIZED, Login again.'],422);
        }
        return response()->json($response,200);

    }


    public function logout(){
        auth()->logout();
        return response()->json(["message"=>"Successfully logged out"],200);

}

protected function createNewToken($token){
    $user = User::find(Auth::id());
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth()->factory()->getTTL(),
        'user' => auth()->user(),
        "permissions" => $user->getAllPermissions()->pluck('name'),
         "roles" => $user->getRoleNames(),

    ]);
}
}
