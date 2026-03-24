<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - ScrapeFlow</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 text-slate-800 antialiased">
    <div class="min-h-screen lg:grid lg:grid-cols-[260px_1fr]">
        <aside class="border-r border-slate-200 bg-white">
            <div class="flex h-16 items-center border-b border-slate-200 px-5">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-slate-900 text-sm font-semibold text-white">S</span>
                    <span class="text-sm font-semibold tracking-tight text-slate-900">ScrapeFlow</span>
                </a>
            </div>

            <nav class="space-y-1 p-3">
                <a href="{{ route('dashboard') }}" class="flex items-center rounded-lg bg-slate-100 px-3 py-2 text-sm font-medium text-slate-900">
                    Dashboard
                </a>
                <a href="#" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                    API Keys
                </a>
                <a href="#" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                    Usage
                </a>
                <a href="#" class="flex items-center rounded-lg px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                    Billing
                </a>
            </nav>
        </aside>

        <div class="min-w-0">
            <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur">
                <div class="flex h-16 items-center justify-between px-4 sm:px-6">
                    <div>
                        <p class="text-sm text-slate-500">Overview</p>
                        <h1 class="text-base font-semibold text-slate-900">{{ $header ?? 'Dashboard' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-slate-900">John Doe</p>
                            <p class="text-xs text-slate-500">john@scrapeflow.dev</p>
                        </div>
                        <div class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-sm font-semibold text-white">
                            J
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
