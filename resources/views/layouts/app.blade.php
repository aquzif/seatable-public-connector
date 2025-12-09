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
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased dark:bg-slate-950 dark:text-slate-100">
        <div
            id="offline-banner"
            class="hidden fixed inset-x-0 top-0 z-50 bg-amber-50/90 text-amber-900 shadow-[0_12px_30px_rgba(0,0,0,0.25)] backdrop-blur dark:bg-amber-900/80 dark:text-amber-50"
            role="status"
            aria-live="polite"
            aria-hidden="true"
        >
            <p class="mx-auto max-w-4xl px-4 py-3 text-center text-sm font-semibold">Jesteś offline</p>
        </div>

        <div class="relative min-h-screen">
            <div class="absolute inset-0 bg-gradient-to-br from-slate-100 via-white to-indigo-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950/30"></div>
            <div class="relative mx-auto max-w-5xl px-4 py-10 sm:py-12 lg:py-14 space-y-8">
                <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="space-y-2">
                        <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-950/60 dark:text-indigo-200 dark:ring-indigo-900/60">
                            <span class="h-2 w-2 rounded-full bg-green-500 shadow-[0_0_0_3px_rgba(34,197,94,0.25)]"></span>
                            <span>Seatable Public Connector</span>
                        </div>
                        <div class="space-y-1">
                            <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">OCR w TALL</h1>
                            <p class="text-sm text-slate-600 dark:text-slate-300">Mobilny formularz z OCR paragonów i faktur.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 self-start">
                        <button
                            id="theme-toggle"
                            type="button"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:hover:border-indigo-700"
                            aria-pressed="false"
                        >
                            <svg data-theme-icon="sun" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="4" />
                                <path d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364 6.364-1.414-1.414M6.05 6.05 4.636 4.636m12.728 0-1.414 1.414M6.05 17.95l-1.414 1.414" />
                            </svg>
                            <svg data-theme-icon="moon" xmlns="http://www.w3.org/2000/svg" class="hidden h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79Z" />
                            </svg>
                            <span class="sr-only">Przełącz motyw</span>
                        </button>
                        @if(session()->has('page_authenticated'))
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">
                                    Wyloguj
                                </button>
                            </form>
                        @endif
                    </div>
                </header>

                <main class="overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 p-6 shadow-xl shadow-indigo-100/50 backdrop-blur dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-black/20 sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>

        @livewireScripts
    </body>
</html>
