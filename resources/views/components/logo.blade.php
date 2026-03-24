{{-- resources/views/components/logo.blade.php --}}
@props(['size' => 'md'])

@php
$sizes = [
    'sm' => ['icon' => 'w-7 h-7', 'text' => 'text-base'],
    'md' => ['icon' => 'w-9 h-9', 'text' => 'text-xl'],
    'lg' => ['icon' => 'w-12 h-12', 'text' => 'text-2xl'],
];
$s = $sizes[$size] ?? $sizes['md'];
@endphp

<a href="{{ url('/') }}" class="flex items-center gap-2.5 group" aria-label="SnifflyData Home">
    <div class="{{ $s['icon'] }} bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-600/30 group-hover:shadow-blue-500/50 group-hover:scale-105 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-1/2 h-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    <span class="{{ $s['text'] }} font-extrabold tracking-tight text-slate-900 dark:text-white">
        Sniffly<span class="text-blue-600 dark:text-blue-400">Data</span>
    </span>
</a>
