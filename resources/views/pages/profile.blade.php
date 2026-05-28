@php $page = 'profile'; @endphp
@extends('layouts.app')

@section('content')
<div class="grid gap-6 xl:grid-cols-[0.9fr_1.1fr]">
    <section class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">My profile</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Profile settings</h1>
            </div>
            <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Personal</div>
        </div>

        <div class="mt-5 rounded-3xl border border-white/10 bg-slate-950/80 p-4">
            <p class="text-sm text-slate-400">Account summary</p>
            <p id="profile-summary-name" class="mt-3 text-2xl font-semibold text-white">Customer</p>
            <p id="profile-summary-email" class="mt-1 text-sm text-slate-300"></p>
            <div class="mt-4 flex items-center gap-2">
                <span id="profile-summary-role" class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-cyan-200">Customer</span>
            </div>
        </div>

        <form id="profile-form" class="mt-5 space-y-3">
            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Name</span>
                <input id="profile-name" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
            </label>
            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Email</span>
                <input id="profile-email" type="email" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
            </label>
            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Phone</span>
                <input id="profile-phone" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
            </label>
            <label class="block text-sm text-slate-300">
                <span class="mb-2 block">Address</span>
                <textarea id="profile-address" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400"></textarea>
            </label>

            <button type="submit" class="w-full rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950">Save profile</button>
        </form>
    </section>

    <section class="space-y-6">
        <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Update password</p>
                    <h2 class="mt-2 text-2xl font-bold text-white">Security</h2>
                </div>
            </div>

            <form id="password-form" class="mt-5 space-y-3">
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Current password</span>
                    <input id="current-password" type="password" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                </label>
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">New password</span>
                    <input id="new-password" type="password" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                </label>
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Confirm new password</span>
                    <input id="new-password-confirmation" type="password" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                </label>

                <button type="submit" class="w-full rounded-2xl bg-slate-100 px-4 py-3 font-semibold text-slate-950">Change password</button>
            </form>
        </div>

        <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Recent activity</p>
                    <h2 class="mt-2 text-2xl font-bold text-white">Latest orders</h2>
                </div>
            </div>

            <div id="profile-recent-orders" class="mt-4 space-y-3"></div>
        </div>
    </section>
</div>
@endsection
