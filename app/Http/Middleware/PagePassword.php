<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PagePassword
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.page_password') === null) {
            return $next($request);
        }

        if ($request->session()->get('page_authenticated',false)) {
            return $next($request);
        }

        return redirect()->route('login')->with('error', 'Wymagane jest podanie hasła dostępowego.');
    }
}
