<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <div class="relative flex min-h-screen items-center justify-center px-4 py-10">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-100 via-white to-indigo-100 dark:from-slate-950 dark:via-slate-900 dark:to-indigo-950/30"></div>
        <div class="relative w-full max-w-md overflow-hidden rounded-3xl border border-slate-200/80 bg-white/80 p-8 shadow-2xl shadow-indigo-200/50 backdrop-blur dark:border-slate-800 dark:bg-slate-900/80 dark:shadow-black/20">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-950/60 dark:text-indigo-200 dark:ring-indigo-900/60">
                        <span class="h-2 w-2 rounded-full bg-green-500 shadow-[0_0_0_3px_rgba(34,197,94,0.25)]"></span>
                        <span>SP Connector</span>
                    </div>
                    <h1 class="text-xl font-semibold tracking-tight">Dostęp zabezpieczony hasłem</h1>
                </div>
                <button
                    id="theme-toggle"
                    type="button"
                    class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100"
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
            </div>

            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-200 bg-green-50/90 px-4 py-3 text-sm font-semibold text-green-800 dark:border-green-900 dark:bg-green-900/60 dark:text-green-100">{{ session('status') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 rounded-lg border border-amber-200 bg-amber-50/90 px-4 py-3 text-sm font-semibold text-amber-800 dark:border-amber-900 dark:bg-amber-900/60 dark:text-amber-100">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('authenticate') }}" class="space-y-4">
                @csrf
                <div class="space-y-3">
                    <label for="password1" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Login</label>
                    <input id="password1" name="password1" type="text" required autofocus class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/50" />
                    <label for="password2" class="block text-sm font-medium text-slate-700 dark:text-slate-200">Hasło</label>
                    <input id="password2" name="password2" type="password" required class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/50" />

                    @error('password')
                        <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p>
                    @enderror
                </div>
                <button type="submit" class="w-full rounded-2xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/30 transition hover:-translate-y-0.5 hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:bg-indigo-500 dark:hover:bg-indigo-400">Zaloguj</button>
            </form>
        </div>
    </div>
</body>
</html>
