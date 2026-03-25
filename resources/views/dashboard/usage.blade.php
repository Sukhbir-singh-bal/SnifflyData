@extends('layouts.dashboard', ['header' => 'Usage & Statistics'])

@section('content')
    <div class="space-y-8">
        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Requests -->
            <div class="relative overflow-hidden rounded-[24px] border border-white/5 bg-white/[0.02] p-6 backdrop-blur-sm group hover:bg-white/[0.04] transition-all">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 text-blue-400 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 ring-1 ring-blue-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h3 class="font-bold tracking-wide">Total Requests</h3>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-white tracking-tight">{{ number_format($totalRequests) }}</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500 font-medium">Lifetime API calls made</p>
                </div>
                <div class="absolute -right-8 -top-8 h-32 w-32 bg-blue-500/10 blur-3xl transition-all group-hover:bg-blue-500/20"></div>
            </div>

            <!-- Credits Used -->
            <div class="relative overflow-hidden rounded-[24px] border border-white/5 bg-white/[0.02] p-6 backdrop-blur-sm group hover:bg-white/[0.04] transition-all">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 text-emerald-400 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 ring-1 ring-emerald-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="font-bold tracking-wide">Credits Used</h3>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-white tracking-tight">{{ number_format($totalCredits) }}</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500 font-medium">Total computation credits spent</p>
                </div>
                <div class="absolute -right-8 -top-8 h-32 w-32 bg-emerald-500/10 blur-3xl transition-all group-hover:bg-emerald-500/20"></div>
            </div>

            <!-- Avg Response Time -->
            <div class="relative overflow-hidden rounded-[24px] border border-white/5 bg-white/[0.02] p-6 backdrop-blur-sm group hover:bg-white/[0.04] transition-all">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 text-purple-400 mb-4">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-500/10 ring-1 ring-purple-500/20">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="font-bold tracking-wide">Avg Processing Time</h3>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-extrabold text-white tracking-tight">{{ number_format($avgResponseTime) }}<span class="text-xl text-slate-400 font-bold ml-1">ms</span></span>
                    </div>
                    <p class="mt-2 text-sm text-slate-500 font-medium">Average time for successful scrapes</p>
                </div>
                <div class="absolute -right-8 -top-8 h-32 w-32 bg-purple-500/10 blur-3xl transition-all group-hover:bg-purple-500/20"></div>
            </div>
        </div>

        <!-- API Keys Breakdown -->
        <div class="rounded-[32px] border border-white/5 bg-white/[0.02] p-1 backdrop-blur-sm">
            <div class="p-6 sm:p-8">
                <div>
                    <h2 class="text-2xl font-bold text-white tracking-tight">Usage by API Key</h2>
                    <p class="mt-1 text-sm text-slate-500">Breakdown of requests and limits for each of your active keys.</p>
                </div>

                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($apiKeys as $key)
                        <div class="rounded-2xl border border-white/5 bg-[#020617] p-5 shadow-lg">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h4 class="font-bold text-white">{{ $key->name }}</h4>
                                    <code class="text-xs text-slate-500 font-mono mt-1 block">sk_••••_{{ $key->key_last4 }}</code>
                                </div>
                                <span class="px-2 py-1 rounded bg-white/5 text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                    {{ $key->requests_count }} reqs
                                </span>
                            </div>
                            
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs font-bold text-slate-400">
                                    <span>Usage Limit</span>
                                    <span class="{{ $key->usage_count >= $key->usage_limit ? 'text-rose-400' : 'text-slate-300' }}">
                                        {{ number_format($key->usage_count) }} / {{ number_format($key->usage_limit) }}
                                    </span>
                                </div>
                                @php
                                    $percent = min(100, ($key->usage_count / max(1, $key->usage_limit)) * 100);
                                    $colorClass = $percent > 90 ? 'bg-rose-500 shadow-rose-500/50' : ($percent > 75 ? 'bg-amber-500 shadow-amber-500/50' : 'bg-blue-500 shadow-blue-500/50');
                                @endphp
                                <div class="h-2 w-full rounded-full bg-white/10 overflow-hidden">
                                    <div class="h-full rounded-full shadow-[0_0_8px_currentColor] {{ $colorClass }}" style="width: {{ $percent }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-slate-500 font-medium">
                            No API keys found.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
