@extends('layouts.dashboard')

@section('content')
    <div class="space-y-8">
        
        @if ($status)
            <div class="flex items-center gap-3 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-6 py-4 text-sm font-medium text-emerald-400 backdrop-blur-md">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                {{ $status }}
            </div>
        @endif

        @if ($newApiKey)
            <div class="relative overflow-hidden rounded-[24px] border border-blue-500/30 bg-blue-600/10 p-6 backdrop-blur-xl">
                <div class="relative z-10">
                    <div class="flex items-center gap-2 text-blue-400">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                        <p class="text-sm font-bold uppercase tracking-wider">Secret Key Generated</p>
                    </div>
                    <p class="mt-2 text-sm text-slate-300">Copy this key now. For your security, we won't show it again.</p>
                    
                    <div class="mt-4 flex items-center gap-2 rounded-xl bg-[#020617] border border-white/10 p-1 pl-4">
                        <code class="flex-1 font-mono text-sm text-blue-400 break-all select-all">{{ $newApiKey }}</code>
                        <button onclick="navigator.clipboard.writeText('{{ $newApiKey }}')" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-bold text-white hover:bg-blue-500 transition-all">
                            Copy
                        </button>
                    </div>
                </div>
                <div class="absolute -right-10 -top-10 h-32 w-32 bg-blue-600/20 blur-3xl"></div>
            </div>
        @endif

        <div class="rounded-[32px] border border-white/5 bg-white/[0.02] p-1 backdrop-blur-sm">
            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">API Keys</h2>
                        <p class="mt-1 text-sm text-slate-500">Manage your production and development access tokens.</p>
                    </div>
                    <form method="POST" action="{{ route('dashboard.api-keys.generate') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                        @csrf
                        <div>
                            <input type="text" name="name" placeholder="Key Name (e.g., Production)" required maxlength="255" value="{{ old('name') }}" class="w-full sm:w-64 rounded-xl border border-white/10 bg-white/5 px-4 py-2.5 text-sm font-medium text-white placeholder-slate-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors">
                            @error('name')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="group flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-bold text-white transition-all hover:bg-blue-500 hover:shadow-[0_0_20px_rgba(37,99,235,0.3)] active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-4 w-4">
                                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                            </svg>
                            Generate Key
                        </button>
                    </form>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-white/5 bg-white/[0.01]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/[0.02] text-[11px] font-bold uppercase tracking-[0.15em] text-slate-500">
                                    <th class="px-6 py-4">Key Name</th>
                                    <th class="px-6 py-4">Secret Hint</th>
                                    <th class="px-6 py-4">Monthly Usage</th>
                                    <th class="px-6 py-4">Created</th>
                                    <th class="px-6 py-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                @forelse ($apiKeys as $key)
                                    <tr class="group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-5 font-semibold text-white">{{ $key->name }}</td>
                                        <td class="px-6 py-5">
                                            <span class="rounded-lg bg-white/5 px-2 py-1 font-mono text-xs text-slate-400">
                                                sk_••••_{{ $key->key_last4 }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex w-full max-w-[120px] flex-col gap-1.5">
                                                <div class="flex justify-between text-[10px] font-bold text-slate-500">
                                                    <span>{{ number_format(($key->usage_count / $key->usage_limit) * 100, 1) }}%</span>
                                                    <span>{{ number_format($key->usage_count) }}</span>
                                                </div>
                                                <div class="h-1.5 w-full rounded-full bg-white/10">
                                                    <div class="h-full rounded-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.5)]" style="width: {{ ($key->usage_count / $key->usage_limit) * 100 }}%"></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 text-slate-500 font-medium">{{ $key->created_at?->format('M d, Y') }}</td>
                                        <td class="px-6 py-5 text-right">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-bold text-emerald-500 ring-1 ring-inset ring-emerald-500/20">
                                                Active
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="rounded-full bg-white/5 p-3 mb-3">
                                                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                                    </svg>
                                                </div>
                                                <p class="text-slate-500 font-medium">No API keys found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection