{{-- resources/views/components/nav.blade.php --}}
<nav class="fixed w-full z-50 nav-blur bg-white/80 dark:bg-[#080c14]/80 border-b border-slate-200/60 dark:border-slate-800/60 py-3 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">

        {{-- Left: Logo + Nav Links --}}
        <div class="flex items-center gap-10">
            <x-logo />

            @if (Route::is('welcome'))
                <div class="hidden md:flex items-center gap-1">
                @foreach([
                    ['href' => '#features',     'label' => 'Product'],
                    ['href' => '#how-it-works', 'label' => 'How It Works'],
                    ['href' => '#pricing',      'label' => 'Pricing'],
                    ['href' => '#docs',         'label' => 'Docs'],
                ] as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="px-3 py-2 rounded-lg text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/70 transition-all duration-200"
                >{{ $link['label'] }}</a>
                @endforeach
            </div>
            @endif
            
        </div>

        {{-- Right: Theme Toggle + Auth --}}
        <div class="flex items-center gap-3">

            {{-- Theme Toggle --}}
            <button
                @click="darkMode = !darkMode"
                class="relative p-2.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-200 text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white group"
                :aria-label="darkMode ? 'Switch to light mode' : 'Switch to dark mode'"
            >
                {{-- Sun Icon --}}
                <svg
                    x-show="darkMode"
                    x-cloak
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-4.5 w-4.5 transition-transform duration-300 group-hover:rotate-12"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:18px;height:18px;"
                >
                    <circle cx="12" cy="12" r="5"/>
                    <line x1="12" y1="1"  x2="12" y2="3"/>
                    <line x1="12" y1="21" x2="12" y2="23"/>
                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                    <line x1="1" y1="12" x2="3" y2="12"/>
                    <line x1="21" y1="12" x2="23" y2="12"/>
                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                </svg>

                {{-- Moon Icon --}}
                <svg
                    x-show="!darkMode"
                    xmlns="http://www.w3.org/2000/svg"
                    class="transition-transform duration-300 group-hover:-rotate-12"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round"
                    style="width:18px;height:18px;"
                >
                    <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            {{-- Auth Buttons --}}
            @if (Route::has('login'))
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="text-sm font-bold text-blue-600 dark:text-blue-400 hover:underline transition"
                    >Dashboard →</a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="hidden sm:block text-sm font-semibold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition px-3 py-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800"
                    >Sign in</a>

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-200 shadow-lg shadow-blue-600/25 hover:shadow-blue-500/40 hover:-translate-y-0.5"
                    >
                        Get API Key
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                @endauth
            @endif
        </div>
    </div>
</nav>
