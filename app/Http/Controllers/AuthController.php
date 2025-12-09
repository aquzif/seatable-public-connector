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
            'password1' => ['required', 'string'],
            'password2' => ['required', 'string'],
        ]);

        $expectedPassword1 = config('app.page_password1');
        $expectedPassword2 = config('app.page_password2');

        if ($expectedPassword1 && !hash_equals($expectedPassword1, $credentials['password1'])) {
            return back()->withErrors(['password' => 'Nieprawidłowe hasło dostępu.'])->withInput();
        }
        if ($expectedPassword2 && !hash_equals($expectedPassword2, $credentials['password2'])) {
            return back()->withErrors(['password' => 'Nieprawidłowe hasło dostępu.'])->withInput();
        }

        $request->session()->put('page_authenticated', true);

        return redirect()->intended(route('home'));


    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('page_authenticated');

        return redirect()->route('login')->with('status', 'Zostałeś wylogowany.');
    }
}
