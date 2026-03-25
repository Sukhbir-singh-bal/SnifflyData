<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} - SnifflyData</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#020617] text-slate-300 antialiased selection:bg-blue-500/30 selection:text-blue-200">
    <div class="min-h-screen lg:grid lg:grid-cols-[280px_1fr]">
        
        <aside class="relative z-40 border-r border-white/5 bg-[#020617]">
            <div class="flex h-20 items-center px-6">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-blue-700 shadow-[0_0_15px_rgba(37,99,235,0.3)] transition-transform group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="white" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white italic">Sniffly<span class="text-blue-500 transition-colors group-hover:text-blue-400">Data</span></span>
                </a>
            </div>

            <nav class="mt-4 space-y-1.5 px-4">
                <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Main Menu</div>
                
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600/10 text-blue-400 ring-1 ring-blue-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Overview
                </a>
                
                <a href="{{ route('dashboard.api-keys') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ request()->routeIs('dashboard.api-keys') ? 'bg-blue-600/10 text-blue-400 ring-1 ring-blue-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                    API Keys
                </a>

                <a href="{{ route('dashboard.playground') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ request()->routeIs('dashboard.playground') ? 'bg-blue-600/10 text-purple-400 ring-1 ring-purple-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" /></svg>
                    Playground
                </a>

                <a href="{{ route('dashboard.requests') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ request()->routeIs('dashboard.requests') ? 'bg-blue-600/10 text-blue-400 ring-1 ring-blue-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                    Requests
                </a>

                <a href="{{ route('dashboard.usage') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-bold transition-all {{ request()->routeIs('dashboard.usage') ? 'bg-blue-600/10 text-blue-400 ring-1 ring-blue-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Usage
                </a>
            </nav>
        </aside>

        <div class="relative flex flex-col min-w-0 overflow-hidden">
            <div class="absolute top-0 right-0 h-64 w-64 rounded-full bg-blue-600/5 blur-[100px]"></div>
            
            <header class="sticky top-0 z-30 border-b border-white/5 bg-[#020617]/80 backdrop-blur-xl">
                <div class="flex h-20 items-center justify-between px-6 sm:px-8">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500">Console</p>
                        <h1 class="text-lg font-bold text-white">{{ $header ?? 'Dashboard' }}</h1>
                    </div>
                    
                    <div class="flex items-center gap-6">
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-bold text-white leading-none">{{ auth()->user()?->name }}</p>
                            <p class="mt-1 text-xs text-slate-500 leading-none">{{ auth()->user()?->email }}</p>
                        </div>
                        
                        <div class="h-8 w-px bg-white/10"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="group flex items-center gap-2 rounded-xl bg-white/5 px-4 py-2 text-xs font-bold text-slate-300 transition-all hover:bg-rose-500/10 hover:text-rose-400 ring-1 ring-white/10 hover:ring-rose-500/20">
                                <span>Logout</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="relative flex-1 overflow-y-auto p-6 sm:p-8 lg:p-10">
                <div class="mx-auto max-w-7xl">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>