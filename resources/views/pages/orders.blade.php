@php $page = 'orders'; @endphp
@extends('layouts.app')

@section('content')
<section class="rounded-2xl border border-stone-200/80 bg-white p-5">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-blue-700">Order history</p>
            <h1 class="mt-2 text-3xl font-bold text-stone-900">Your orders</h1>
        </div>
        <div class="rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-blue-700">Live updates</div>
    </div>

    <div id="orders-list" class="mt-5 space-y-3"></div>
</section>
@endsection
