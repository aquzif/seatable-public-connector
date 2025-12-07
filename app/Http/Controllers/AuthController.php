<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'password' => ['required', 'string'],
        ]);

        $expectedPassword = config('app.page_password');

        if ($expectedPassword && hash_equals($expectedPassword, $credentials['password'])) {
            $request->session()->put('page_authenticated', true);

            return redirect()->intended(route('home'));
        }

        return back()->withErrors(['password' => 'Nieprawidłowe hasło dostępu.'])->withInput();
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('page_authenticated');

        return redirect()->route('login')->with('status', 'Zostałeś wylogowany.');
    }
}
