{{-- resources/views/components/code-block.blade.php --}}
@props(['class' => ''])

<div
    x-data="{
        activeTab: 'python',
        copied: false,
        copyCode() {
            const el = document.getElementById(this.activeTab + '-code');
            if (!el) return;
            navigator.clipboard.writeText(el.innerText.trim()).then(() => {
                this.copied = true;
                setTimeout(() => this.copied = false, 2000);
            });
        }
    }"
    class="max-w-4xl mx-auto relative group {{ $class }}"
>
    {{-- Outer glow --}}
    <div class="absolute -inset-px bg-gradient-to-r from-blue-600/50 via-indigo-600/50 to-violet-600/50 rounded-[1.75rem] blur-sm opacity-0 group-hover:opacity-60 transition-all duration-700 pointer-events-none"></div>

    {{-- Card --}}
    <div class="relative bg-[#0d1117] rounded-[1.5rem] border border-slate-700/50 shadow-2xl shadow-black/40 overflow-hidden">

        {{-- Header Bar --}}
        <div class="flex items-center justify-between px-5 py-4 bg-[#161b22] border-b border-slate-700/50">
            {{-- Window Controls --}}
            <div class="flex items-center gap-4">
                <div class="flex gap-1.5">
                    <span class="w-3 h-3 rounded-full bg-red-500/80"></span>
                    <span class="w-3 h-3 rounded-full bg-yellow-500/80"></span>
                    <span class="w-3 h-3 rounded-full bg-green-500/80"></span>
                </div>

                {{-- Language Tabs --}}
                <div class="flex items-center gap-0.5 ml-2">
                    @foreach([
                        ['key' => 'python', 'label' => 'Python'],
                        ['key' => 'js',     'label' => 'Node.js'],
                        ['key' => 'curl',   'label' => 'cURL'],
                    ] as $tab)
                    <button
                        @click="activeTab = '{{ $tab['key'] }}'"
                        :class="activeTab === '{{ $tab['key'] }}'
                            ? 'bg-slate-700/60 text-slate-100'
                            : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/30'"
                        class="px-3 py-1.5 rounded-lg text-xs font-bold font-mono transition-all duration-150"
                    >{{ $tab['label'] }}</button>
                    @endforeach
                </div>
            </div>

            {{-- Copy Button --}}
            <button
                @click="copyCode()"
                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all duration-200"
                :class="copied
                    ? 'bg-emerald-500/15 text-emerald-400'
                    : 'text-slate-500 hover:text-slate-300 hover:bg-slate-700/40'"
            >
                <span x-show="!copied">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                    </svg>
                </span>
                <span x-show="copied" x-cloak>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </span>
                <span x-text="copied ? 'Copied!' : 'Copy'"></span>
            </button>
        </div>

        {{-- Code Content --}}
        <div class="p-6 font-mono text-sm leading-7 code-scroll overflow-x-auto min-h-[220px]">

            {{-- Python --}}
            <div x-show="activeTab === 'python'" id="python-code">
                <div class="flex gap-6">
                    <div class="select-none text-slate-600 text-right leading-7" style="min-width:1.5rem">
                        @for($i=1;$i<=9;$i++)<div>{{$i}}</div>@endfor
                    </div>
                    <div class="flex-1 text-slate-300">
                        <div><span class="text-pink-400">import</span> <span class="text-slate-100">sniffly</span></div>
                        <div class="h-3"></div>
                        <div><span class="text-slate-500"># Initialize client</span></div>
                        <div><span class="text-slate-100">client</span> <span class="text-slate-500">=</span> sniffly.<span class="text-sky-400">Client</span>(<span class="text-slate-100">api_key</span><span class="text-slate-500">=</span><span class="text-emerald-400">'YOUR_API_KEY'</span>)</div>
                        <div class="h-3"></div>
                        <div><span class="text-slate-500"># Extract structured data</span></div>
                        <div><span class="text-slate-100">result</span> <span class="text-slate-500">=</span> client.<span class="text-sky-400">extract</span>(</div>
                        <div class="pl-6"><span class="text-slate-100">url</span><span class="text-slate-500">=</span><span class="text-emerald-400">'https://store.com/product/123'</span>,</div>
                        <div class="pl-6"><span class="text-slate-100">render_js</span><span class="text-slate-500">=</span><span class="text-orange-400">True</span>,  <span class="text-slate-600"># Handle SPA/React sites</span></div>
                        <div class="pl-6"><span class="text-slate-100">proxy_type</span><span class="text-slate-500">=</span><span class="text-emerald-400">'residential'</span>,</div>
                        <div class="pl-6"><span class="text-slate-100">schema</span><span class="text-slate-500">=</span><span class="text-emerald-400">'ecommerce_product'</span></div>
                        <div>)</div>
                        <div class="h-3"></div>
                        <div><span class="text-sky-400">print</span>(result.<span class="text-slate-100">json</span>)  <span class="text-slate-600"># Clean structured output</span></div>
                    </div>
                </div>
            </div>

            {{-- Node.js --}}
            <div x-show="activeTab === 'js'" x-cloak id="js-code">
                <div class="flex gap-6">
                    <div class="select-none text-slate-600 text-right leading-7" style="min-width:1.5rem">
                        @for($i=1;$i<=10;$i++)<div>{{$i}}</div>@endfor
                    </div>
                    <div class="flex-1 text-slate-300">
                        <div><span class="text-pink-400">import</span> { <span class="text-sky-400">Sniffly</span> } <span class="text-pink-400">from</span> <span class="text-emerald-400">'sniffly-sdk'</span>;</div>
                        <div class="h-3"></div>
                        <div><span class="text-pink-400">const</span> <span class="text-slate-100">client</span> = <span class="text-pink-400">new</span> <span class="text-sky-400">Sniffly</span>({ <span class="text-slate-100">apiKey</span>: <span class="text-emerald-400">'YOUR_API_KEY'</span> });</div>
                        <div class="h-3"></div>
                        <div><span class="text-slate-500">// Extract with AI-powered schema detection</span></div>
                        <div><span class="text-pink-400">const</span> { <span class="text-slate-100">data</span>, <span class="text-slate-100">credits</span> } = <span class="text-pink-400">await</span> client.<span class="text-sky-400">extract</span>({</div>
                        <div class="pl-6"><span class="text-slate-100">url</span>: <span class="text-emerald-400">'https://example.com'</span>,</div>
                        <div class="pl-6"><span class="text-slate-100">waitUntil</span>: <span class="text-emerald-400">'networkidle'</span>,</div>
                        <div class="pl-6"><span class="text-slate-100">geo</span>: <span class="text-emerald-400">'us-east'</span>,</div>
                        <div>});</div>
                        <div class="h-3"></div>
                        <div><span class="text-slate-500">// Automatic TypeScript types included</span></div>
                        <div>console.<span class="text-sky-400">log</span>(<span class="text-slate-100">data</span>.<span class="text-sky-400">title</span>, <span class="text-slate-100">data</span>.<span class="text-sky-400">price</span>);</div>
                    </div>
                </div>
            </div>

            {{-- cURL --}}
            <div x-show="activeTab === 'curl'" x-cloak id="curl-code">
                <div class="flex gap-6">
                    <div class="select-none text-slate-600 text-right leading-7" style="min-width:1.5rem">
                        @for($i=1;$i<=8;$i++)<div>{{$i}}</div>@endfor
                    </div>
                    <div class="flex-1 text-slate-300">
                        <div><span class="text-slate-500"># Single endpoint — everything handled for you</span></div>
                        <div><span class="text-sky-400">curl</span> -X POST https://api.snifflydata.com/v1/extract \</div>
                        <div class="pl-5">-H <span class="text-emerald-400">"Authorization: Bearer YOUR_API_KEY"</span> \</div>
                        <div class="pl-5">-H <span class="text-emerald-400">"Content-Type: application/json"</span> \</div>
                        <div class="pl-5">-d <span class="text-emerald-400">'{'</span></div>
                        <div class="pl-9"><span class="text-emerald-400">"url": "https://example.com"</span>,</div>
                        <div class="pl-9"><span class="text-emerald-400">"render_js": true</span>,</div>
                        <div class="pl-9"><span class="text-emerald-400">"proxy_type": "residential"</span></div>
                        <div class="pl-5"><span class="text-emerald-400">'}'</span></div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer stat bar --}}
        <div class="px-6 py-3 bg-[#161b22] border-t border-slate-700/50 flex items-center gap-6">
            @foreach([
                ['dot' => 'bg-emerald-400', 'label' => 'API Status: Operational'],
                ['dot' => 'bg-blue-400', 'label' => 'Avg. Response: 1.2s'],
                ['dot' => 'bg-violet-400', 'label' => '99.98% Uptime'],
            ] as $stat)
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span class="w-1.5 h-1.5 rounded-full {{ $stat['dot'] }} animate-pulse-slow"></span>
                {{ $stat['label'] }}
            </div>
            @endforeach
        </div>
    </div>
</div>
