<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'OCR App') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
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
