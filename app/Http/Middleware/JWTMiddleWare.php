<?php

namespace App\Http\Middleware;
use Closure;
use JWTAuth;
use Exception;

class JWTMiddleWare
{
    
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid'],401);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired'],500);
            }else{
                return response()->json(['status' => 'Authorization Token not found'],404);
            }
        }
        return $next($request);
    }
}
