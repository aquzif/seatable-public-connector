<?php

namespace App\Http\Middleware;

class Authenticate
{


    public function handle($request, \Closure $next)
    {
        $token = $request->bearerToken() ?? $request->query('token');

        if ($token !== env('APP_PAGE_PASSWORD1').env('APP_PAGE_PASSWORD2')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }

}
