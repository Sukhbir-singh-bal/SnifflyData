{{-- resources/views/components/cta.blade.php --}}
<section class="py-28 px-6 border-t border-slate-100 dark:border-slate-800/60 transition-colors">
    <div class="max-w-3xl mx-auto text-center">

        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/8 dark:bg-blue-500/10 border border-blue-500/20 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-widest mb-8">
            <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span>
            Get started in under 60 seconds
        </div>

        <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight leading-tight mb-6">
            Ready to start<br>
            <span class="text-gradient">scraping smarter?</span>
        </h2>

        <p class="text-lg text-slate-500 dark:text-slate-400 mb-12">
            Join 2,400+ developers who've ditched brittle DIY scrapers for SnifflyData.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a
                href="{{ route('register') }}"
                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white px-10 py-5 rounded-2xl font-extrabold text-lg transition-all duration-200 shadow-2xl shadow-blue-600/30 hover:shadow-blue-500/50 hover:-translate-y-1"
            >
                Create Free Account
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>

            <a
                href="#"
                class="inline-flex items-center justify-center gap-2 text-slate-700 dark:text-slate-300 px-8 py-5 rounded-2xl font-bold text-lg border border-slate-200 dark:border-slate-700 hover:border-slate-300 dark:hover:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Read Docs
            </a>
        </div>

        <p class="mt-8 text-sm text-slate-400">No credit card required · Cancel any time · GDPR compliant</p>
    </div>
</section>
