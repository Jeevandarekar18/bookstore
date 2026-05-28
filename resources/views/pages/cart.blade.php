@php $page = 'cart'; @endphp
@extends('layouts.app')

@section('content')
<div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Shopping cart</p>
                <h1 class="mt-2 text-3xl font-bold text-white">Review your items</h1>
            </div>
            <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Local cart</div>
        </div>

        <div id="cart-items" class="mt-5 space-y-3"></div>
    </section>

    <aside class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Order summary</p>
        <h2 class="mt-2 text-2xl font-bold text-white">Checkout</h2>
        <p class="mt-2 text-sm text-slate-300">Confirm your items, place the order, and track it from the orders page.</p>

        <div id="cart-summary" class="mt-5"></div>
    </aside>
</div>
@endsection
