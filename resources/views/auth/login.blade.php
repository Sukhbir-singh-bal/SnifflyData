@extends('layouts.app')

@section('content')
<div class="relative flex min-h-screen w-full items-center justify-center bg-[#020617] px-6 py-12 overflow-hidden">
    
    <div class="absolute top-1/2 left-1/2 h-[500px] w-[500px] -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-600/10 blur-[120px]"></div>

    <div class="relative w-full max-w-[440px] mt-12">
        
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-white italic">Sniffly<span class="text-blue-500">Data</span></h1>
            <p class="mt-3 text-slate-400">Enter your credentials to access the console.</p>
        </div>

        <div class="relative rounded-[32px] border border-white/10 bg-white/[0.03] p-8 backdrop-blur-xl shadow-2xl sm:p-10">
            
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-500/10 p-4 text-sm text-rose-400 ring-1 ring-rose-500/20">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center gap-2">
                                <span class="h-1.5 w-1.5 rounded-full bg-rose-500"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        class="block w-full rounded-2xl border-0 bg-white/[0.05] py-4 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                        placeholder="name@company.com"
                    >
                </div>

                <div class="space-y-2">
                    <div class="flex items-center justify-between px-1">
                        <label for="password" class="text-xs font-bold uppercase tracking-widest text-slate-500">Password</label>
                        <a href="#" class="text-xs font-semibold text-blue-500 hover:text-blue-400 transition-colors">Forgot?</a>
                    </div>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="block w-full rounded-2xl border-0 bg-white/[0.05] py-4 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center px-1">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-500 focus:ring-offset-0">
                    <label for="remember" class="ml-3 text-sm text-slate-400">Keep me logged in</label>
                </div>

                <button
                    type="submit"
                    class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl bg-blue-600 px-4 py-4 text-sm font-bold text-white transition-all hover:bg-blue-500 hover:shadow-[0_0_25px_rgba(37,99,235,0.4)] active:scale-[0.98]"
                >
                    <span class="relative z-10 flex items-center">
                        Sign In to Dashboard
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    New to ScrapeFlow? 
                    <a href="{{ route('register') }}" class="ml-1 font-bold text-white hover:text-blue-400 transition-colors">Create account</a>
                </p>
            </div>
        </div>

        <div class="mt-12 flex justify-center space-x-6 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-600">
            <a href="#" class="hover:text-slate-400 transition-colors">System Status</a>
            <a href="#" class="hover:text-slate-400 transition-colors">Privacy</a>
            <a href="#" class="hover:text-slate-400 transition-colors">Terms</a>
        </div>
    </div>
</div>
@endsection