<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnCors
{
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'http://localhost:5173',
            'https://dealerbot.stemdev.uz'
        ];

        $origin = $request->headers->get('Origin');

        if (!in_array($origin, $allowedOrigins)) {
            $origin = 'https://dealerbot.stemdev.uz'; // Default fallback
        }

        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE, PATCH',
            'Access-Control-Allow-Headers' => 'X-Requested-With, Content-Type, X-Token-Auth, Authorization',
            'Access-Control-Allow-Credentials' => 'true',
            'Accept' => 'application/json'
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json([], Response::HTTP_OK)->withHeaders($headers);
        }

        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
