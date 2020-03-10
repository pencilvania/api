<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use JWTAuth;
use Tymon\JWTAuth\Token;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Illuminate\Session\TokenMismatchException;
use App\Http\AppResponse;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
class JWTAuthenticate extends BaseMiddleware
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    /*   public function handle($request, Closure $next, $guard = null)
    {
     $rawToken = $request->cookie('token');
        $token = new Token($rawToken);
        $payload = JWTAuth::decode($token);
        Auth::loginUsingId($payload['sub']);

        return $next($request);
    }*/

    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['status' => 'Token is Invalid']);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['status' => 'Token is Expired']);
            }else{
                return response()->json(['status' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
