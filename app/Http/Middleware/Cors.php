<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $headers = [
            'Access-Control-Allow-Origin' => env('CLIENT_URL'),
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Authorization'
        ];

        // Handle preflight OPTIONS request
        if ($request->getMethod() == 'OPTIONS') {
            return response(null, 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $header) {
            $response->header($key, $header);
        }

        return $response;
    }
}
