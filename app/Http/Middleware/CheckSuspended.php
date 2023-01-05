<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSuspended
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        if(!Auth::check()){
            $response['error'] = 'user not logged in system , error in token';
            $response['code'] = 0;
            return response()->json($response,401);
        }
        elseif (auth()->user()->suspended == "true") {
            $response['error'] = 'This user has been suspended by the admin, please refer to the administration to solve the problem';
            $response['code'] = 0;
            auth()->logout();
            return response()->json($response,401);
        }else{
            return $next($request);
        }
    }
}
