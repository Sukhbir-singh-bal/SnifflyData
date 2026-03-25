@extends('layouts.app')

@section('content')
<div class="relative flex min-h-screen w-full items-center justify-center bg-[#020617] px-6 py-12 overflow-hidden">
    
    <div class="absolute top-1/3 right-1/4 h-[450px] w-[450px] rounded-full bg-blue-600/10 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 h-[300px] w-[300px] rounded-full bg-indigo-500/5 blur-[100px]"></div>

    <div class="relative w-full max-w-[480px] mt-12">
        
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-extrabold tracking-tight text-white italic">Sniffly<span class="text-blue-500">Data</span></h1>
            <p class="mt-3 text-slate-400">Join the team. Get your API keys in seconds.</p>
        </div>

        <div class="relative rounded-[32px] border border-white/10 bg-white/[0.03] p-8 backdrop-blur-xl shadow-2xl sm:p-10">
            
            @if ($errors->any())
                <div class="mb-6 rounded-2xl bg-rose-500/10 p-4 text-[13px] text-rose-400 ring-1 ring-rose-500/20">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-start gap-2">
                                <span class="mt-1.5 h-1 w-1 shrink-0 rounded-full bg-rose-500"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="name" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Full Name</label>
                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="block w-full rounded-2xl border-0 bg-white/[0.05] py-3.5 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                        placeholder="John Doe"
                    >
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Email Address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        class="block w-full rounded-2xl border-0 bg-white/[0.05] py-3.5 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                        placeholder="name@company.com"
                    >
                </div>

                <div class="grid grid-cols-1 gap-5">
                    <div class="space-y-2">
                        <label for="password" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Password</label>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="block w-full rounded-2xl border-0 bg-white/[0.05] py-3.5 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-xs font-bold uppercase tracking-widest text-slate-500 ml-1">Confirm</label>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="block w-full rounded-2xl border-0 bg-white/[0.05] py-3.5 px-5 text-white shadow-sm ring-1 ring-inset ring-white/10 placeholder:text-slate-600 focus:bg-white/[0.08] focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-all outline-none"
                            placeholder="••••••••"
                        >
                    </div>
                </div>
                <button
                    type="submit"
                    class="group relative mt-2 flex w-full items-center justify-center overflow-hidden rounded-2xl bg-blue-600 px-4 py-4 text-sm font-bold text-white transition-all hover:bg-blue-500 hover:shadow-[0_0_25px_rgba(37,99,235,0.4)] active:scale-[0.98]"
                >
                    <span class="relative z-10 flex items-center">
                        Create My Account
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1">
                            <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-slate-500">
                    Already a member? 
                    <a href="{{ route('login') }}" class="ml-1 font-bold text-white hover:text-blue-400 transition-colors">Sign in here</a>
                </p>
            </div>
        </div>

        <p class="mt-8 text-center text-[11px] leading-relaxed text-slate-600">
            By clicking "Create My Account", you agree to our <br>
            <a href="#" class="text-slate-500 underline underline-offset-4 hover:text-blue-400 transition-colors">Terms of Service</a> and 
            <a href="#" class="text-slate-500 underline underline-offset-4 hover:text-blue-400 transition-colors">Privacy Policy</a>.
        </p>
    </div>
</div>
@endsection