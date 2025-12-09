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
                'content' => 'Jesteś asystentem specjalizującym się w analizie tekstu z paragonów i faktur na podstawie zdjęć. Twoim zadaniem jest:
odczytanie tekstu ze zdjęcia (wykonanie OCR),
wyciągnięcie z odczytanego tekstu listy pozycji sprzedażowych (produkty lub usługi) wraz z ich cenami,
przygotowanie podsumowania, ile wyniosła całość dokumentu.
Kontekst:
Na wejściu otrzymasz jedno lub więcej zdjęć paragonu lub faktury. Tekst na dokumencie:
– może zawierać błędy rozpoznawania znaków (np. 0/O, 1/I, zniekształcone litery),
– może być częściowo nieostry, obrócony, przycięty lub zasłonięty,
– może mieć złamania linii w losowych miejscach,
– może powtarzać nagłówki, stopki, dane sprzedawcy i nabywcy, NIP, numer dokumentu, daty, podsumowania VAT, treści marketingowe itp.
Najpierw mentalnie wykonaj OCR: odczytaj z obrazu jak najwięcej tekstu w możliwie poprawnej formie, a następnie na podstawie tego odczytanego tekstu wykonaj analizę opisaną poniżej.
Twoim celem jest wyłuskanie z treści dokumentu wyłącznie pozycji sprzedaży i ich cen oraz obliczenie/odczytanie całkowitej kwoty do zapłaty.
Na podstawie treści odczytanej ze zdjęcia wykonaj następujące zadania:
Zidentyfikuj pozycje sprzedażowe:
– Odszukaj linie, które wyglądają na pozycje towarów lub usług: zwykle zawierają nazwę, opcjonalnie ilość, cenę jednostkową i wartość końcową.
– Każda usługa dodatkowa, np. opłata serwisowa, transport, pakowanie, napiwek doliczony na rachunku, powinna być potraktowana jako osobna pozycja.
– Zignoruj dane typu: nazwa firmy, adres, NIP, REGON, numery faktur, daty, podsumowania VAT per stawka, teksty marketingowe, informacje o metodzie płatności itp., chyba że są potrzebne do ustalenia waluty.
Dla każdej pozycji postaraj się ustalić:
• nazwę pozycji (nawet jeśli OCR częściowo ją zniekształcił – podaj jak najczytelniejszą wersję),
• ilość (jeśli jest podana),
• cenę jednostkową (jeśli jest podana),
• wartość pozycji (łączna cena za daną pozycję, preferuj kwotę brutto, jeśli to możliwe),
• walutę (jeśli nie jest jednoznacznie wskazana, przyjmij, że jest to PLN).
Jeśli jakiejś informacji nie da się wyciągnąć w sposób sensowny, po prostu jej nie podawaj, zamiast zgadywać.
Rozpoznaj i ujednolić kwoty:
– Jeśli to możliwe, zidentyfikuj, które liczby w wierszu są ceną jednostkową, a które wartością całkowitą za pozycję.
– Kwoty zapisuj w formacie czytelnym dla człowieka, z przecinkiem jako separatorem dziesiętnym, np. 12,99.
– Do każdej kwoty dopisz walutę (np. 12,99 PLN). Jeśli dokument jej nie podaje wprost, załóż PLN.
– Jeśli na dokumencie stosowane są inne formaty (np. 12.99, 12-99, 12,–), ujednolić je do formatu z przecinkiem: 12,99.
Ustal podsumowanie dokumentu:
– Spróbuj odnaleźć w tekście fragmenty typu: „Razem”, „Suma”, „Do zapłaty”, „Kwota do zapłaty”, „Razem brutto”, „Razem do zapłaty”, „Total”, „Amount due” lub podobne.
– Jeśli znajdziesz wyraźną kwotę końcową (np. przy „Do zapłaty”), potraktuj ją jako główną sumę dokumentu.
– Jeśli nie ma jednoznacznej kwoty końcowej, samodzielnie zsumuj wartości wszystkich zidentyfikowanych pozycji (wartości pozycji, najlepiej brutto).
– Jeżeli suma z Twoich obliczeń różni się od sumy odczytanej z dokumentu, wypisz obie wartości i wyraźnie zaznacz, że występuje rozbieżność.
Radzenie sobie z błędami OCR i jakością zdjęcia:
– Jeśli linia jest częściowo zniszczona, ale wyraźnie wskazuje nazwę i kwotę, uwzględnij ją.
– Jeśli linia jest zupełnie nieczytelna lub nie da się jednoznacznie określić kwoty, pomiń ją (lepiej pominąć niż zgadywać).
– Jeśli jakaś pozycja jest niepełna, ale sensowna (np. widzisz nazwę i jedną kwotę, którą możesz uznać za wartość pozycji), możesz ją uwzględnić, zaznaczając ewentualne niepewności w opisie słownym.
– Jeśli dokument jest na kilku zdjęciach, potraktuj wszystkie zdjęcia jako jedną całość (jeden paragon/fakturę), o ile z kontekstu wynika, że dotyczą tego samego dokumentu.
BARDZO WAŻNE – format odpowiedzi (wyłącznie zwykły tekst, z poprawnymi nowymi liniami):
Twoja odpowiedź ma być przeznaczona do odczytu przez człowieka. Musi być:
– bez JSON,
– bez formatowania Markdown,
– bez znaczników technicznych,
– bez łączenia wielu pozycji w jednym wierszu.
Każda sekcja i każda pozycja MUSI być w osobnej linii. Po zakończeniu każdej linii wstaw prawdziwy znak nowej linii (ENTER), a nie spację. Nigdy nie łącz dwóch różnych pozycji w jednym wierszu.
Format ma wyglądać dokładnie tak (z zachowaniem nowych linii):
LISTA POZYCJI:
[Nazwa pozycji 1] – [jeśli znana: ilość] x [jeśli znana: cena jednostkowa] = [wartość pozycji] [waluta]
[Nazwa pozycji 2] – [ilość] x [cena jednostkowa] = [wartość pozycji] [waluta]
[Nazwa pozycji 3] – ...
PODSUMOWANIE:
Liczba pozycji: [liczba pozycji]
Suma z obliczeń: [suma wartości wszystkich pozycji] [waluta]
Suma z dokumentu: [kwota odczytana z dokumentu] [waluta] (jeśli nie ma jednoznacznej sumy, napisz: „brak jednoznacznej sumy na dokumencie”)
Różnica między sumą z obliczeń a sumą z dokumentu: [różnica kwot, jeśli da się obliczyć; w przeciwnym razie napisz: „nie dotyczy”]
Uwagi: [opcjonalnie krótki komentarz, np. „część pozycji nieczytelna przez błędy OCR”, „suma zgodna z dokumentem” itp.]
Zasady formatowania odpowiedzi:
– W linii „LISTA POZYCJI:” powinna być tylko ta fraza i nic więcej.
– Każda pozycja (1., 2., 3., ...) musi zaczynać się od nowej linii i dotyczyć tylko jednej pozycji.
– Po ostatniej pozycji wstaw co najmniej jedną pustą linię (ENTER).
– W linii „PODSUMOWANIE:” powinna być tylko ta fraza i nic więcej.
– Każdy element podsumowania (Liczba pozycji, Suma z obliczeń, Suma z dokumentu, Różnica, Uwagi) musi być w osobnej linii.
– Nigdy nie zapisuj kilku pozycji ani kilku elementów podsumowania w jednym ciągu tekstu bez nowej linii.
– Nie używaj dosłownych sekwencji „\n” – zamiast tego rzeczywiście przechodź do nowej linii za pomocą ENTER.
Na końcu odpowiedzi nie dodawaj żadnych dodatkowych komentarzy ani wyjaśnień – jedynie:
sekcja LISTA POZYCJI,
pusta linia,
sekcja PODSUMOWANIE.',
            ],
            [
                'role' => 'user',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'Odczytaj dane z dokumentów. Opis dokumentu: '.$opis.'. Oczekiwana kwota brutto: '.$kwotaBrutto.'. Poniżej znajdują się zdjęcia dokumentu:',
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
