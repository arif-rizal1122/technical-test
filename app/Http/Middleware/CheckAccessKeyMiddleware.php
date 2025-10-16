<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $secretKey = env('API_ACCESS_KEY');

        $requestKey = $request->header('X-Access-Key');

        if (empty($secretKey)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Server configuration error: API Access Key is missing in environment file.'
            ], 500); 
        }

        if (empty($requestKey) || $requestKey !== $secretKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Missing or invalid X-Access-Key header.'
            ], 401);
        }

        return $next($request);
    }
}