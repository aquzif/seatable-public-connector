<?php

namespace App\Livewire;

use App\Models\Request;
use App\Services\ChatGptClient;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class ReceiptForm extends Component
{
    use WithFileUploads;

    public string $opis = '';
    public $images = [];
    public string $kwota_brutto = '';
    public ?string $feedback = null;

    protected function rules()
    {
        return [
            'opis' => ['required', 'string', 'max:1000'],
            'kwota_brutto' => ['required', 'numeric', 'gt:0'],
            'images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
    }

    public function submit(ChatGptClient $client)
    {
        $validated = $this->validate();

        $paths = collect($this->images)->map(function ($image) {
            return $image->store('receipts', 'public');
        })->toArray();

        $ocrResult = $client->analyzeReceipt($paths, $validated['opis'], $validated['kwota_brutto']);

        $request = Request::create([
            'opis' => $validated['opis'],
            'kwota_brutto' => $validated['kwota_brutto'],
            'ocr_result' => $ocrResult,
            'images' => $paths,
        ]);

        $this->reset(['opis', 'images', 'kwota_brutto']);
        $this->feedback = "Zapisano zgłoszenie #{$request->id}.";
    }

    public function render()
    {
        return view('livewire.receipt-form');
    }
}
