{{-- resources/views/components/comparison.blade.php --}}
<section class="py-28 px-6 transition-colors">
    <div class="max-w-4xl mx-auto">

        <div class="text-center mb-14">
            <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-blue-600 dark:text-blue-400 mb-4">Why SnifflyData</span>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight">Stop wrestling with DIY scrapers.</h2>
        </div>

        <div class="rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-xl shadow-slate-200/50 dark:shadow-black/30">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 dark:bg-[#0d1421] border-b border-slate-200 dark:border-slate-800">
                        <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-500">Feature</th>
                        <th class="p-5 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-500">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-slate-400 dark:bg-slate-600"></span>
                                DIY Scraper
                            </div>
                        </th>
                        <th class="p-5 text-xs font-bold uppercase tracking-wider text-blue-600 dark:text-blue-400">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                                SnifflyData
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 bg-white dark:bg-[#080c14]">
                    @foreach([
                        ['feature' => 'IP Bans',         'diy' => 'Frequent',       'us' => 'Never'],
                        ['feature' => 'CAPTCHA Solving', 'diy' => 'Manual & Slow',  'us' => 'Automatic'],
                        ['feature' => 'JS Rendering',    'diy' => 'Complex Setup',  'us' => 'Built-In'],
                        ['feature' => 'Maintenance',     'diy' => 'Daily Breaks',   'us' => 'Zero'],
                        ['feature' => 'Geo-Targeting',   'diy' => 'Impossible',     'us' => '100+ Countries'],
                        ['feature' => 'Uptime SLA',      'diy' => 'None',           'us' => '99.99%'],
                    ] as $row)
                    <tr class="comparison-row transition-colors">
                        <td class="p-5 text-sm font-semibold text-slate-800 dark:text-slate-200">{{ $row['feature'] }}</td>
                        <td class="p-5">
                            <span class="inline-flex items-center gap-1.5 text-sm text-slate-400 dark:text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                {{ $row['diy'] }}
                            </span>
                        </td>
                        <td class="p-5">
                            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                {{ $row['us'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
