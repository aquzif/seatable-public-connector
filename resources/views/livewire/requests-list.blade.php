@php
    use Illuminate\Support\Facades\Storage;
    use Illuminate\Support\Str;
@endphp

<div class="space-y-6">
    <div class="flex items-center justify-between gap-2">
        <div>
            <h2 class="text-lg font-semibold">Zapisane zgłoszenia</h2>
            <p class="text-sm text-slate-600">Podgląd ostatnich przesłań.</p>
        </div>
        <a href="{{ route('home') }}" class="text-sm text-indigo-600 hover:underline">Wróć do formularza</a>
    </div>

    <div class="grid gap-4">
        @foreach($requests as $request)
            <div class="border border-slate-100 rounded-lg p-4 shadow-sm bg-slate-50/60">
                <div class="flex justify-between items-start gap-3">
                    <div class="space-y-1">
                        <p class="text-xs uppercase tracking-wide text-slate-500">ID {{ $request->id }}</p>
                        <p class="font-semibold text-slate-800">{{ $request->opis }}</p>
                        <p class="text-sm text-slate-600">Kwota brutto: <span class="font-semibold">{{ $request->kwota_brutto }}</span></p>
                        <p class="text-sm text-slate-600">OCR: <span class="font-mono text-xs">{{ Str::limit($request->ocr_result, 120) }}</span></p>
                        <p class="text-xs text-slate-500">Dodano {{ $request->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    @if($request->images)
                        <div class="flex -space-x-2">
                            @foreach($request->images as $image)
                                <a href="{{ Storage::disk('public')->url($image) }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ Storage::disk('public')->url($image) }}" alt="Podgląd" class="h-16 w-16 object-cover rounded-lg border border-white shadow">
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div>
        {{ $requests->links() }}
    </div>
</div>
