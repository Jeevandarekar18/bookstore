@php $page = 'auth'; @endphp
@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-2xl rounded-2xl border border-stone-200/80 bg-white p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Access your account</p>
            <h1 class="mt-2 text-3xl font-bold text-stone-900">Sign in</h1>
            <p class="mt-2 text-sm text-stone-600">Use your email and password to continue shopping and manage orders.</p>
        </div>
        <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Secure</div>
    </div>

    <form id="login-form" class="mt-6 space-y-4">
        <label class="block text-sm text-stone-600">
            <span class="mb-2 block">Email address</span>
            <input id="login-email" type="email" required class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500" placeholder="you@example.com">
        </label>

        <label class="block text-sm text-stone-600">
            <span class="mb-2 block">Password</span>
            <input id="login-password" type="password" required class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500" placeholder="••••••••">
        </label>

        <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Sign in</button>
    </form>

    <p class="mt-4 text-center text-sm text-stone-600">Need an account? <a href="/register" class="font-semibold text-blue-700">Create one</a>.</p>
</div>
@endsection
