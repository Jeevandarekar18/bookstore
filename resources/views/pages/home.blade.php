@php $page = 'home'; @endphp
@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <section class="overflow-hidden rounded-[28px] border border-white/10 bg-slate-900/70 p-6 shadow-2xl shadow-cyan-950/20 md:p-8">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div>
                <p class="inline-flex rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Bookstore discovery</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-white md:text-5xl">Read widely, shop smart, and keep every order in view.</h1>
                <p class="mt-4 max-w-2xl text-base text-slate-300 md:text-lg">Browse curated books, filter by author or category, and build your reading list with fast, secure cart actions backed by a modern Laravel API.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="/register" class="rounded-full bg-cyan-500 px-4 py-2 text-sm font-semibold text-slate-950">Create account</a>
                    <a href="/cart" class="rounded-full border border-white/10 px-4 py-2 text-sm font-semibold text-white">View cart</a>
                </div>
            </div>

            <div class="grid gap-3 md:grid-cols-2">
                <div class="rounded-3xl bg-gradient-to-br from-cyan-500/20 to-cyan-400/5 p-5 border border-cyan-400/20">
                    <p class="text-sm text-cyan-100">Featured collection</p>
                    <p class="mt-3 text-3xl font-bold text-white">500+</p>
                    <p class="mt-1 text-sm text-slate-200">Books ready for discovery</p>
                </div>
                <div class="rounded-3xl bg-slate-800/90 p-5 border border-white/10">
                    <p class="text-sm text-slate-200">Smart filters</p>
                    <p class="mt-3 text-3xl font-bold text-white">3x</p>
                    <p class="mt-1 text-sm text-slate-300">Faster browsing with author, category, and sort controls</p>
                </div>
                <div class="rounded-3xl bg-slate-800/90 p-5 border border-white/10 md:col-span-2">
                    <p class="text-sm text-slate-200">Customer experience</p>
                    <p class="mt-2 text-sm text-slate-300">Secure token auth, responsive cards, local cart persistence, and polished checkout flow.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog-panel" class="grid gap-6 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="rounded-[28px] border border-white/10 bg-slate-900/80 p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-white">Browse the catalog</p>
                    <p class="text-sm text-slate-400">Search, filter, and sort with instant updates.</p>
                </div>
                <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-cyan-200">Live API</div>
            </div>

            <div class="mt-5 grid gap-3 md:grid-cols-2">
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Search</span>
                    <input id="book-search" type="text" placeholder="Search by title, author, or description" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-3 py-2 text-white outline-none focus:border-cyan-400">
                </label>
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Sort</span>
                    <select id="sort-filter" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-3 py-2 text-white outline-none focus:border-cyan-400">
                        <option value="title">Title</option>
                        <option value="price">Price</option>
                        <option value="published_date">Published date</option>
                    </select>
                </label>
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Category</span>
                    <select id="category-filter" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-3 py-2 text-white outline-none focus:border-cyan-400">
                        <option value="">All categories</option>
                    </select>
                </label>
                <label class="block text-sm text-slate-300">
                    <span class="mb-2 block">Author</span>
                    <select id="author-filter" class="w-full rounded-2xl border border-white/10 bg-slate-950 px-3 py-2 text-white outline-none focus:border-cyan-400">
                        <option value="">All authors</option>
                    </select>
                </label>
            </div>

            <div id="book-list-status" class="mt-4"></div>
            <div id="book-grid" class="mt-4 grid gap-4 md:grid-cols-2"></div>
            <div id="pagination" class="mt-4 flex flex-wrap gap-2"></div>
        </div>

        <aside class="space-y-4 rounded-[28px] border border-white/10 bg-slate-900/80 p-5">
            <div class="rounded-3xl border border-cyan-400/20 bg-cyan-500/10 p-5">
                <p class="text-sm font-semibold text-cyan-100">Quick cart summary</p>
                <p class="mt-2 text-3xl font-bold text-white">${{ number_format(0, 2) }}</p>
                <p class="mt-1 text-sm text-cyan-50">Your local cart is synced instantly as you shop.</p>
            </div>

            <div class="rounded-3xl border border-white/10 bg-slate-950/80 p-5">
                <p class="text-sm font-semibold text-white">How it works</p>
                <ul class="mt-3 space-y-3 text-sm text-slate-300">
                    <li class="rounded-2xl bg-slate-900/80 px-3 py-2">Browse the list with search, author, category, and sort toggles.</li>
                    <li class="rounded-2xl bg-slate-900/80 px-3 py-2">Use Add to Cart to save items locally for faster checkout.</li>
                    <li class="rounded-2xl bg-slate-900/80 px-3 py-2">View details for a richer preview before you add it to your order.</li>
                </ul>
            </div>
        </aside>
    </section>
</div>

<div id="detail-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-slate-950/80 p-4">
    <div class="w-full max-w-2xl rounded-[30px] border border-white/10 bg-slate-900 p-6 shadow-2xl">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Book preview</p>
                <h2 id="detail-modal-title" class="mt-2 text-2xl font-semibold text-white"></h2>
            </div>
            <button id="detail-modal-close" class="rounded-full bg-slate-800 px-3 py-1 text-sm text-white">Close</button>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="rounded-3xl bg-slate-800 p-4">
                <p class="text-sm text-slate-300">Author</p>
                <p id="detail-modal-author" class="mt-1 text-lg font-semibold text-white"></p>
                <p class="mt-4 text-sm text-slate-300">Category</p>
                <p id="detail-modal-category" class="mt-1 text-lg font-semibold text-white"></p>
                <p class="mt-4 text-sm text-slate-300">Price</p>
                <p id="detail-modal-price" class="mt-1 text-xl font-bold text-cyan-200"></p>
            </div>

            <div class="rounded-3xl bg-slate-800 p-4">
                <p class="text-sm text-slate-300">Availability</p>
                <p id="detail-modal-stock" class="mt-1 text-lg font-semibold text-white"></p>
                <p class="mt-4 text-sm text-slate-300">Description</p>
                <p id="detail-modal-description" class="mt-2 text-sm text-slate-200"></p>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button id="detail-modal-add" class="rounded-full bg-cyan-500 px-4 py-2 font-semibold text-slate-950">Add to cart</button>
        </div>
    </div>
</div>
@endsection
