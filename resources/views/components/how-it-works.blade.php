{{-- resources/views/components/how-it-works.blade.php --}}
<section id="how-it-works" class="py-28 px-6 bg-slate-50 dark:bg-[#0a0f1a] transition-colors">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-20">
            <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-blue-600 dark:text-blue-400 mb-4">How It Works</span>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-5">
                Three steps to clean data.
            </h2>
            <p class="text-lg text-slate-500 dark:text-slate-400">You focus on what the data can do. We handle everything else.</p>
        </div>

        <div class="relative">
            {{-- Connecting line (desktop) --}}
            <div class="hidden md:block absolute top-12 left-1/6 right-1/6 h-px bg-gradient-to-r from-transparent via-blue-500/30 to-transparent pointer-events-none"></div>

            <div class="grid md:grid-cols-3 gap-10 relative z-10">
                @foreach([
                    [
                        'step'  => '01',
                        'icon'  => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12',
                        'title' => 'Send a Request',
                        'desc'  => 'Pass any URL to our API with a few options: JS rendering, proxy type, geolocation, and your desired output format.',
                        'color' => 'blue',
                    ],
                    [
                        'step'  => '02',
                        'icon'  => 'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                        'title' => 'We Handle the Magic',
                        'desc'  => 'IP rotation, CAPTCHA solving, browser rendering, Cloudflare bypass — all automated and invisible to you.',
                        'color' => 'violet',
                    ],
                    [
                        'step'  => '03',
                        'icon'  => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                        'title' => 'Get Clean JSON',
                        'desc'  => 'Receive structured, validated JSON in the shape you defined. No parsing, no cleaning, no maintenance.',
                        'color' => 'emerald',
                    ],
                ] as $step)
                @php
                    $stepColors = [
                        'blue'   => ['num' => 'text-blue-500/20 dark:text-blue-600/25',   'icon' => 'bg-blue-500/10 text-blue-600 dark:text-blue-400'],
                        'violet' => ['num' => 'text-violet-500/20 dark:text-violet-600/25', 'icon' => 'bg-violet-500/10 text-violet-600 dark:text-violet-400'],
                        'emerald'=> ['num' => 'text-emerald-500/20 dark:text-emerald-600/25', 'icon' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400'],
                    ];
                    $c = $stepColors[$step['color']];
                @endphp
                <div class="relative flex flex-col items-start p-8 rounded-2xl bg-white dark:bg-[#0d1421] border border-slate-200 dark:border-slate-800 card-glow">
                    <span class="absolute top-4 right-6 text-7xl font-black {{ $c['num'] }} select-none leading-none">{{ $step['step'] }}</span>
                    <div class="w-12 h-12 rounded-xl {{ $c['icon'] }} flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-extrabold text-slate-900 dark:text-white mb-3">{{ $step['title'] }}</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
