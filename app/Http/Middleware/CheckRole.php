<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user || !in_array($user->role, $roles)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized - Admin only'
                ], 403);
            }

            return $next($request);

        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalid or expired'
            ], 403);
        }
    }
}
