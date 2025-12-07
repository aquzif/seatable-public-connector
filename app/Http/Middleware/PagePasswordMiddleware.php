<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PagePasswordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $storedPassword = env('APP_PAGE_PASSWORD');
        $sessionKey = 'page_authenticated';

        if (!$storedPassword) {
            abort(503, 'APP_PAGE_PASSWORD is not configured.');
        }

        if ($request->session()->get($sessionKey)) {
            return $next($request);
        }

        if ($request->isMethod('post') && $request->path() === 'login') {
            $request->validate([
                'password' => ['required', 'string'],
            ]);

            if (hash_equals($storedPassword, $request->input('password'))) {
                $request->session()->put($sessionKey, true);
                return redirect()->intended('/');
            }

            return redirect()->route('login')->withErrors(['password' => 'Nieprawidłowe hasło.']);
        }

        return redirect()->route('login');
    }
}
