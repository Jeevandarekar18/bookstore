@php $page = 'admin'; @endphp
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Operations center</p>
                <h1 id="admin-title" class="mt-2 text-3xl font-bold text-white">Admin dashboard</h1>
            </div>
            <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Administrator</div>
        </div>

        <div class="mt-5 grid gap-3 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-3xl border border-white/10 bg-slate-950/85 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Books</p>
                <p id="stats-books" class="mt-3 text-3xl font-bold text-white">0</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-950/85 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Orders</p>
                <p id="stats-orders" class="mt-3 text-3xl font-bold text-white">0</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-950/85 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Revenue</p>
                <p id="stats-revenue" class="mt-3 text-3xl font-bold text-white">$0.00</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-slate-950/85 p-4">
                <p class="text-xs uppercase tracking-[0.2em] text-slate-400">Pending</p>
                <p id="stats-pending" class="mt-3 text-3xl font-bold text-white">0</p>
            </div>
        </div>
    </section>

    <section class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-6">
            <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Collections</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Book management</h2>
                    </div>
                    <button id="book-book-tab" class="rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950">Book form</button>
                </div>

                <form id="book-form" class="mt-5 space-y-3">
                    <input type="hidden" id="book-id">
                    <div class="grid gap-3 md:grid-cols-2">
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Title</span>
                            <input id="book-title" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        </label>
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">ISBN</span>
                            <input id="book-isbn" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        </label>
                    </div>

                    <div class="grid gap-3 md:grid-cols-2">
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Author</span>
                            <select id="book-author" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400"></select>
                        </label>
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Category</span>
                            <select id="book-category" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400"></select>
                        </label>
                    </div>

                    <div class="grid gap-3 md:grid-cols-3">
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Price</span>
                            <input id="book-price" type="number" step="0.01" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        </label>
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Stock</span>
                            <input id="book-stock" type="number" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        </label>
                        <label class="block text-sm text-slate-300">
                            <span class="mb-2 block">Published</span>
                            <input id="book-date" type="date" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                        </label>
                    </div>

                    <label class="block text-sm text-slate-300">
                        <span class="mb-2 block">Description</span>
                        <textarea id="book-description" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400"></textarea>
                    </label>

                    <button type="submit" class="w-full rounded-2xl bg-cyan-500 px-4 py-3 font-semibold text-slate-950">Save book</button>
                </form>

                <div class="mt-5 overflow-hidden rounded-3xl border border-white/10">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-950/90 text-slate-300">
                            <tr>
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Author</th>
                                <th class="px-4 py-3">Category</th>
                                <th class="px-4 py-3">Stock</th>
                                <th class="px-4 py-3">Price</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-books-body" class="divide-y divide-white/5 bg-slate-900/80"></tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Writers</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Author management</h2>
                    </div>
                    <button id="author-author-tab" class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-950">Author form</button>
                </div>

                <form id="author-form" class="mt-5 space-y-3">
                    <input type="hidden" id="author-id">
                    <label class="block text-sm text-slate-300">
                        <span class="mb-2 block">Name</span>
                        <input id="author-name" type="text" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                    </label>
                    <label class="block text-sm text-slate-300">
                        <span class="mb-2 block">Biography</span>
                        <textarea id="author-bio" rows="4" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400"></textarea>
                    </label>
                    <label class="block text-sm text-slate-300">
                        <span class="mb-2 block">Birth date</span>
                        <input id="author-birth-date" type="date" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-4 py-3 text-white outline-none focus:border-cyan-400">
                    </label>

                    <button type="submit" class="w-full rounded-2xl bg-slate-100 px-4 py-3 font-semibold text-slate-950">Save author</button>
                </form>

                <div class="mt-5 overflow-hidden rounded-3xl border border-white/10">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-950/90 text-slate-300">
                            <tr>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3">Bio</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-authors-body" class="divide-y divide-white/5 bg-slate-900/80"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Insights</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Order analytics</h2>
                    </div>
                </div>

                <div id="status-breakdown" class="mt-5 grid gap-3"></div>
            </div>

            <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Realtime</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Recent orders</h2>
                    </div>
                </div>

                <div id="recent-orders" class="mt-5 space-y-3"></div>
            </div>

            <div class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Orders</p>
                        <h2 class="mt-2 text-2xl font-bold text-white">Customer orders</h2>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-3xl border border-white/10">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-slate-950/90 text-slate-300">
                            <tr>
                                <th class="px-4 py-3">Order</th>
                                <th class="px-4 py-3">Customer</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Status</th>
                            </tr>
                        </thead>
                        <tbody id="admin-orders-body" class="divide-y divide-white/5 bg-slate-900/80"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
