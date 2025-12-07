# TALL Receipt OCR (Laravel 12 demo)

Minimalny przykład aplikacji Laravel 12 w stosie TALL, która chroni dostęp hasłem z `.env`, przyjmuje formularz z opisem, kwotą brutto oraz zdjęciami paragonu/faktury, a następnie wysyła dane do API ChatGPT w celu wykonania OCR i zapisuje wynik w bazie SQLite.

## Szybki start
1. Skopiuj `.env.example` do `.env` i ustaw `APP_PAGE_PASSWORD`, `OPENAI_API_KEY`, `OPENAI_MODEL`.
2. Utwórz plik bazy: `mkdir -p storage/database && touch storage/database/database.sqlite`.
3. Uruchom migracje: `php artisan migrate`.
4. Wystartuj serwer: `php artisan serve` i przejdź na `/login`.

## Kluczowe elementy
- Livewire komponenty: ekran logowania, formularz zgłoszenia, lista zapisanych rekordów.
- Middleware `page.password` chroni całą aplikację hasłem.
- Serwis `ChatGptClient` wysyła obrazy i prompt do endpointu OpenAI `responses`.
- Tabela `requests` zapisuje opis, kwotę brutto, wyniki OCR oraz ścieżki do plików.
