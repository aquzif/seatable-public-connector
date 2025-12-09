<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#f97316">
        <meta name="application-name" content="Seatable Public Connector">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="SP Connector">
        <title>{{ config('app.name', 'OCR App') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="manifest" href="/manifest.webmanifest">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <div
            id="offline-banner"
            class="hidden fixed inset-x-0 top-0 z-50 bg-amber-50 text-amber-900 shadow-[0_6px_18px_rgba(0,0,0,0.15)]"
            role="status"
            aria-live="polite"
            aria-hidden="true"
        >
            <p class="mx-auto max-w-3xl px-4 py-3 text-center text-sm font-medium">Jesteś offline</p>
        </div>
        <div class="max-w-3xl mx-auto px-4 py-8 space-y-6">
            <header class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold">OCR w TALL</h1>
                    <p class="text-sm text-slate-600">Mobilny formularz z OCR paragonów i faktur.</p>
                </div>
                @if(session()->has('page_authenticated'))
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm text-slate-600 underline">Wyloguj</button>
                    </form>
                @endif
            </header>

            <main class="bg-white shadow-sm rounded-xl p-4 md:p-6 border border-slate-100">
                {{ $slot }}
            </main>
        </div>

        @livewireScripts
    </body>
</html>
