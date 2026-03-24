{{-- resources/views/components/features.blade.php --}}
<section id="features" class="py-28 px-6 transition-colors">
    <div class="max-w-7xl mx-auto">

        {{-- Section Header --}}
        <div class="text-center mb-20 max-w-3xl mx-auto">
            <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-blue-600 dark:text-blue-400 mb-4">Platform</span>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-5 leading-tight">
                Everything you need.<br>Nothing you don't.
            </h2>
            <p class="text-lg text-slate-500 dark:text-slate-400 leading-relaxed">
                Stop building and maintaining brittle scrapers. Our infrastructure handles the hard parts so you can focus on what your data can do.
            </p>
        </div>

        {{-- Feature Cards Grid --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach([
                [
                    'icon'  => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                    'color' => 'blue',
                    'title' => 'Proxy Rotation',
                    'desc'  => 'Millions of residential and datacenter IPs across 100+ countries. Zero IP bans, ever.',
                ],
                [
                    'icon'  => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                    'color' => 'violet',
                    'title' => 'JS Rendering',
                    'desc'  => 'Full Chrome browser instances that render React, Vue, and Angular apps with ease.',
                ],
                [
                    'icon'  => 'M13 10V3L4 14h7v7l9-11h-7z',
                    'color' => 'emerald',
                    'title' => 'CAPTCHA Solving',
                    'desc'  => 'reCAPTCHA v2/v3, hCaptcha, Cloudflare Turnstile — solved in milliseconds automatically.',
                ],
                [
                    'icon'  => 'M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01',
                    'color' => 'orange',
                    'title' => 'AI Extraction',
                    'desc'  => 'Describe the data you want in plain English. Our AI figures out the schema and returns clean JSON.',
                ],
                [
                    'icon'  => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
                    'color' => 'pink',
                    'title' => 'Scheduled Scraping',
                    'desc'  => 'Set-and-forget cron jobs. We run your scraper, store the diffs, and alert on changes.',
                ],
                [
                    'icon'  => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                    'color' => 'sky',
                    'title' => 'Real-Time Analytics',
                    'desc'  => 'Live dashboard for credits, success rates, and response times. Full request logs included.',
                ],
            ] as $feature)
            @php
                $colorMap = [
                    'blue'   => 'bg-blue-500/10 dark:bg-blue-500/15 text-blue-600 dark:text-blue-400 border-blue-500/20',
                    'violet' => 'bg-violet-500/10 dark:bg-violet-500/15 text-violet-600 dark:text-violet-400 border-violet-500/20',
                    'emerald'=> 'bg-emerald-500/10 dark:bg-emerald-500/15 text-emerald-600 dark:text-emerald-400 border-emerald-500/20',
                    'orange' => 'bg-orange-500/10 dark:bg-orange-500/15 text-orange-600 dark:text-orange-400 border-orange-500/20',
                    'pink'   => 'bg-pink-500/10 dark:bg-pink-500/15 text-pink-600 dark:text-pink-400 border-pink-500/20',
                    'sky'    => 'bg-sky-500/10 dark:bg-sky-500/15 text-sky-600 dark:text-sky-400 border-sky-500/20',
                ];
            @endphp
            <div class="card-glow p-7 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-[#0d1421] group">
                <div class="w-12 h-12 rounded-xl {{ $colorMap[$feature['color']] }} border flex items-center justify-center mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $feature['icon'] }}"/>
                    </svg>
                </div>
                <h3 class="text-base font-extrabold mb-2 text-slate-900 dark:text-white">{{ $feature['title'] }}</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed">{{ $feature['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
