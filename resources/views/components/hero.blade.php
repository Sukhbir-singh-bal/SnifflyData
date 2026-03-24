{{-- resources/views/components/hero.blade.php --}}
<section class="relative min-h-screen flex flex-col justify-center pt-24 pb-20 overflow-hidden dot-grid">

   <div class="absolute blob w-[600px] h-[600px] rounded-full bg-blue-500/10 dark:bg-blue-600/15 -top-40 -left-40 blur-[120px] animate-float"></div>

<div class="absolute blob w-[500px] h-[500px] rounded-full bg-indigo-500/10 dark:bg-indigo-600/10 -bottom-20 -right-32 blur-[100px]" 
     style="animation: float 8s ease-in-out infinite; animation-delay: 2s;"></div>

<div class="absolute blob w-[400px] h-[400px] rounded-full bg-violet-500/10 dark:bg-violet-600/15 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 blur-[80px]" 
     style="animation: float 10s ease-in-out infinite; animation-delay: 1s;"></div>

    <div class="max-w-7xl mx-auto px-6 relative z-10 w-full">

        {{-- Announcement Badge --}}
        <div class="flex justify-center mb-8 animate-fade-in">
            <a href="#" class="inline-flex items-center gap-2.5 px-4 py-2 rounded-full border border-blue-500/25 bg-blue-500/8 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-widest hover:bg-blue-500/15 transition-all duration-200 group">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                New: AI-Powered Auto Extraction
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Headline --}}
        <div class="text-center space-y-6 mb-12">
            <h1 class="text-6xl md:text-7xl lg:text-8xl font-extrabold tracking-tighter leading-[0.95] max-w-5xl mx-auto animate-slide-up anim-delay-100">
                Scraping at the speed<br>
                <span class="text-gradient">of thought.</span>
            </h1>

            <p class="text-lg md:text-xl text-slate-500 dark:text-slate-400 max-w-2xl mx-auto leading-relaxed animate-slide-up anim-delay-200">
                The web scraping infrastructure for ambitious data teams. Proxies, browsers, and CAPTCHAs handled automatically — in a single API call.
            </p>

            {{-- CTA Buttons --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-2 animate-slide-up anim-delay-300">
                <a href="{{ route('register') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-8 py-4 rounded-2xl font-extrabold text-base hover:scale-105 hover:shadow-2xl active:scale-100 transition-all duration-200 shadow-xl">
                    Start Building Free
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>

                <div class="flex items-center gap-3 px-5 py-3.5 rounded-2xl bg-slate-100 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 font-mono text-sm text-slate-600 dark:text-slate-300 select-all cursor-pointer hover:border-blue-400/50 transition-colors group">
                    <span class="text-blue-500 font-bold">$</span>
                    <span>npm install sniffly-sdk</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-slate-400 group-hover:text-blue-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                </div>
            </div>

            {{-- Social Proof --}}
            <div class="flex items-center justify-center gap-6 pt-4 animate-fade-in anim-delay-400">
                <div class="flex -space-x-2">
                    @foreach(['bg-blue-500','bg-violet-500','bg-emerald-500','bg-orange-500','bg-pink-500'] as $color)
                    <div class="w-8 h-8 rounded-full border-2 border-white dark:border-[#080c14] {{ $color }} flex items-center justify-center text-[10px] font-bold text-white">{{ chr(65 + $loop->index) }}</div>
                    @endforeach
                </div>
                <div class="text-sm text-slate-500 dark:text-slate-400">
                    <span class="font-bold text-slate-900 dark:text-white">2,400+</span> developers trust SnifflyData
                </div>
            </div>
        </div>

        {{-- Code Block --}}
        <x-code-block class="animate-slide-up anim-delay-500" />

    </div>
</section>
