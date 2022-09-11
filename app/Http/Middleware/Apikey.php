<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiKey
{

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        $authorizedApiUser = User::query()->where('access_token',$token)->first();

        if($token != null && $authorizedApiUser){
            return $next($request);
        } else{
            return response()->json(['message'=>'authentication failed'],403);
        }
    }
}
