<div class="space-y-6">
    <div class="flex items-center justify-between gap-2">
        <div>
            <h2 class="text-lg font-semibold">Nowe zgłoszenie</h2>
            <p class="text-sm text-slate-600">Dodaj opis, kwotę i zdjęcia paragonu lub faktury.</p>
        </div>
        <a href="{{ route('requests.index') }}" class="text-sm text-indigo-600 hover:underline">Zobacz zapisane</a>
    </div>

    @if ($statusMessage)
        <div class="rounded-lg border border-green-200 bg-green-50 text-green-700 p-3">{{ $statusMessage }}</div>
    @endif

    <form wire:submit.prevent="submit" class="space-y-4" enctype="multipart/form-data">
        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700" for="opis">Opis</label>
            <textarea wire:model.defer="opis" id="opis" rows="3" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Krótki opis zgłoszenia"></textarea>
            @error('opis') <p class="text-sm text-amber-600">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700" for="kwota_brutto">Kwota brutto</label>
            <input wire:model.defer="kwota_brutto" id="kwota_brutto" type="number" step="0.01" min="0" inputmode="decimal" class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500" placeholder="0.00">
            @error('kwota_brutto') <p class="text-sm text-amber-600">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-slate-700" for="images">Zdjęcia (jpg, png, webp, maks. 10MB każde)</label>
            <input wire:model="images" id="images" type="file" accept="image/jpeg,image/png,image/webp" multiple class="w-full rounded-lg border-slate-200 focus:border-indigo-500 focus:ring-indigo-500">
            @error('images') <p class="text-sm text-amber-600">{{ $message }}</p> @enderror
            @error('images.*') <p class="text-sm text-amber-600">{{ $message }}</p> @enderror
            <div wire:loading wire:target="images" class="text-xs text-slate-500">Wczytywanie plików...</div>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full bg-indigo-600 text-white rounded-lg py-3 font-semibold hover:bg-indigo-500 focus:ring-2 focus:ring-indigo-400" wire:loading.attr="disabled">
                <span wire:loading.remove>Wyślij i wykonaj OCR</span>
                <span wire:loading>Przetwarzanie...</span>
            </button>
        </div>
    </form>
</div>
