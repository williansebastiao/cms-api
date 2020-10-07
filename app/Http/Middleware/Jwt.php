<?php

namespace App\Http\Middleware;

use App\Constants\ApiStatus;
use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class Jwt extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return response()->json(['message' => 'O token é inválido'], ApiStatus::unprocessableEntity);
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return response()->json(['message' => 'O token expirou'], ApiStatus::unprocessableEntity);
            }else{
                return response()->json(['message' => 'Token de autorização não encontrado'], ApiStatus::unprocessableEntity);
            }
        }
        return $next($request);
    }
}
