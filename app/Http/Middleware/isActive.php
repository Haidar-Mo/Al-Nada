<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && !Auth::user()->isActive()) {
            return response()->json([
                'message' => 'your account is not active, please call the support team',
            ], 403);
        }
        if (Auth::check() && Auth::user()->email_verified_at == null) {
            return response()->json([
                'message' => 'please verify your Email first',
            ], 403);
        }
        return $next($request);
    }
}
