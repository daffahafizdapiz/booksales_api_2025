<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\JsonResponse;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return new JsonResponse(['success' => false, 'message' => 'Token is invalid'], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return new JsonResponse(['success' => false, 'message' => 'Token has expired'], 401);
            } else {
                return new JsonResponse(['success' => false, 'message' => 'Authorization Token not found'], 401);
            }
        }

        return $next($request);
    }
}
