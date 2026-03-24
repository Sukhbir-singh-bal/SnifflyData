
<section id="pricing" class="py-28 px-6 bg-[#080c14] relative overflow-hidden">

    <div class="absolute blob w-[600px] h-[600px] rounded-full bg-blue-500/10 dark:bg-blue-600/15 -top-40 -left-40 blur-[120px] animate-float"></div>

    <div class="absolute blob w-[500px] h-[500px] rounded-full bg-indigo-500/10 dark:bg-indigo-600/10 -bottom-20 -right-32 blur-[100px]" 
         style="animation: float 8s ease-in-out infinite; animation-delay: 2s;"></div>
    
    <div class="absolute blob w-[400px] h-[400px] rounded-full bg-violet-500/10 dark:bg-violet-600/15 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 blur-[80px]" 
         style="animation: float 10s ease-in-out infinite; animation-delay: 1s;"></div>
    <div class="max-w-7xl mx-auto relative z-10">

        {{-- Header --}}
        <div class="text-center mb-20 text-white">
            <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-blue-400 mb-4">Pricing</span>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4">Simple, transparent pricing.</h2>
            <p class="text-slate-400 text-lg">Start free. Scale when you need to. Cancel any time.</p>
        </div>

        {{-- Cards --}}
        <div class="grid md:grid-cols-3 gap-6 items-center">

            {{-- Hobby --}}
            <div class="p-8 rounded-2xl border border-slate-700/60 bg-slate-800/30 flex flex-col hover:border-slate-600/60 transition-all duration-300 group">
                <div class="mb-8">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Hobby</span>
                    <div class="mt-3 flex items-end gap-1">
                        <span class="text-5xl font-black text-white">$0</span>
                        <span class="text-slate-500 mb-2">/month</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-2">Perfect for experiments and side projects.</p>
                </div>

                <ul class="space-y-3.5 mb-10 flex-grow">
                    
                    @foreach(['1,000 API Credits/mo', 'Basic Datacenter Proxies', 'HTML + JSON Output', 'Community Support', '500ms Avg. Latency'] as $feat)
                    <li class="flex items-center gap-3 text-sm text-slate-400">
                        <svg class="w-4 h-4 text-slate-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="block w-full py-3.5 text-center rounded-xl border border-slate-600 text-slate-300 font-bold text-sm hover:bg-slate-700/50 hover:border-slate-500 transition-all duration-200">
                    Start Free
                </a>
            </div>

            {{-- Pro (Featured) --}}
            <div class="relative p-8 rounded-2xl bg-white text-slate-900 flex flex-col ring-highlight">
                <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-600 text-white text-[10px] font-black uppercase tracking-widest shadow-lg shadow-blue-600/40">
                        <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                        Most Popular
                    </span>
                </div>

                <div class="mb-8 mt-2">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Pro</span>
                    <div class="mt-3 flex items-end gap-1">
                        <span class="text-5xl font-black text-slate-900">$49</span>
                        <span class="text-slate-400 mb-2">/month</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-2">For teams that need reliable, at-scale scraping.</p>
                </div>

                <ul class="space-y-3.5 mb-10 flex-grow">
                    @foreach(['50,000 API Credits/mo', 'Residential Proxies', 'AI Extraction Included', 'JS Rendering + CAPTCHA', 'Priority Email Support', '99.9% SLA'] as $feat)
                    <li class="flex items-center gap-3 text-sm text-slate-700 font-medium">
                        <svg class="w-4 h-4 text-blue-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="{{ route('register') }}" class="block w-full py-3.5 text-center rounded-xl bg-blue-600 hover:bg-blue-500 active:bg-blue-700 text-white font-bold text-sm transition-all duration-200 shadow-lg shadow-blue-600/30 hover:shadow-blue-500/40 hover:-translate-y-0.5">
                    Get Started with Pro
                </a>
            </div>

            {{-- Enterprise --}}
            <div class="p-8 rounded-2xl border border-slate-700/60 bg-slate-800/30 flex flex-col hover:border-slate-600/60 transition-all duration-300 group">
                <div class="mb-8">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-500">Enterprise</span>
                    <div class="mt-3 flex items-end gap-1">
                        <span class="text-5xl font-black text-white">Custom</span>
                    </div>
                    <p class="text-sm text-slate-500 mt-2">Tailored for high-volume and mission-critical workloads.</p>
                </div>

                <ul class="space-y-3.5 mb-10 flex-grow">
                    @foreach(['Unlimited Credits', 'Dedicated IP Pools', 'Custom SLA & Uptime', 'SSO & Team Management', 'Dedicated Success Manager', 'Compliance & Data Contracts'] as $feat)
                    <li class="flex items-center gap-3 text-sm text-slate-400">
                        <svg class="w-4 h-4 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>

                <a href="mailto:sales@snifflydata.com" class="block w-full py-3.5 text-center rounded-xl border border-blue-500/40 text-blue-400 font-bold text-sm hover:bg-blue-500/10 hover:border-blue-400/60 transition-all duration-200">
                    Talk to Sales
                </a>
            </div>

        </div>

        {{-- Bottom note --}}
        <p class="text-center text-sm text-slate-600 mt-10">All plans include a 14-day free trial. No credit card required.</p>
    </div>
</section>
