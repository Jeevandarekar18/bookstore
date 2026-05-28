@php $page = 'auth'; @endphp
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-[30px] border border-white/10 bg-slate-900/80 p-6 shadow-2xl">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Access your account</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Sign in</h1>
            <p class="mt-2 text-sm text-slate-300">Use your email and password to continue shopping and manage orders.</p>
        </div>
        <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Secure</div>
    </div>

    <form id="login-form" class="mt-6 space-y-4">
        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Email address</span>
            <input id="login-email" type="email" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="you@example.com">
        </label>

        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Password</span>
            <input id="login-password" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="••••••••">
        </label>

        <button type="submit" class="w-full rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950">Sign in</button>
    </form>

    <p class="mt-4 text-center text-sm text-slate-300">Need an account? <a href="/register" class="font-semibold text-cyan-200">Create one</a>.</p>
</div>
@endsection
