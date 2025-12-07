<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class OcrService
{
    public function analyze(array $imagePaths, string $opis, string $kwotaBrutto): string
    {
        $apiKey = config('services.openai.key');
        $model = config('services.openai.model');

        if (! $apiKey || ! $model) {
            return 'Brak konfiguracji OpenAI w pliku .env';
        }

        $messages = [
            [
                'role' => 'system',
                'content' => 'Jesteś asystentem finansowym. Wykonaj OCR przesłanych zdjęć paragonu/faktury. Zwróć zwięzły JSON z polami: typ_dokumentu, numer_dokumentu, data, sprzedawca, nabywca (jeśli jest), pozycje (tablica pozycji zawierająca nazwa, ilosc, cena_jednostkowa, kwota_laczna), kwota_brutto, waluta, uwagi. Pomiń zbędne komentarze. Jeśli czegoś nie widać, ustaw wartość null.',
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Odczytaj dane z dokumentów. Pole kwota_brutto zadane przez użytkownika: '.$kwotaBrutto.'. Opis kontekstu: '.$opis.'. Zwróć JSON opisany wcześniej.',
                    ],
                    ...collect($imagePaths)->map(function (string $path) {
                        $fileContent = Storage::disk('public')->get($path);
                        $mimeType = mime_content_type(Storage::disk('public')->path($path));

                        return [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'data:'.$mimeType.';base64,'.base64_encode($fileContent),
                            ],
                        ];
                    })->all(),
                ],
            ],
        ];

        $response = Http::withToken($apiKey)
            ->post('https://api.openai.com/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'max_tokens' => 800,
                'temperature' => 0.2,
            ]);

        if (! $response->successful()) {
            return 'Błąd API: '.$response->body();
        }

        return (string) data_get($response->json(), 'choices.0.message.content');
    }
}
