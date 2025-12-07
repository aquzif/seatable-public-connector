<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ChatGptClient
{
    public function analyzeReceipt(array $imagePaths, string $opis, string $kwotaBrutto): string
    {
        $apiKey = env('OPENAI_API_KEY');
        $model = env('OPENAI_MODEL', 'gpt-4.1-mini');

        if (!$apiKey) {
            return 'Brak skonfigurowanego klucza OPENAI_API_KEY.';
        }

        $files = collect($imagePaths)->map(function ($path) {
            return [
                'type' => 'input_image',
                'image_url' => Storage::disk('public')->url($path),
            ];
        })->values()->all();

        $prompt = [
            'type' => 'input_text',
            'text' => $this->buildPrompt($opis, $kwotaBrutto),
        ];

        $payload = [
            'model' => $model,
            'input' => array_merge([$prompt], $files),
        ];

        $response = Http::withToken($apiKey)
            ->timeout(30)
            ->post('https://api.openai.com/v1/responses', $payload);

        if (!$response->successful()) {
            return 'Błąd podczas wywołania OpenAI: ' . $response->body();
        }

        return $response->json('output_text') ?? json_encode($response->json());
    }

    protected function buildPrompt(string $opis, string $kwotaBrutto): string
    {
        return <<<'PROMPT'
Jesteś pomocnym asystentem OCR dla paragonów i faktur. Odczytaj wszystkie możliwe pola z przesłanych obrazów. Zwróć wynik w JSON o następującej strukturze:
{
  "typ_dokumentu": "paragon|faktura|inne",
  "data": "RRRR-MM-DD lub pusty string",
  "sprzedawca": "nazwa sprzedawcy",
  "pozycje": [
    {"nazwa": "", "ilosc": 0, "cena_netto": 0, "vat": "", "cena_brutto": 0}
  ],
  "kwota_brutto_z_dokumentu": 0,
  "waluta": "PLN",
  "numer_faktury_lub_paragonu": "" ,
  "uwagi": "odczytane uwagi lub puste"
}
Używaj przecinka jako separatora dziesiętnego. Jeśli pole jest nieznane ustaw pusty string lub 0. Nie dodawaj komentarzy poza JSON.
PROMPT
        . "\nDodatkowe informacje od użytkownika: opis={$opis}, kwota_brutto={$kwotaBrutto}.";
    }
}
