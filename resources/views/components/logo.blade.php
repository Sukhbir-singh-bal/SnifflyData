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
        <svg viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Background Circle -->
            <circle cx="256" cy="256" r="240" fill="white"/>
            
            <!-- Main Logo Body: Stylized Hound/Snout Shape -->
            <path d="M140 180C140 130 180 100 256 100C332 100 372 130 372 180V320C372 380 320 420 256 420C192 420 140 380 140 320V180Z" fill="url(#grad1)" />
            
            <!-- The "Nose" / Data Hub -->
            <rect x="216" y="310" width="80" height="50" rx="25" fill="#1E293B" />
            
            <!-- Data Connection Lines (The Sniffing Action) -->
            <g stroke="#38BDF8" stroke-width="8" stroke-linecap="round">
                <!-- Left Connection -->
                <path d="M180 200L120 160" />
                <circle cx="110" cy="155" r="10" fill="#38BDF8" />
                
                <!-- Right Connection -->
                <path d="M332 200L392 160" />
                <circle cx="402" cy="155" r="10" fill="#38BDF8" />
                
                <!-- Middle Top Connection -->
                <path d="M256 100V60" />
                <circle cx="256" cy="50" r="10" fill="#38BDF8" />
            </g>
            
            <!-- Inner Data Nodes -->
            <circle cx="256" cy="220" r="15" fill="#FFFFFF" opacity="0.8" />
            <circle cx="210" cy="250" r="10" fill="#FFFFFF" opacity="0.6" />
            <circle cx="302" cy="250" r="10" fill="#FFFFFF" opacity="0.6" />
            
            <defs>
                <linearGradient id="grad1" x1="140" y1="100" x2="372" y2="420" gradientUnits="userSpaceOnUse">
                    <stop stop-color="#0EA5E9"/>
                    <stop offset="1" stop-color="#2563EB"/>
                </linearGradient>
            </defs>
        </svg>
    </div>
    <span class="{{ $s['text'] }} font-extrabold tracking-tight text-slate-900 dark:text-white">
        Sniffly<span class="text-blue-600 dark:text-blue-400">Data</span>
    </span>
</a>
