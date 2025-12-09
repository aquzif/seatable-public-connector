<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-50 px-4">
    <div class="w-full max-w-md bg-white p-6 rounded-xl shadow-sm border border-slate-100">
        <h1 class="text-xl font-semibold mb-4 text-center">Dostęp zabezpieczony hasłem</h1>
        @if (session('status'))
            <div class="mb-3 text-green-700 bg-green-50 border border-green-200 rounded-lg p-3">{{ session('status') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-3 text-amber-700 bg-amber-50 border border-amber-200 rounded-lg p-3">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('authenticate') }}" class="space-y-4">
            @csrf
            <div class="space-y-2">
                <label for="password1" class="block text-sm font-medium text-slate-700">Login</label>
                <input id="password1" name="password1" type="text" required autofocus class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" />
                <label for="password2" class="block text-sm font-medium text-slate-700">Hasło</label>
                <input id="password2" name="password2" type="password" required autofocus class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" />

                @error('password')
                    <p class="text-sm text-amber-600">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white rounded-lg py-2 font-semibold hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-400">Zaloguj</button>
        </form>
    </div>
</body>
</html>
