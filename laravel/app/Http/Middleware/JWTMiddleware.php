<?php

namespace App\Http\Middleware;

use App\Enums\ResponseEnum;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;


class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], ResponseEnum::UNAUTHORIZED);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired'], ResponseEnum::UNAUTHORIZED);
            } else {
                return response()->json(['status' => 'Authorization Token not found'], ResponseEnum::UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
