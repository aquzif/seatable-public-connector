<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#0ea5e9">
        <meta name="application-name" content="Seatable Public Connector">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="apple-mobile-web-app-title" content="SP Connector">

        <title>Seatable Public Connector</title>

        <link rel="icon" href="/favicon.png" sizes="any">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        <link rel="manifest" href="/manifest.webmanifest">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
                :root {
                    font-family: 'Instrument Sans', ui-sans-serif, system-ui, -apple-system, sans-serif;
                    color: #0f172a;
                    background: #f8fafc;
                }
                .dark {
                    color: #e5e7eb;
                    background: #0b1224;
                }
            </style>
        @endif
    </head>
    <body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-50 min-h-full" x-data>
        <div
            id="offline-banner"
            class="hidden fixed inset-x-0 top-0 z-50 bg-amber-100 text-amber-900 dark:bg-amber-950/70 dark:text-amber-200 shadow-lg"
            role="status"
            aria-live="polite"
            aria-hidden="true"
        >
            <p class="mx-auto max-w-6xl px-4 py-3 text-center text-sm font-medium">You are offline. We'll keep trying to reconnect.</p>
        </div>

        <div class="relative isolate overflow-hidden min-h-screen">
            <div class="pointer-events-none absolute inset-0">
                <div class="absolute -left-24 top-20 h-64 w-64 rounded-full bg-cyan-300/30 blur-3xl"></div>
                <div class="absolute right-[-8rem] top-10 h-64 w-64 rounded-full bg-indigo-400/20 blur-3xl"></div>
                <div class="absolute bottom-[-6rem] left-12 h-72 w-72 rounded-full bg-emerald-300/20 blur-3xl"></div>
            </div>

            <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-6 pb-14 pt-10 lg:pt-14">
                <header class="flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex items-center gap-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-cyan-500 text-slate-950 shadow-lg shadow-cyan-500/20">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-6 w-6">
                                <path d="M5.5 4.75A2.75 2.75 0 0 1 8.25 2h7.5A2.75 2.75 0 0 1 18.5 4.75v14.5A2.75 2.75 0 0 1 15.75 22h-7.5A2.75 2.75 0 0 1 5.5 19.25V4.75Z" opacity="0.35" />
                                <path d="M8 7.25A.75.75 0 0 1 8.75 6.5h6.5a.75.75 0 0 1 0 1.5h-6.5A.75.75 0 0 1 8 7.25Zm0 3A.75.75 0 0 1 8.75 9.5h6.5a.75.75 0 0 1 0 1.5h-6.5A.75.75 0 0 1 8 10.25Zm0 3a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 0 1.5h-3A.75.75 0 0 1 8 13.25Z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Seatable</p>
                            <h1 class="text-xl font-semibold">Public Connector</h1>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="rounded-full bg-white/80 px-3 py-1 text-xs font-medium text-slate-600 shadow-sm ring-1 ring-slate-200 backdrop-blur dark:bg-slate-900/60 dark:text-slate-100 dark:ring-white/10">
                            Build automations in minutes
                        </div>
                        <button
                            id="theme-toggle"
                            type="button"
                            class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg hover:border-cyan-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-500 dark:border-white/10 dark:bg-slate-900 dark:text-slate-100"
                            aria-pressed="false"
                            aria-label="Toggle theme"
                        >
                            <svg data-theme-icon="sun" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4 text-amber-400">
                                <path d="M12 6.75a5.25 5.25 0 1 0 0 10.5a5.25 5.25 0 0 0 0-10.5Z" />
                                <path d="M12 2.25a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V3a.75.75 0 0 1 .75-.75Zm0 15a.75.75 0 0 1 .75.75v1.5a.75.75 0 0 1-1.5 0V18a.75.75 0 0 1 .75-.75ZM4.5 11.25a.75.75 0 0 1 .75.75a.75.75 0 0 1-.75.75H3a.75.75 0 0 1 0-1.5h1.5Zm17 0a.75.75 0 0 1 .75.75a.75.75 0 0 1-.75.75H20a.75.75 0 0 1 0-1.5h1.5ZM6.53 5.47a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L6.53 6.53a.75.75 0 0 1 0-1.06Zm10.82 10.82a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 0 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06Zm1.06-9.76a.75.75 0 0 0-1.06-1.06l-1.06 1.06a.75.75 0 1 0 1.06 1.06l1.06-1.06ZM8.65 15.35a.75.75 0 0 0-1.06-1.06l-1.06 1.06a.75.75 0 0 0 1.06 1.06l1.06-1.06Z" />
                            </svg>
                            <svg data-theme-icon="moon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="hidden h-4 w-4 text-blue-200">
                                <path d="M21.75 14.25a.75.75 0 0 0-.937-.73a7.5 7.5 0 0 1-9.333-9.333a.75.75 0 0 0-.73-.937A9 9 0 1 0 21.75 14.25Z" />
                            </svg>
                            <span class="hidden text-xs font-medium text-cyan-600 dark:inline">Dark</span>
                            <span class="inline text-xs font-medium text-slate-600 dark:hidden">Light</span>
                        </button>
                    </div>
                </header>

                <main class="grid gap-10 lg:grid-cols-[1.05fr,0.95fr] lg:items-center">
                    <section class="flex flex-col gap-8">
                        <div class="inline-flex items-center gap-2 rounded-full bg-white/80 px-3 py-1 text-sm font-semibold text-cyan-700 shadow-sm ring-1 ring-cyan-100 backdrop-blur dark:bg-slate-900/60 dark:text-cyan-200 dark:ring-white/10">
                            <span class="h-2 w-2 rounded-full bg-emerald-400 shadow shadow-emerald-300"></span>
                            Live connections stay in sync
                        </div>
                        <div class="space-y-4">
                            <h2 class="text-3xl font-semibold leading-tight sm:text-4xl">Redesigned experience for your next public connector</h2>
                            <p class="text-lg text-slate-700 dark:text-slate-300">Move faster with a polished interface that balances clarity and focus. Toggle between light and dark themes, monitor sync activity, and ship secure integrations without leaving this dashboard.</p>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <a href="https://docs.seatable.io/connector" class="inline-flex items-center justify-center gap-2 rounded-xl bg-cyan-500 px-5 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-cyan-500/30 transition hover:-translate-y-0.5 hover:bg-cyan-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-500">
                                View documentation
                            </a>
                            <a href="https://status.seatable.io" class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:-translate-y-0.5 hover:border-cyan-300 hover:text-slate-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-cyan-500 dark:border-white/10 dark:bg-slate-900 dark:text-slate-100">
                                Check API status
                            </a>
                        </div>
                        <dl class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                            <div class="rounded-2xl bg-white/80 p-4 shadow-sm ring-1 ring-slate-200 backdrop-blur dark:bg-slate-900/60 dark:ring-white/10">
                                <dt class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Connected bases</dt>
                                <dd class="text-2xl font-semibold">2,840</dd>
                                <p class="text-xs text-emerald-500">+8% this month</p>
                            </div>
                            <div class="rounded-2xl bg-white/80 p-4 shadow-sm ring-1 ring-slate-200 backdrop-blur dark:bg-slate-900/60 dark:ring-white/10">
                                <dt class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Average sync</dt>
                                <dd class="text-2xl font-semibold">220 ms</dd>
                                <p class="text-xs text-emerald-500">Optimized</p>
                            </div>
                            <div class="rounded-2xl bg-white/80 p-4 shadow-sm ring-1 ring-slate-200 backdrop-blur dark:bg-slate-900/60 dark:ring-white/10">
                                <dt class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Uptime</dt>
                                <dd class="text-2xl font-semibold">99.98%</dd>
                                <p class="text-xs text-emerald-500">24h rolling</p>
                            </div>
                        </dl>
                    </section>

                    <section class="relative">
                        <div class="absolute inset-x-4 -top-6 -bottom-6 rounded-[28px] bg-white/70 blur-2xl ring-1 ring-white/40 dark:bg-slate-900/70 dark:ring-white/10"></div>
                        <div class="relative overflow-hidden rounded-[28px] border border-slate-200 bg-gradient-to-br from-white via-white to-slate-100 shadow-2xl shadow-cyan-500/10 ring-1 ring-white/80 backdrop-blur dark:border-white/10 dark:from-slate-900 dark:via-slate-900 dark:to-slate-800 dark:ring-white/5">
                            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-white/5">
                                <div>
                                    <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Live activity</p>
                                    <h3 class="text-lg font-semibold">Connector overview</h3>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-100 dark:ring-emerald-700/40">Healthy</span>
                            </div>
                            <div class="space-y-4 px-5 py-6">
                                <div class="rounded-xl border border-slate-100 bg-white/80 p-4 shadow-sm ring-1 ring-white/80 dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 ring-1 ring-cyan-100 dark:bg-cyan-500/20 dark:text-cyan-100 dark:ring-cyan-500/40">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                                    <path d="M12.53 2.47a.75.75 0 0 0-1.06 0l-8.25 8.25a.75.75 0 0 0 1.06 1.06L4.5 11.56V19a.75.75 0 0 0 .75.75h3.5a.75.75 0 0 0 .75-.75v-3.5A1.25 1.25 0 0 1 10.75 14h2.5A1.25 1.25 0 0 1 14.5 15.5V19a.75.75 0 0 0 .75.75h3.5A.75.75 0 0 0 19.5 19v-7.44l.72.72a.75.75 0 1 0 1.06-1.06l-8.25-8.25Z" />
                                                </svg>
                                            </span>
                                            <div>
                                                <p class="text-xs uppercase tracking-wide text-slate-500 dark:text-slate-400">Workspace</p>
                                                <p class="font-semibold">Marketing Operations</p>
                                            </div>
                                        </div>
                                        <span class="text-xs text-emerald-500">Synced 2m ago</span>
                                    </div>
                                    <p class="mt-3 text-sm text-slate-600 dark:text-slate-300">Webhook events are flowing into Seatable and mirrored to your warehouse without delays.</p>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div class="rounded-xl border border-slate-100 bg-white/80 p-4 shadow-sm ring-1 ring-white/80 dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                                        <div class="flex items-center justify-between text-sm font-semibold">
                                            <span>Recent runs</span>
                                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-600 ring-1 ring-slate-200 dark:bg-white/10 dark:text-slate-200 dark:ring-white/10">Today</span>
                                        </div>
                                        <div class="mt-3 space-y-2 text-sm">
                                            <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-slate-700 ring-1 ring-slate-100 dark:bg-white/5 dark:text-slate-100 dark:ring-white/5">
                                                <span>Sync #2038</span>
                                                <span class="text-emerald-500">Passed</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-slate-700 ring-1 ring-slate-100 dark:bg-white/5 dark:text-slate-100 dark:ring-white/5">
                                                <span>Sync #2037</span>
                                                <span class="text-emerald-500">Passed</span>
                                            </div>
                                            <div class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 text-slate-700 ring-1 ring-slate-100 dark:bg-white/5 dark:text-slate-100 dark:ring-white/5">
                                                <span>Sync #2036</span>
                                                <span class="text-orange-500">Retrying</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rounded-xl border border-slate-100 bg-white/80 p-4 shadow-sm ring-1 ring-white/80 dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                                        <div class="flex items-center justify-between text-sm font-semibold">
                                            <span>Active connectors</span>
                                            <span class="rounded-full bg-emerald-100 px-2 py-0.5 text-xs text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-100 dark:ring-emerald-700/40">4/5</span>
                                        </div>
                                        <div class="mt-3 space-y-3 text-sm">
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700 dark:text-slate-200">HubSpot CRM</span>
                                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-100 dark:ring-emerald-700/40">Active</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700 dark:text-slate-200">Shopify Orders</span>
                                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-100 dark:ring-emerald-700/40">Active</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700 dark:text-slate-200">PostgreSQL</span>
                                                <span class="rounded-full bg-orange-100 px-2 py-1 text-xs font-semibold text-orange-700 ring-1 ring-orange-200 dark:bg-orange-900/40 dark:text-orange-100 dark:ring-orange-700/40">Maintenance</span>
                                            </div>
                                            <div class="flex items-center justify-between">
                                                <span class="text-slate-700 dark:text-slate-200">Slack Alerts</span>
                                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-100 dark:ring-emerald-700/40">Active</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </main>

                <section class="grid gap-6 lg:grid-cols-3">
                    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm ring-1 ring-white/80 backdrop-blur dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 text-cyan-600 ring-1 ring-cyan-100 dark:bg-cyan-500/20 dark:text-cyan-100 dark:ring-cyan-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M7.5 3.75A3.75 3.75 0 0 0 3.75 7.5v9A3.75 3.75 0 0 0 7.5 20.25h9A3.75 3.75 0 0 0 20.25 16.5v-9A3.75 3.75 0 0 0 16.5 3.75h-9Zm0 1.5h9A2.25 2.25 0 0 1 18.75 7.5v9A2.25 2.25 0 0 1 16.5 18.75h-9A2.25 2.25 0 0 1 5.25 16.5v-9A2.25 2.25 0 0 1 7.5 5.25Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold">Design built for clarity</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Structured cards, balanced typography, and soft gradients make complex sync data easy to scan in either theme.</p>
                    </div>
                    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm ring-1 ring-white/80 backdrop-blur dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 ring-1 ring-emerald-100 dark:bg-emerald-500/20 dark:text-emerald-100 dark:ring-emerald-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M12 2.25a9.75 9.75 0 1 1 0 19.5a9.75 9.75 0 0 1 0-19.5Zm4.28 8.53a.75.75 0 0 0-1.06-1.06L11 13.94l-2.22-2.22a.75.75 0 1 0-1.06 1.06l2.75 2.75a.75.75 0 0 0 1.06 0l4.75-4.75Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold">Safe by default</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Track uptime, inspect live runs, and confidently roll out automation with guardrails baked into the UI.</p>
                    </div>
                    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white/80 p-5 shadow-sm ring-1 ring-white/80 backdrop-blur dark:border-white/10 dark:bg-slate-900/60 dark:ring-white/5">
                        <div class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-indigo-100 dark:bg-indigo-500/20 dark:text-indigo-100 dark:ring-indigo-500/40">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path d="M6 4.5A2.25 2.25 0 0 1 8.25 2.25h7.5A2.25 2.25 0 0 1 18 4.5v15.75a.75.75 0 0 1-1.1.65l-4.65-2.7a.75.75 0 0 0-.76 0l-4.65 2.7A.75.75 0 0 1 6 20.25V4.5Zm1.5 0v14.13l3.9-2.27a2.25 2.25 0 0 1 2.2 0l3.9 2.27V4.5a.75.75 0 0 0-.75-.75h-7.5A.75.75 0 0 0 7.5 4.5Z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold">Made to tell your story</h3>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Customize the cards, metrics, and call-to-actions so stakeholders know exactly what your connector delivers.</p>
                    </div>
                </section>
            </div>
        </div>
    </body>
</html>
