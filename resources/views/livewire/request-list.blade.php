@php
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
@endphp
<div class="space-y-4">
    <h2 class="text-xl font-semibold">Zapisane zgłoszenia</h2>
    <div class="bg-white shadow rounded divide-y">
        @forelse($requests as $request)
            <div class="p-4 space-y-2">
                <div class="flex justify-between text-sm text-gray-500">
                    <span>#{{ $request->id }}</span>
                    <span>{{ $request->created_at }}</span>
                </div>
                <div class="text-sm"><span class="font-semibold">Opis:</span> {{ $request->opis }}</div>
                <div class="text-sm"><span class="font-semibold">Kwota:</span> {{ $request->kwota_brutto }} PLN</div>
                <div class="text-sm"><span class="font-semibold">OCR:</span> {{ Str::limit($request->ocr_result, 120) }}</div>
                <div class="flex space-x-2 overflow-x-auto">
                    @foreach($request->images as $path)
                        <a href="{{ Storage::disk('public')->url($path) }}" class="block" target="_blank">
                            <img src="{{ Storage::disk('public')->url($path) }}" class="h-16 w-16 object-cover rounded" />
                        </a>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="p-4 text-sm text-gray-500">Brak zgłoszeń.</p>
        @endforelse
    </div>
    <div>
        {{ $requests->links() }}
    </div>
</div>
