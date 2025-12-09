@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<div class="space-y-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-300">Lista</p>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Zapisane zgłoszenia</h2>
            <p class="text-sm text-slate-600 dark:text-slate-300">Podgląd ostatnich przesłań.</p>
        </div>
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-indigo-200 dark:hover:border-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m9 6-6 6 6 6" />
                <path d="M20 12H3" />
            </svg>
            <span>Wróć do formularza</span>
        </a>
    </div>

    <div class="grid gap-4">
        @foreach($requests as $request)
            <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-white/70 p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-0.5 hover:ring-indigo-200 dark:border-slate-800 dark:bg-slate-800/80 dark:hover:ring-indigo-500/30">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div class="space-y-2">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500 dark:text-slate-400">ID {{ $request->id }}</p>
                        <p class="text-lg font-semibold text-slate-900 dark:text-white">{{ $request->opis }}</p>
                        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600 dark:text-slate-300">
                            <span class="inline-flex items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-100 dark:bg-indigo-950/50 dark:text-indigo-200 dark:ring-indigo-900/60">Kwota brutto: <span class="font-bold">{{ $request->kwota_brutto }}</span></span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700 ring-1 ring-slate-200 dark:bg-slate-700/80 dark:text-slate-100 dark:ring-slate-600">Dodano {{ $request->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div class="rounded-xl bg-slate-100/70 px-3 py-2 text-xs text-slate-600 ring-1 ring-slate-200 dark:bg-slate-900/60 dark:text-slate-200 dark:ring-slate-700">
                            <span class="font-semibold text-slate-800 dark:text-white">OCR:</span>
                            <span class="font-mono">{{ Str::limit($request->ocr_result, 140) }}</span>
                        </div>
                    </div>
                    @if($request->images)
                        <div class="flex flex-wrap gap-2">
                            @foreach($request->images as $image)
                                <a href="{{ Storage::disk('public')->url($image) }}" target="_blank" rel="noopener noreferrer" class="group relative block h-20 w-20 overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                                    <img src="{{ Storage::disk('public')->url($image) }}" alt="Podgląd" class="h-full w-full object-cover transition duration-200 group-hover:scale-105">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="pt-2">
        {{ $requests->links() }}
    </div>
</div>
