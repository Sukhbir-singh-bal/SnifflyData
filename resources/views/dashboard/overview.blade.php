@extends('layouts.dashboard', ['header' => 'Overview'])

@section('content')
    <div class="space-y-8">
        
        <!-- Welcome Banner -->
        <div class="relative overflow-hidden rounded-[32px] border border-blue-500/20 bg-gradient-to-r from-blue-600/10 to-indigo-600/10 p-8 sm:p-10 backdrop-blur-sm">
            <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold text-white tracking-tight mb-2">Welcome back, {{ auth()->user()->name }}!</h2>
                    <p class="text-blue-200/80 max-w-xl text-sm leading-relaxed">Here's a quick overview of your API usage and recent scrape requests. Manage your keys or view detailed analytics using the sidebar.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard.requests') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-6 py-3 text-sm font-bold text-white shadow-[0_0_20px_rgba(37,99,235,0.4)] transition-all hover:scale-105 hover:bg-blue-500 hover:shadow-[0_0_30px_rgba(37,99,235,0.6)]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        Start Scraping
                    </a>
                </div>
            </div>
            
            <!-- Decorative Elements -->
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-blue-500/20 blur-[80px]"></div>
            <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-indigo-500/20 blur-[80px]"></div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Keys -->
            <div class="group relative overflow-hidden rounded-2xl border border-white/5 bg-white/[0.02] p-5 backdrop-blur-sm transition-all hover:bg-white/[0.04] hover:border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/5 text-slate-400 group-hover:bg-slate-700/50 group-hover:text-white transition-colors">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" /></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Active API Keys</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($activeKeysCount) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Total Requests -->
            <div class="group relative overflow-hidden rounded-2xl border border-white/5 bg-white/[0.02] p-5 backdrop-blur-sm transition-all hover:bg-white/[0.04] hover:border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400 group-hover:bg-blue-500/20 transition-colors ring-1 ring-blue-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Scrape Requests</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($totalRequests) }}</h3>
                    </div>
                </div>
            </div>

            <!-- Credits Used -->
            <div class="group relative overflow-hidden rounded-2xl border border-white/5 bg-white/[0.02] p-5 backdrop-blur-sm transition-all hover:bg-white/[0.04] hover:border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400 group-hover:bg-emerald-500/20 transition-colors ring-1 ring-emerald-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Credits Used</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-bold text-white tracking-tight">{{ number_format($totalCredits) }}</h3>
                    </div>
                </div>
            </div>
            
            <!-- Status Health (mock) -->
            <div class="group relative overflow-hidden rounded-2xl border border-white/5 bg-white/[0.02] p-5 backdrop-blur-sm transition-all hover:bg-white/[0.04] hover:border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-500/10 text-purple-400 group-hover:bg-purple-500/20 transition-colors ring-1 ring-purple-500/20">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                </div>
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">System Status</p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-2xl font-bold text-white tracking-tight flex items-center gap-2">
                            <span class="relative flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                            </span>
                            Operational
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="rounded-[32px] border border-white/5 bg-white/[0.02] p-1 backdrop-blur-sm">
            <div class="p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-white tracking-tight">Recent Scrapes</h3>
                        <p class="text-sm text-slate-500">Your latest 5 API requests.</p>
                    </div>
                    <a href="{{ route('dashboard.requests') }}" class="text-sm font-bold text-blue-400 hover:text-blue-300 transition-colors flex items-center gap-1">
                        View All
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>

                <div class="overflow-hidden rounded-2xl border border-white/5 bg-white/[0.01]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/[0.02] text-[11px] font-bold uppercase tracking-[0.15em] text-slate-500">
                                    <th class="px-6 py-4">URL</th>
                                    <th class="px-6 py-4">Time</th>
                                    <th class="px-6 py-4">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                @forelse ($recentRequests as $req)
                                    <tr class="group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-4 font-semibold text-white truncate max-w-[200px]" title="{{ $req->url }}">{{ $req->url }}</td>
                                        <td class="px-6 py-4 text-slate-500">{{ $req->created_at?->diffForHumans() }}</td>
                                        <td class="px-6 py-4">
                                            @if($req->status === 'success')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-bold text-emerald-500 ring-1 ring-inset ring-emerald-500/20">Success</span>
                                            @elseif($req->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-2.5 py-1 text-xs font-bold text-amber-500 ring-1 ring-inset ring-amber-500/20">Pending</span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/10 px-2.5 py-1 text-xs font-bold text-rose-500 ring-1 ring-inset ring-rose-500/20">Failed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-8 text-center text-slate-500 font-medium">
                                            No recent requests found.
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
