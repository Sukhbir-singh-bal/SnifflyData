<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        darkMode: (() => {
            const stored = localStorage.getItem('theme');
            if (stored) return stored === 'dark';
            return window.matchMedia('(prefers-color-scheme: dark)').matches;
        })()
    }"
    x-init="
        $watch('darkMode', val => {
            localStorage.setItem('theme', val ? 'dark' : 'light');
        });
        // Apply class immediately to prevent flash
        if (darkMode) document.documentElement.classList.add('dark');
    "
    :class="{ 'dark': darkMode }"
>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'SnifflyData | The Developer\'s Scraping Infrastructure')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=syne:400,500,600,700,800|jetbrains-mono:400,500,700" rel="stylesheet" />

        <!-- Alpine.js -->
        <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    darkMode: 'class',
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Syne', 'sans-serif'],
                                mono: ['JetBrains Mono', 'monospace'],
                            },
                            colors: {
                                brand: {
                                    50:  '#eff6ff',
                                    100: '#dbeafe',
                                    400: '#60a5fa',
                                    500: '#3b82f6',
                                    600: '#2563eb',
                                    700: '#1d4ed8',
                                    900: '#1e3a8a',
                                }
                            },
                            animation: {
                                'float': 'float 6s ease-in-out infinite',
                                'pulse-slow': 'pulse 3s ease-in-out infinite',
                                'slide-up': 'slideUp 0.6s ease-out forwards',
                                'fade-in': 'fadeIn 0.8s ease-out forwards',
                            },
                            keyframes: {
                                float: {
                                    '0%, 100%': { transform: 'translateY(0px)' },
                                    '50%': { transform: 'translateY(-12px)' },
                                },
                                slideUp: {
                                    from: { opacity: '0', transform: 'translateY(30px)' },
                                    to:   { opacity: '1', transform: 'translateY(0)' },
                                },
                                fadeIn: {
                                    from: { opacity: '0' },
                                    to:   { opacity: '1' },
                                }
                            }
                        }
                    }
                }
            </script>
            <style>
                /* Flash prevention — applied before Alpine hydrates */
                :root { color-scheme: light dark; }

                [x-cloak] { display: none !important; }

                /* Dot-grid background */
                .dot-grid {
                    background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,0.07) 1px, transparent 0);
                    background-size: 28px 28px;
                }
                .dark .dot-grid {
                    background-image: radial-gradient(circle at 1px 1px, rgba(255,255,255,0.06) 1px, transparent 0);
                }

                /* Glowing blobs */
                .blob {
                    filter: blur(90px);
                    border-radius: 100%;
                    position: absolute;
                    pointer-events: none;
                    will-change: transform;
                }

                /* Gradient text */
                .text-gradient {
                    background: linear-gradient(135deg, #3b82f6 0%, #818cf8 50%, #a78bfa 100%);
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: transparent;
                    background-clip: text;
                }

                /* Card glow on hover */
                .card-glow {
                    transition: box-shadow 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
                }
                .card-glow:hover {
                    box-shadow: 0 0 40px rgba(37,99,235,0.12);
                    border-color: rgba(37,99,235,0.4);
                    transform: translateY(-4px);
                }

                /* Code block scrollbar */
                .code-scroll::-webkit-scrollbar { height: 4px; }
                .code-scroll::-webkit-scrollbar-track { background: transparent; }
                .code-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 4px; }

                /* Smooth section transitions */
                section { transition: background-color 0.3s ease; }

                /* Nav blur */
                .nav-blur {
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                }

                /* Pricing highlight ring */
                .ring-highlight {
                    box-shadow: 0 0 0 1px #2563eb, 0 25px 60px rgba(37,99,235,0.25);
                }

                /* Staggered animation helpers */
                .anim-delay-100 { animation-delay: 0.1s; opacity: 0; }
                .anim-delay-200 { animation-delay: 0.2s; opacity: 0; }
                .anim-delay-300 { animation-delay: 0.3s; opacity: 0; }
                .anim-delay-400 { animation-delay: 0.4s; opacity: 0; }
                .anim-delay-500 { animation-delay: 0.5s; opacity: 0; }

                /* Table row hover */
                .comparison-row:hover td { background-color: rgba(37,99,235,0.04); }
                .dark .comparison-row:hover td { background-color: rgba(37,99,235,0.08); }
            </style>
        @endif
    </head>

    <body class="bg-white dark:bg-[#080c14] text-slate-900 dark:text-slate-100 antialiased transition-colors duration-300 font-sans overflow-x-hidden">

        <x-nav />

        <main>
            @yield('content')
        </main>

        <x-footer />

    </body>
</html>
