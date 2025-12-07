<?php

use Illuminate\Foundation\Application;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->web(\App\Http\Kernel::class);
    })
    ->withExceptions(function ($exceptions) {
        // default handler
    })
    ->create();
