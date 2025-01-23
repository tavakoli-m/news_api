<?php

namespace App\Http\Middleware;

use App\Services\ApiResponse\Facades\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if((int)Auth::guard('sanctum')->user()->is_admin === 0){
            return ApiResponse::withStatus(403)->withMessage('You Dont Have Access To This End Point')->send();
        }
        return $next($request);
    }
}
