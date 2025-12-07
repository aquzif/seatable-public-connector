<div class="max-w-md mx-auto">
    <h2 class="text-xl font-semibold mb-4">Dostęp chroniony hasłem</h2>
    <form wire:submit.prevent="authenticate" class="space-y-4 bg-white p-4 rounded shadow">
        <div>
            <label class="block text-sm font-medium">Hasło</label>
            <input type="password" wire:model.defer="password" class="mt-1 w-full border rounded px-3 py-2" placeholder="Wprowadź hasło" />
            @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-semibold" wire:loading.attr="disabled">
            <span wire:loading.remove>Wejdź</span>
            <span wire:loading>Sprawdzanie...</span>
        </button>
    </form>
</div>
