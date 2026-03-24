{{-- resources/views/components/trusted-by.blade.php --}}
<section class="py-14 border-y border-slate-100 dark:border-slate-800/60 bg-slate-50/50 dark:bg-[#0a0f1a]/50 transition-colors">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-center text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400 dark:text-slate-600 mb-10">Powering data teams at scale</p>

        <div class="flex flex-wrap justify-center items-center gap-10 md:gap-16">
            @foreach([
                ['name' => 'DATAFLOW', 'style' => 'font-black italic tracking-tighter', 'accent' => 'text-blue-500'],
                ['name' => 'NexuS',    'style' => 'font-black tracking-widest uppercase', 'accent' => ''],
                ['name' => 'quant.io', 'style' => 'font-black lowercase',               'accent' => ''],
                ['name' => 'CloudExtract', 'style' => 'font-black tracking-tight',      'accent' => 'text-blue-500'],
                ['name' => 'AXIOM',    'style' => 'font-black tracking-[0.3em]',        'accent' => ''],
            ] as $brand)
            <span class="text-xl {{ $brand['style'] }} text-slate-300 dark:text-slate-600 hover:text-slate-600 dark:hover:text-slate-300 transition-colors duration-300 cursor-default">
                {{ $brand['name'] }}
            </span>
            @endforeach
        </div>
    </div>
</section>
