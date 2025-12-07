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

    public array $images = [];

    public string $statusMessage = '';

    public function submit(OcrService $ocrService): void
    {
        $validated = $this->validate([
            'opis' => 'required|string|min:3',
            'kwota_brutto' => 'required|numeric|min:0.01',
            'images' => 'required|array|max:5',
            'images.*' => 'file|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $storedImages = collect($this->images)->map(fn ($image) => $image->store('receipts', 'public'))->all();

        $ocrResult = $ocrService->analyze(
            $storedImages,
            $validated['opis'],
            $validated['kwota_brutto'],
        );

        RequestModel::create([
            'opis' => $validated['opis'],
            'kwota_brutto' => $validated['kwota_brutto'],
            'ocr_result' => $ocrResult,
            'images' => $storedImages,
        ]);

        $this->reset(['opis', 'kwota_brutto', 'images']);
        $this->statusMessage = 'Zapisano i przesłano do OCR.';
    }

    public function render()
    {
        return view('livewire.ocr-request-form')->layout('layouts.app');
    }
}
