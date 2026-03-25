@extends('layouts.dashboard', ['header' => 'API Playground'])

@section('content')
    <div class="space-y-6">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
            
            <!-- Configuration Panel -->
            <div class="rounded-[24px] border border-white/5 bg-[#020617] p-1 shadow-2xl relative z-10">
                <div class="p-6">
                    <div class="mb-6">
                        <h2 class="text-xl font-bold text-white tracking-tight flex items-center gap-2">
                            <svg class="h-5 w-5 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                            Request Config
                        </h2>
                    </div>

                    <form id="playground-form" class="space-y-5">
                        <!-- Endpoint Selection -->
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Endpoint</label>
                            <select id="endpoint-select" class="w-full rounded-xl border border-white/10 bg-slate-900 px-4 py-3 text-sm font-medium text-white appearance-none focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500">
                                <optgroup label="Core API (Uses x-api-key)" class="bg-slate-900 text-slate-400">
                                    <option value="POST|/api/v1/scrape" class="bg-slate-900 text-white">POST /api/v1/scrape</option>
                                </optgroup>
                                <optgroup label="Account / Data (Uses Session Auth)" class="bg-slate-900 text-slate-400">
                                    <option value="GET|/api/v1/user" class="bg-slate-900 text-white">GET /api/v1/user</option>
                                    <option value="GET|/api/v1/api-keys" class="bg-slate-900 text-white">GET /api/v1/api-keys</option>
                                    <option value="GET|/api/v1/dashboard/stats" class="bg-slate-900 text-white">GET /api/v1/dashboard/stats</option>
                                    <option value="GET|/api/v1/dashboard/recent-requests" class="bg-slate-900 text-white">GET /api/v1/dashboard/recent-requests</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- API Key Dropdown -->
                        <div id="api-key-container" class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Plaintext API Key (x-api-key)</label>
                            <input type="password" id="api-key-input" placeholder="Paste your generated sk_ key here..." class="w-full rounded-xl border border-white/10 bg-[#0f172a] px-4 py-3 text-sm font-mono text-white placeholder-slate-600 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500">
                            <p class="text-[11px] text-slate-500">You must provide the plain text secret key you copied during generation. <span class="text-xs text-slate-400">Hints: @foreach($apiKeys as $ak) {{ $ak->name }} (sk_••••_{{ $ak->key_last4 }}) @if(!$loop->last) - @endif @endforeach</span></p>
                        </div>

                        <!-- JSON Body -->
                        <div id="json-body-container" class="space-y-2">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">Request Body (JSON)</label>
                                <button type="button" id="format-json-btn" class="text-[10px] font-bold text-purple-400 hover:text-purple-300">Format JSON</button>
                            </div>
                            <textarea id="json-body-input" rows="4" class="w-full rounded-xl border border-white/10 bg-[#0f172a] p-4 text-xs font-mono text-blue-300 placeholder-slate-600 focus:border-purple-500 focus:outline-none focus:ring-1 focus:ring-purple-500" placeholder='{&#10;  "url": "https://example.com"&#10;}'></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" id="send-btn" class="group relative w-full flex items-center justify-center gap-2 rounded-xl bg-purple-600 px-6 py-3.5 text-sm font-bold text-white transition-all hover:bg-purple-500 hover:shadow-[0_0_20px_rgba(168,85,247,0.4)] active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none">
                                <span>Send Request</span>
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                                
                                <div id="btn-spinner" class="absolute right-4 hidden">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Glow Effect -->
                <div class="absolute -z-10 -right-20 -bottom-20 h-64 w-64 rounded-full bg-purple-600/10 blur-[80px]"></div>
            </div>

            <!-- Response Panel -->
            <div class="rounded-[24px] border border-white/5 bg-[#020617] p-1 shadow-2xl flex flex-col h-full lg:min-h-[500px]">
                <div class="flex-1 flex flex-col p-6">
                    <div class="mb-4 flex items-center justify-between border-b border-white/5 pb-4">
                        <h2 class="text-xl font-bold text-white tracking-tight">Response Viewer</h2>
                        
                        <div class="flex items-center gap-3 text-sm font-bold opacity-0 transition-opacity" id="response-meta">
                            <span id="response-status" class="rounded bg-white/10 px-2 py-1">200 OK</span>
                            <span id="response-time" class="text-slate-400">120ms</span>
                        </div>
                    </div>

                    <div class=" flex-1 bg-[#0f172a] rounded-xl border border-white/5 overflow-hidden group min-h-[300px]">
                        <!-- Empty State -->
                        <div id="response-empty" class="absolute inset-0 flex flex-col items-center justify-center text-slate-500">
                            <svg class="mb-3 h-10 w-10 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <p class="text-sm font-medium">Hit Send to execute</p>
                        </div>

                        <!-- JSON Output -->
                        <div class="absolute inset-0 overflow-auto">
                            <pre id="response-output" class="hidden p-4 text-xs font-mono text-emerald-300 whitespace-pre-wrap leading-relaxed select-all m-0"></pre>
                        </div>
                        
                        <button type="button" id="copy-response-btn" class="hidden absolute top-2 right-2 rounded-lg bg-white/10 p-2 text-slate-300 hover:bg-white/20 hover:text-white transition-colors opacity-0 group-hover:opacity-100" title="Copy to clipboard">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('endpoint-select');
            const apiKeyContainer = document.getElementById('api-key-container');
            const jsonBodyContainer = document.getElementById('json-body-container');
            const jsonBodyInput = document.getElementById('json-body-input');
            const form = document.getElementById('playground-form');
            const formatBtn = document.getElementById('format-json-btn');
            
            const btn = document.getElementById('send-btn');
            const btnText = btn.querySelector('span');
            const btnSpinner = document.getElementById('btn-spinner');
            
            const responseMeta = document.getElementById('response-meta');
            const responseStatus = document.getElementById('response-status');
            const responseTime = document.getElementById('response-time');
            const responseEmpty = document.getElementById('response-empty');
            const responseOutput = document.getElementById('response-output');
            const copyBtn = document.getElementById('copy-response-btn');

            // Setup default JSON bodies for hints
            const defaultBodies = {
                'POST|/api/v1/scrape': '{\n  "url": "https://example.com"\n}'
            };

            // Input UI toggle logic
            const syncUI = () => {
                const [method, url] = select.value.split('|');
                
                // Show API Key strictly for public scrape endpoint
                if (url === '/api/v1/scrape') {
                    apiKeyContainer.classList.remove('hidden');
                } else {
                    apiKeyContainer.classList.add('hidden');
                }
                
                // Show JSON body for POST/PATCH
                if (['POST', 'PATCH', 'PUT'].includes(method)) {
                    jsonBodyContainer.classList.remove('hidden');
                    if (jsonBodyInput.value.trim() === '' && defaultBodies[select.value]) {
                        jsonBodyInput.value = defaultBodies[select.value];
                    }
                } else {
                    jsonBodyContainer.classList.add('hidden');
                }
            };

            select.addEventListener('change', syncUI);
            syncUI(); // Init

            // JSON formatter helper
            formatBtn.addEventListener('click', () => {
                try {
                    const parsed = JSON.parse(jsonBodyInput.value);
                    jsonBodyInput.value = JSON.stringify(parsed, null, 2);
                    jsonBodyInput.classList.remove('ring-rose-500');
                } catch (e) {
                    jsonBodyInput.classList.add('ring-rose-500');
                }
            });

            // Copy helper
            copyBtn.addEventListener('click', () => {
                navigator.clipboard.writeText(responseOutput.textContent);
                copyBtn.innerHTML = '<svg class="h-4 w-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
                setTimeout(() => {
                    copyBtn.innerHTML = '<svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>';
                }, 2000);
            });

            // Submission Logic
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const [method, url] = select.value.split('|');
                
                // UI Loading state
                btn.disabled = true;
                btnText.textContent = 'Sending...';
                btnSpinner.classList.remove('hidden');
                responseEmpty.classList.add('hidden');
                responseOutput.classList.add('hidden');
                copyBtn.classList.add('hidden');
                responseMeta.style.opacity = '0';
                
                const headers = {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                };

                // Add API Key specifically for /scrape
                if (url === '/api/v1/scrape') {
                    const apiKey = document.getElementById('api-key-input').value.trim();
                    if (apiKey) {
                        headers['x-api-key'] = apiKey;
                    }
                } else {
                    // For Web/Sanctum routes requested via browser, fetch sends cookies automatically,
                    // but we need to pass X-XSRF-TOKEN to prevent CSRF errors for state-modifying requests.
                    const tokenParts = document.cookie.split('; ').find(row => row.startsWith('XSRF-TOKEN='));
                    if (tokenParts) {
                        headers['X-XSRF-TOKEN'] = decodeURIComponent(tokenParts.split('=')[1]);
                    }
                }

                const options = {
                    method,
                    headers,
                };

                if (['POST', 'PATCH', 'PUT'].includes(method)) {
                    // Quick validation
                    try {
                        options.body = JSON.stringify(JSON.parse(jsonBodyInput.value || '{}'));
                    } catch (err) {
                        alert('Invalid Request Body JSON');
                        btn.disabled = false;
                        btnText.textContent = 'Send Request';
                        btnSpinner.classList.add('hidden');
                        responseEmpty.classList.remove('hidden');
                        return;
                    }
                }

                const startTime = performance.now();
                
                try {
                    const response = await fetch(url, options);
                    const endTime = performance.now();
                    const ms = Math.round(endTime - startTime);

                    // Parse output
                    const text = await response.text();
                    let payloadDisplay;
                    try {
                        const json = JSON.parse(text);
                        payloadDisplay = JSON.stringify(json, null, 2);
                    } catch (e) {
                        payloadDisplay = text; // Fallback to HTML/Text
                    }

                    // Status pill styling
                    const isSuccess = response.ok; // 2xx
                    responseStatus.className = `rounded px-2 py-1 ${isSuccess ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400'}`;
                    responseStatus.textContent = `${response.status} ${response.statusText}`;
                    responseTime.textContent = `${ms}ms`;

                    // Output Box styling
                    responseOutput.className = `absolute inset-0 p-4 text-xs font-mono overflow-auto whitespace-pre-wrap leading-relaxed select-all ${isSuccess ? 'text-emerald-300' : 'text-rose-300'}`;
                    responseOutput.textContent = payloadDisplay;
                    
                    responseOutput.classList.remove('hidden');
                    copyBtn.classList.remove('hidden');
                    responseMeta.style.opacity = '1';

                } catch (error) {
                    console.error("Fetch error", error);
                    responseStatus.className = `rounded px-2 py-1 bg-red-500/20 text-red-500`;
                    responseStatus.textContent = `Network Error`;
                    responseTime.textContent = `-`;
                    
                    responseOutput.className = `absolute inset-0 p-4 text-xs font-mono text-rose-500 overflow-auto whitespace-pre-wrap leading-relaxed select-all`;
                    responseOutput.textContent = error.toString();
                    
                    responseOutput.classList.remove('hidden');
                    responseMeta.style.opacity = '1';
                } finally {
                    btn.disabled = false;
                    btnText.textContent = 'Send Request';
                    btnSpinner.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
