<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthJwt extends BaseMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try
        {
            JWTAuth::parseToken()->authenticate();
        }
        catch (TokenInvalidException $e)
        {
            return response()->json([
                'message' => 'Invalid token!'
            ],400);

        }catch (JWTException $e)
        {
            return response()->json([
                'message' => 'Empty token!'
            ], 400);
        }

        return $next($request);
    }
}
