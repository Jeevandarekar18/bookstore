@php $page = 'profile'; @endphp
@extends('layouts.app')

@section('content')
<div class="grid gap-4 xl:grid-cols-[0.9fr_1.1fr]">
    <section class="rounded-2xl border border-stone-200/80 bg-white p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">My profile</p>
                <h1 class="mt-2 text-3xl font-bold text-stone-900">Profile settings</h1>
            </div>
            <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Personal</div>
        </div>

        <div class="mt-5 rounded-2xl border border-stone-200/80 bg-stone-50 p-3">
            <p class="text-sm text-stone-500">Account summary</p>
            <p id="profile-summary-name" class="mt-3 text-2xl font-semibold text-stone-900">Customer</p>
            <p id="profile-summary-email" class="mt-1 text-sm text-stone-600"></p>
            <div class="mt-4 flex items-center gap-2">
                <span id="profile-summary-role" class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-700">Customer</span>
            </div>
        </div>

        <form id="profile-form" class="mt-5 space-y-3">
            <label class="block text-sm text-stone-600">
                <span class="mb-2 block">Name</span>
                <input id="profile-name" type="text" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
            </label>
            <label class="block text-sm text-stone-600">
                <span class="mb-2 block">Email</span>
                <input id="profile-email" type="email" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
            </label>
            <label class="block text-sm text-stone-600">
                <span class="mb-2 block">Phone</span>
                <input id="profile-phone" type="text" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
            </label>
            <label class="block text-sm text-stone-600">
                <span class="mb-2 block">Address</span>
                <textarea id="profile-address" rows="4" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500"></textarea>
            </label>

            <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Save profile</button>
        </form>
    </section>

    <section class="space-y-3">
        <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Update password</p>
                    <h2 class="mt-2 text-2xl font-bold text-stone-900">Security</h2>
                </div>
            </div>

            <form id="password-form" class="mt-5 space-y-3">
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Current password</span>
                    <input id="current-password" type="password" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                </label>
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">New password</span>
                    <input id="new-password" type="password" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                </label>
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Confirm new password</span>
                    <input id="new-password-confirmation" type="password" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                </label>

                <button type="submit" class="w-full rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-800">Change password</button>
            </form>
        </div>

        <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Recent activity</p>
                    <h2 class="mt-2 text-2xl font-bold text-stone-900">Latest orders</h2>
                </div>
            </div>

            <div id="profile-recent-orders" class="mt-4 space-y-3"></div>
        </div>
    </section>
</div>
@endsection
