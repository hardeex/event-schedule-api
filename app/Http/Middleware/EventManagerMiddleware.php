<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class EventManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user || $user->role !== 'manager') {
                return response()->json(['error' => 'Unauthorized: Event manager access level required'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized (Event Manager Role is required) - You do not have the access to perform this action'], 401);
        }

        return $next($request);
    }
}
