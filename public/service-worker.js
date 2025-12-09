const OFFLINE_HTML = `<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Seatable Public Connector</title>
        <style>
            body { font-family: "Instrument Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; margin: 0; background: #0f172a; color: #f8fafc; display: grid; place-items: center; min-height: 100vh; padding: 1.5rem; }
            .card { background: linear-gradient(135deg, #f97316, #ea580c); padding: 1.5rem 1.75rem; border-radius: 1rem; box-shadow: 0 10px 35px rgba(0,0,0,0.2); text-align: center; }
            h1 { font-size: 1.25rem; margin: 0 0 .5rem; }
            p { margin: 0; font-size: 1rem; }
        </style>
    </head>
    <body>
        <div class="card">
            <h1>Jesteś offline</h1>
            <p>Połącz się z internetem, aby korzystać z aplikacji.</p>
        </div>
    </body>
</html>`;

self.addEventListener('install', (event) => {
    event.waitUntil(self.skipWaiting());
});

self.addEventListener('activate', (event) => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') {
        return;
    }

    event.respondWith(
        fetch(event.request).catch(() => {
            if (event.request.mode === 'navigate') {
                return new Response(OFFLINE_HTML, {
                    headers: { 'Content-Type': 'text/html; charset=utf-8' },
                });
            }

            return new Response('', { status: 503, statusText: 'Offline' });
        }),
    );
});
