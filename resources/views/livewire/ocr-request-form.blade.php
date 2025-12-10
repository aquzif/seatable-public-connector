<div class="space-y-8">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="space-y-1">
            <p class="text-xs font-semibold uppercase tracking-wide text-indigo-600 dark:text-indigo-300">Formularz</p>
            <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Nowe zgłoszenie</h2>
            <p class="text-sm text-slate-600 dark:text-slate-300">Dodaj opis, kwotę i zdjęcia paragonu lub faktury.</p>
        </div>
        <a href="{{ route('requests.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-indigo-700 shadow-sm transition hover:-translate-y-0.5 hover:border-indigo-200 hover:shadow-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 dark:border-slate-700 dark:bg-slate-800 dark:text-indigo-200 dark:hover:border-indigo-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="m15 10-3 3-3-3" />
                <path d="M4 19V5a2 2 0 0 1 2-2h8l4 4v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2Z" />
            </svg>
            <span>Zobacz zapisane</span>
        </a>
    </div>

    @if ($statusMessage)
        <div class="rounded-2xl border border-green-200 bg-green-50/90 px-4 py-3 text-sm font-semibold text-green-800 shadow-sm dark:border-green-900 dark:bg-green-900/60 dark:text-green-100">{{ $statusMessage }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-800 dark:text-slate-100" for="opis">Opis</label>
                <textarea wire:model.defer="opis" style="height: 113px" id="opis" rows="4" class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/50" placeholder="Krótki opis zgłoszenia"></textarea>
                @error('opis') <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-3">
                <label class="block text-sm font-semibold text-slate-800 dark:text-slate-100" for="kwota_brutto">Kwota brutto</label>
                <input wire:model.defer="kwota_brutto" id="kwota_brutto" type="number" step="0.01" min="0" inputmode="decimal" class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/50" placeholder="0.00">
                @error('kwota_brutto') <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p> @enderror
                <label class="block text-sm font-semibold text-slate-800 dark:text-slate-100" for="data">Data</label>
                <input wire:model.defer="data" id="data" type="date" class="w-full rounded-2xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100 dark:focus:border-indigo-400 dark:focus:ring-indigo-500/50">
                @error('data') <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-3">
            <label class="block text-sm font-semibold text-slate-800 dark:text-slate-100" for="images">Zdjęcia (jpg, png, webp, maks. 10MB każde)</label>
            <div class="flex flex-col gap-3 rounded-2xl border border-dashed border-slate-300 bg-slate-50/70 p-4 dark:border-slate-700 dark:bg-slate-800/50">
                <input wire:model="images" id="images" type="file" accept="image/jpeg,image/png,image/webp" multiple class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-600 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-500 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100 dark:file:bg-indigo-500 dark:hover:file:bg-indigo-400" />
                <p class="text-xs text-slate-500 dark:text-slate-400">Przeciągnij i upuść lub wybierz z dysku. Obsługujemy wiele plików naraz.</p>
                @error('images') <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p> @enderror
                @error('images.*') <p class="text-sm font-medium text-amber-600 dark:text-amber-300">{{ $message }}</p> @enderror
                <div wire:loading wire:target="images" class="inline-flex w-fit items-center gap-2 rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-200">
                    <span class="h-2 w-2 animate-pulse rounded-full bg-indigo-500"></span>
                    <span>Wczytywanie plików...</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col gap-3 rounded-2xl bg-gradient-to-r from-indigo-600 to-indigo-500 px-5 py-4 text-white shadow-lg shadow-indigo-500/30 dark:from-indigo-500 dark:to-indigo-400">
            <div class="flex items-center gap-2 text-sm font-semibold uppercase tracking-wide">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m9 11 3 3L22 4" />
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                </svg>
                <span>OCR w pakiecie</span>
            </div>
            <p class="text-sm text-indigo-100">Aplikacja zapisze zgłoszenie i automatycznie wykona OCR załączonych dokumentów.</p>
            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white px-4 py-3 text-sm font-semibold text-indigo-700 shadow-lg shadow-indigo-200 transition hover:-translate-y-0.5 hover:shadow-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white dark:bg-slate-900 dark:text-indigo-100" wire:loading.attr="disabled">
                <span wire:loading.remove>Wyślij i wykonaj OCR</span>
                <span wire:loading>Przetwarzanie...</span>
            </button>
        </div>
    </form>
</div>
