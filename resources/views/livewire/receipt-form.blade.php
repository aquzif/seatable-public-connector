<div class="space-y-4">
    <h2 class="text-xl font-semibold">Nowe zgłoszenie</h2>
    <form wire:submit.prevent="submit" class="bg-white p-4 rounded shadow space-y-4">
        <div>
            <label class="block text-sm font-medium">Opis</label>
            <textarea wire:model.defer="opis" rows="3" class="mt-1 w-full border rounded px-3 py-2" placeholder="Opis paragonu lub notatki" required></textarea>
            @error('opis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Kwota brutto (PLN)</label>
            <input type="number" step="0.01" min="0" wire:model.defer="kwota_brutto" class="mt-1 w-full border rounded px-3 py-2" placeholder="0.00" required />
            @error('kwota_brutto') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Zdjęcia (jpg, png, webp)</label>
            <input type="file" wire:model="images" multiple accept="image/png,image/jpg,image/jpeg,image/webp" class="mt-1 w-full" />
            <p class="text-xs text-gray-500 mt-1">Maksymalnie 10MB na plik. Możesz dodać wiele zdjęć.</p>
            @error('images.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold" wire:loading.attr="disabled">
            <span wire:loading.remove>Zapisz i uruchom OCR</span>
            <span wire:loading>Przetwarzanie...</span>
        </button>

        @if($feedback)
            <div class="p-3 rounded bg-green-50 text-green-800">{{ $feedback }}</div>
        @endif
    </form>
</div>
