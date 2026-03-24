@extends('layouts.app')

@section('content')
    <div class="relative mx-auto flex min-h-[78vh] w-full max-w-md items-center justify-center">
        <div class="pointer-events-none absolute -top-8 left-1/2 h-44 w-44 -translate-x-1/2 rounded-full bg-indigo-200/50 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-12 right-0 h-40 w-40 rounded-full bg-cyan-200/40 blur-3xl"></div>

        <div class="relative w-full rounded-3xl border border-white/60 bg-white/70 p-6 shadow-[0_10px_40px_rgba(15,23,42,0.08)] backdrop-blur-xl sm:p-8">
            <div class="mb-6 text-center">
                <p class="text-xs font-medium uppercase tracking-[0.16em] text-slate-500">ScrapeFlow</p>
                <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Welcome back</h1>
                <p class="mt-2 text-sm text-slate-600">Sign in to continue managing your scraping API.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-rose-200/80 bg-rose-50/90 p-3 text-sm text-rose-700">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        class="w-full rounded-xl border border-white/70 bg-white/80 px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 outline-none ring-0 transition focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-200"
                        placeholder="you@company.com"
                    >
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-white/70 bg-white/80 px-3 py-2.5 text-sm text-slate-900 placeholder-slate-400 outline-none ring-0 transition focus:border-slate-300 focus:bg-white focus:ring-2 focus:ring-slate-200"
                        placeholder="••••••••"
                    >
                </div>

                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-300">
                    <span class="text-sm text-slate-600">Remember me</span>
                </label>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-700"
                >
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                New to ScrapeFlow?
                <a href="{{ route('register') }}" class="font-medium text-slate-900 underline underline-offset-4 hover:text-slate-700">
                    Create an account
                </a>
            </p>
        </div>
    </div>
@endsection
