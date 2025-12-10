<?php

namespace App\Livewire;

use App\Models\Request as RequestModel;
use App\Services\OcrService;
use Livewire\Component;
use Livewire\WithFileUploads;

class OcrRequestForm extends Component
{
    use WithFileUploads;

    public string $opis = '';

    public string $kwota_brutto = '';

    public string $data = '';

    public array $images = [];

    public string $statusMessage = '';

    public function mount(): void
    {
        $this->data = now()->toDateString();
    }

    public function submit(OcrService $ocrService): void
    {
        $validated = $this->validate([
            'opis' => 'required|string|min:3',
            'kwota_brutto' => 'required|numeric|min:0.01',
            'data' => 'required|date',
            'images' => 'array|max:5',
            'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $storedImages = collect($this->images)->map(fn ($image) => $image->store('receipts', 'public'))->all();

        RequestModel::create([
            'opis' => $validated['opis'],
            'kwota_brutto' => $validated['kwota_brutto'],
            'data' => $validated['data'] ?? now()->toDateString(),
            'ocr_result' => '',
            'images' => $storedImages,
            'status' => empty($storedImages) ? 'ready' : 'pending',
        ]);

        $this->reset(['opis', 'kwota_brutto', 'images', 'data']);
        $this->data = now()->toDateString();
        $this->statusMessage = 'Zapisano i przesłano do importu.';
    }

    public function render()
    {
        return view('livewire.ocr-request-form')->layout('layouts.app');
    }
}
