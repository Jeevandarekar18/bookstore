@php $page = 'auth'; @endphp
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-[30px] border border-white/10 bg-slate-900/80 p-6 shadow-2xl">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Join the bookstore</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Create account</h1>
            <p class="mt-2 text-sm text-slate-300">Register to save your cart, track orders, and access your profile.</p>
        </div>
        <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Fast setup</div>
    </div>

    <form id="register-form" class="mt-6 space-y-4">
        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Name</span>
            <input id="register-name" type="text" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="Jordan Smith">
        </label>

        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Email address</span>
            <input id="register-email" type="email" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="you@example.com">
        </label>

        <div class="grid gap-4 md:grid-cols-2">
            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Password</span>
                <input id="register-password" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="••••••••">
            </label>

            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Confirm password</span>
                <input id="register-password-confirmation" type="password" required class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="••••••••">
            </label>
        </div>

        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Phone</span>
            <input id="register-phone" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="(555) 123-4567">
        </label>

        <label class="block text-sm text-slate-300">
            <span class="mb-2 block">Address</span>
            <textarea id="register-address" rows="3" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400" placeholder="Street, city, and ZIP"></textarea>
        </label>

        <button type="submit" class="w-full rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950">Create account</button>
    </form>

    <p class="mt-4 text-center text-sm text-slate-300">Already have an account? <a href="/login" class="font-semibold text-cyan-200">Sign in</a>.</p>
</div>
@endsection
