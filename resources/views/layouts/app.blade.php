<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TALL Receipt OCR') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white shadow-sm">
            <div class="max-w-3xl mx-auto px-4 py-3 flex justify-between items-center">
                <h1 class="text-lg font-semibold">{{ config('app.name', 'TALL Receipt OCR') }}</h1>
                <nav class="text-sm space-x-4">
                    <a href="{{ route('home') }}" class="text-blue-600">Formularz</a>
                    <a href="{{ route('requests.index') }}" class="text-blue-600">Zgłoszenia</a>
                </nav>
            </div>
        </header>

        <main class="flex-1 max-w-3xl w-full mx-auto px-4 py-6">
            {{ $slot }}
        </main>

        <footer class="text-center text-xs text-gray-500 py-4">Aplikacja demonstracyjna TALL</footer>
    </div>

    @livewireScripts
</body>
</html>
