@php $page = 'home'; @endphp
@extends('layouts.app')

@section('content')
<div class="space-y-4">
    <section class="overflow-hidden rounded-2xl border border-stone-200/80 bg-white p-5 md:p-6">
        <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
            <div>
                <p class="inline-flex rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Bookstore discovery</p>
                <h1 class="mt-4 text-4xl font-bold tracking-tight text-stone-900 md:text-5xl">Read widely, shop smart, and keep every order in view.</h1>
                <p class="mt-4 max-w-2xl text-base text-stone-600 md:text-lg">Browse curated books, filter by author or category, and build your reading list with clean, focused shopping flows.</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="/register" class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white">Create account</a>
                    <a href="/cart" class="rounded-full border border-stone-300 px-4 py-2 text-sm font-semibold text-stone-700">View cart</a>
                </div>
            </div>

            <div class="grid gap-2.5 md:grid-cols-2">
                <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Featured collection</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">500+</p>
                    <p class="mt-1 text-sm text-stone-600">Books ready for discovery</p>
                </div>
                <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                    <p class="text-sm text-stone-500">Smart filters</p>
                    <p class="mt-3 text-3xl font-bold text-stone-900">3x</p>
                    <p class="mt-1 text-sm text-stone-600">Faster browsing with author, category, and sort controls</p>
                </div>
                <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4 md:col-span-2">
                    <p class="text-sm text-stone-500">Customer experience</p>
                    <p class="mt-2 text-sm text-stone-600">Secure token auth, responsive cards, local cart persistence, and polished checkout flow.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog-panel" class="grid gap-4 lg:grid-cols-[1.15fr_0.85fr]">
        <div class="rounded-2xl border border-stone-200/80 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-stone-900">Browse the catalog</p>
                    <p class="text-sm text-stone-500">Search, filter, and sort with instant updates.</p>
                </div>
                <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-700">Live API</div>
            </div>

            <div class="mt-5 grid gap-3 md:grid-cols-2">
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Search</span>
                    <input id="book-search" type="text" placeholder="Search by title, author, or description" class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-3 py-2 text-stone-800 outline-none focus:border-blue-500">
                </label>
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Sort</span>
                    <select id="sort-filter" class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-3 py-2 text-stone-800 outline-none focus:border-blue-500">
                        <option value="title">Title</option>
                        <option value="price">Price</option>
                        <option value="published_date">Published date</option>
                    </select>
                </label>
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Category</span>
                    <select id="category-filter" class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-3 py-2 text-stone-800 outline-none focus:border-blue-500">
                        <option value="">All categories</option>
                    </select>
                </label>
                <label class="block text-sm text-stone-600">
                    <span class="mb-2 block">Author</span>
                    <select id="author-filter" class="w-full rounded-2xl border border-stone-300 bg-stone-50 px-3 py-2 text-stone-800 outline-none focus:border-blue-500">
                        <option value="">All authors</option>
                    </select>
                </label>
            </div>

            <div id="book-list-status" class="mt-4"></div>
            <div id="book-grid" class="mt-4 grid gap-4 md:grid-cols-2"></div>
            <div id="pagination" class="mt-4 flex flex-wrap gap-2"></div>
        </div>

        <aside class="space-y-3 rounded-2xl border border-stone-200/80 bg-white p-4">
            <div class="rounded-2xl border border-blue-200 bg-blue-50 p-4">
                <p class="text-sm font-semibold text-blue-700">Quick cart summary</p>
                <p class="mt-2 text-3xl font-bold text-stone-900">${{ number_format(0, 2) }}</p>
                <p class="mt-1 text-sm text-stone-600">Your local cart is synced instantly as you shop.</p>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                <p class="text-sm font-semibold text-stone-900">How it works</p>
                <ul class="mt-3 space-y-3 text-sm text-stone-600">
                    <li class="rounded-2xl bg-white px-3 py-2 border border-stone-200">Browse the list with search, author, category, and sort toggles.</li>
                    <li class="rounded-2xl bg-white px-3 py-2 border border-stone-200">Use Add to Cart to save items locally for faster checkout.</li>
                    <li class="rounded-2xl bg-white px-3 py-2 border border-stone-200">View details for a richer preview before you add it to your order.</li>
                </ul>
            </div>
        </aside>
    </section>
</div>

<div id="detail-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-stone-950/40 p-4">
    <div class="w-full max-w-2xl rounded-2xl border border-stone-200/80 bg-white p-5 shadow-sm">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Book preview</p>
                <h2 id="detail-modal-title" class="mt-2 text-2xl font-semibold text-stone-900"></h2>
            </div>
            <button id="detail-modal-close" class="rounded-full border border-stone-300 px-3 py-1 text-sm text-stone-700">Close</button>
        </div>

        <div class="mt-4 grid gap-3 md:grid-cols-2">
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                <p class="text-sm text-stone-500">Author</p>
                <p id="detail-modal-author" class="mt-1 text-lg font-semibold text-stone-900"></p>
                <p class="mt-4 text-sm text-stone-500">Category</p>
                <p id="detail-modal-category" class="mt-1 text-lg font-semibold text-stone-900"></p>
                <p class="mt-4 text-sm text-stone-500">Price</p>
                <p id="detail-modal-price" class="mt-1 text-xl font-bold text-blue-700"></p>
            </div>

            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                <p class="text-sm text-stone-500">Availability</p>
                <p id="detail-modal-stock" class="mt-1 text-lg font-semibold text-stone-900"></p>
                <p class="mt-4 text-sm text-stone-500">Description</p>
                <p id="detail-modal-description" class="mt-2 text-sm text-stone-600"></p>
            </div>
        </div>

        <div class="mt-5 flex justify-end">
            <button id="detail-modal-add" class="rounded-full bg-blue-600 px-4 py-2 font-semibold text-white">Add to cart</button>
        </div>
    </div>
</div>
@endsection
