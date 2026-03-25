@extends('layouts.dashboard', ['header' => 'Scrape Requests'])

@section('content')
    <div class="space-y-8">
        <div class="rounded-[32px] border border-white/5 bg-white/[0.02] p-1 backdrop-blur-sm">
            <div class="p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white tracking-tight">Requests History</h2>
                        <p class="mt-1 text-sm text-slate-500">View your recent API scrape requests and their status.</p>
                    </div>
                    
                    <div class="flex gap-2 p-1 rounded-xl border border-white/5 bg-[#020617]">
                        <a href="{{ route('dashboard.requests') }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ !$currentStatus ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/25' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            All
                        </a>
                        <a href="{{ route('dashboard.requests', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/25' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            Pending
                        </a>
                        <a href="{{ route('dashboard.requests', ['status' => 'success']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'success' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/25' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            Success
                        </a>
                        <a href="{{ route('dashboard.requests', ['status' => 'failed']) }}" class="px-4 py-2 rounded-lg text-sm font-bold transition-all {{ $currentStatus === 'failed' ? 'bg-rose-500 text-white shadow-lg shadow-rose-500/25' : 'text-slate-400 hover:text-white hover:bg-white/5' }}">
                            Failed
                        </a>
                    </div>
                </div>

                <div class="mt-8 overflow-hidden rounded-2xl border border-white/5 bg-white/[0.01]">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 bg-white/[0.02] text-[11px] font-bold uppercase tracking-[0.15em] text-slate-500">
                                    <th class="px-6 py-4">URL</th>
                                    <th class="px-6 py-4">API Key</th>
                                    <th class="px-6 py-4">Credits</th>
                                    <th class="px-6 py-4">Time</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4 text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-white/5 text-slate-300">
                                @forelse ($requests as $req)
                                    <tr id="request-row-{{ $req->id }}" data-request-id="{{ $req->id }}" data-status="{{ $req->status }}" class="group hover:bg-white/[0.02] transition-colors">
                                        <td class="px-6 py-5 font-semibold text-white truncate max-w-[200px]" title="{{ $req->url }}">{{ $req->url }}</td>
                                        <td class="px-6 py-5">
                                            <span class="rounded-lg bg-white/5 px-2 py-1 font-mono text-xs text-slate-400">
                                                sk_••••_{{ $req->apiKey->key_last4 ?? 'DELETED' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 font-medium credits-cell">{{ $req->credits_used }}</td>
                                        <td class="px-6 py-5 font-medium time-cell">{{ $req->response_time ? $req->response_time . 'ms' : '-' }}</td>
                                        <td class="px-6 py-5 text-slate-500 font-medium">{{ $req->created_at?->format('M d, Y H:i:s') }}</td>
                                        <td class="px-6 py-5 text-right status-cell">
                                            @if($req->status === 'success')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-bold text-emerald-500 ring-1 ring-inset ring-emerald-500/20">
                                                    Success
                                                </span>
                                            @elseif($req->status === 'pending')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-500/10 px-2.5 py-1 text-xs font-bold text-amber-500 ring-1 ring-inset ring-amber-500/20">
                                                    <span class="relative flex h-1.5 w-1.5">
                                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                                                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-amber-500"></span>
                                                    </span>
                                                    Pending
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/10 px-2.5 py-1 text-xs font-bold text-rose-500 ring-1 ring-inset ring-rose-500/20">
                                                    Failed
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div class="rounded-full bg-white/5 p-3 mb-3">
                                                    <svg class="h-6 w-6 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                </div>
                                                <p class="text-slate-500 font-medium">No requests found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-6">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const pendingRows = document.querySelectorAll('tr[data-status="pending"]');
            
            if (pendingRows.length === 0) return;

            const pollInterval = setInterval(() => {
                let allCompleted = true;

                pendingRows.forEach(async (row) => {
                    if (row.dataset.status !== 'pending') return;
                    allCompleted = false;

                    try {
                        const id = row.dataset.requestId;
                        const response = await fetch(`/dashboard/requests/${id}/status`);
                        if (!response.ok) return;

                        const data = await response.json();
                        
                        if (data.status !== 'pending') {
                            row.dataset.status = data.status;
                            row.querySelector('.credits-cell').textContent = data.credits_used;
                            row.querySelector('.time-cell').textContent = data.response_time;
                            
                            const statusCell = row.querySelector('.status-cell');
                            if (data.status === 'success') {
                                statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-500/10 px-2.5 py-1 text-xs font-bold text-emerald-500 ring-1 ring-inset ring-emerald-500/20">Success</span>`;
                            } else {
                                statusCell.innerHTML = `<span class="inline-flex items-center gap-1.5 rounded-full bg-rose-500/10 px-2.5 py-1 text-xs font-bold text-rose-500 ring-1 ring-inset ring-rose-500/20">Failed</span>`;
                            }
                        }
                    } catch (error) {
                        console.error('Error polling request status:', error);
                    }
                });

                if (allCompleted) {
                    clearInterval(pollInterval);
                }
            }, 3000); // Poll every 3 seconds
        });
    </script>
@endsection
