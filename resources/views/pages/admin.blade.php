@php $page = 'admin'; @endphp
@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="rounded-2xl border border-stone-200/80 bg-white p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Operations center</p>
                <h1 id="admin-title" class="mt-2 text-3xl font-bold text-stone-900">Admin dashboard</h1>
            </div>
            <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Administrator</div>
        </div>

        <div class="mt-5 grid gap-2 md:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-3">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Books</p>
                <p id="stats-books" class="mt-3 text-3xl font-bold text-stone-900">0</p>
            </div>
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-3">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Orders</p>
                <p id="stats-orders" class="mt-3 text-3xl font-bold text-stone-900">0</p>
            </div>
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-3">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Revenue</p>
                <p id="stats-revenue" class="mt-3 text-3xl font-bold text-stone-900">$0.00</p>
            </div>
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-3">
                <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Pending</p>
                <p id="stats-pending" class="mt-3 text-3xl font-bold text-stone-900">0</p>
            </div>
        </div>
    </section>

    <section class="grid gap-4 xl:grid-cols-[1.15fr_0.85fr]">
        <div class="space-y-3">
            <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Collections</p>
                        <h2 class="mt-2 text-2xl font-bold text-stone-900">Book management</h2>
                    </div>
                    <button id="book-book-tab" class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Book form</button>
                </div>

                <form id="book-form" class="mt-5 space-y-2.5">
                    <input type="hidden" id="book-id">
                    <div class="grid gap-2.5 md:grid-cols-2">
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Title</span>
                            <input id="book-title" type="text" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                        </label>
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">ISBN</span>
                            <input id="book-isbn" type="text" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                        </label>
                    </div>

                    <div class="grid gap-2.5 md:grid-cols-2">
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Author</span>
                            <select id="book-author" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500"></select>
                        </label>
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Category</span>
                            <select id="book-category" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500"></select>
                        </label>
                    </div>

                    <div class="grid gap-2.5 md:grid-cols-3">
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Price</span>
                            <input id="book-price" type="number" step="0.01" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                        </label>
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Stock</span>
                            <input id="book-stock" type="number" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                        </label>
                        <label class="block text-sm text-stone-600">
                            <span class="mb-2 block">Published</span>
                            <input id="book-date" type="date" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                        </label>
                    </div>

                    <label class="block text-sm text-stone-600">
                        <span class="mb-2 block">Description</span>
                        <textarea id="book-description" rows="4" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500"></textarea>
                    </label>

                    <button type="submit" class="w-full rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white">Save book</button>
                </form>

                <div class="mt-5 overflow-hidden rounded-2xl border border-stone-200/80">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-stone-50 text-stone-600">
                            <tr>
                                <th class="px-3 py-2.5">Title</th>
                                <th class="px-3 py-2.5">Author</th>
                                <th class="px-3 py-2.5">Category</th>
                                <th class="px-3 py-2.5">Stock</th>
                                <th class="px-3 py-2.5">Price</th>
                                <th class="px-3 py-2.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-books-body" class="divide-y divide-stone-200 bg-white"></tbody>
                    </table>
                </div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Writers</p>
                        <h2 class="mt-2 text-2xl font-bold text-stone-900">Author management</h2>
                    </div>
                    <button id="author-author-tab" class="rounded-full border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">Author form</button>
                </div>

                <form id="author-form" class="mt-5 space-y-2.5">
                    <input type="hidden" id="author-id">
                    <label class="block text-sm text-stone-600">
                        <span class="mb-2 block">Name</span>
                        <input id="author-name" type="text" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                    </label>
                    <label class="block text-sm text-stone-600">
                        <span class="mb-2 block">Biography</span>
                        <textarea id="author-bio" rows="4" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500"></textarea>
                    </label>
                    <label class="block text-sm text-stone-600">
                        <span class="mb-2 block">Birth date</span>
                        <input id="author-birth-date" type="date" class="w-full rounded-xl border border-stone-300 bg-stone-50 px-3 py-2.5 text-sm text-stone-800 outline-none focus:border-blue-500">
                    </label>

                    <button type="submit" class="w-full rounded-xl border border-stone-300 bg-white px-4 py-2.5 text-sm font-semibold text-stone-800">Save author</button>
                </form>

                <div class="mt-5 overflow-hidden rounded-2xl border border-stone-200/80">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-stone-50 text-stone-600">
                            <tr>
                                <th class="px-3 py-2.5">Name</th>
                                <th class="px-3 py-2.5">Bio</th>
                                <th class="px-3 py-2.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-authors-body" class="divide-y divide-stone-200 bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="space-y-3">
            <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Insights</p>
                        <h2 class="mt-2 text-2xl font-bold text-stone-900">Order analytics</h2>
                    </div>
                </div>

                <div id="status-breakdown" class="mt-5 grid gap-3"></div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Realtime</p>
                        <h2 class="mt-2 text-2xl font-bold text-stone-900">Recent orders</h2>
                    </div>
                </div>

                <div id="recent-orders" class="mt-5 space-y-3"></div>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-white p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Orders</p>
                        <h2 class="mt-2 text-2xl font-bold text-stone-900">Customer orders</h2>
                    </div>
                </div>

                <div class="mt-5 overflow-hidden rounded-2xl border border-stone-200/80">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-stone-50 text-stone-600">
                            <tr>
                                <th class="px-3 py-2.5">Order</th>
                                <th class="px-3 py-2.5">Customer</th>
                                <th class="px-3 py-2.5">Total</th>
                                <th class="px-3 py-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody id="admin-orders-body" class="divide-y divide-stone-200 bg-white"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
