@php $page = 'cart'; @endphp
@extends('layouts.app')

@section('content')
<div class="grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-2xl border border-stone-200/80 bg-white p-5">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Shopping cart</p>
                <h1 class="mt-2 text-3xl font-bold text-stone-900">Review your items</h1>
            </div>
            <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Local cart</div>
        </div>

        <div id="cart-items" class="mt-5 space-y-3"></div>
    </section>

    <aside class="rounded-2xl border border-stone-200/80 bg-white p-5">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Order summary</p>
        <h2 class="mt-2 text-2xl font-bold text-stone-900">Checkout</h2>
        <p class="mt-2 text-sm text-stone-600">Confirm your items, place the order, and track it from the orders page.</p>

        <div id="cart-summary" class="mt-5"></div>
    </aside>
</div>
@endsection
