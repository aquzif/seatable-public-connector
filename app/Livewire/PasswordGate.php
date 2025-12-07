<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class PasswordGate extends Component
{
    public string $password = '';

    public function authenticate()
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        request()->setMethod('post');
        request()->merge(['password' => $this->password]);

        return app(\App\Http\Middleware\PagePasswordMiddleware::class)
            ->handle(request(), fn () => redirect()->intended('/'));
    }

    public function render()
    {
        return view('livewire.password-gate');
    }
}
