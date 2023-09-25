<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\JsonResponse
     */
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        // Kiểm tra token
        if (!$this->isValidToken($token)) {
            return response()->json(['error' => 'Token wrong'], 401);
        }

        return $next($request);
    }

    private function isValidToken($token)
    {
        $hashedReceivedToken  = hash('sha256', $token);
        $customer = \App\Models\Customer::where('api_token', $hashedReceivedToken)->first();

        return $customer !== null;
    }
}
