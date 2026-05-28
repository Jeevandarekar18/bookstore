@php $page = 'orders'; @endphp
@extends('layouts.app')

@section('content')
<section class="rounded-[30px] border border-white/10 bg-slate-900/80 p-6">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-cyan-200">Order history</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Your orders</h1>
        </div>
        <div class="rounded-full bg-cyan-500/10 px-3 py-1 text-[10px] font-semibold uppercase tracking-[0.28em] text-cyan-200">Live updates</div>
    </div>

    <div id="orders-list" class="mt-5 space-y-3"></div>
</section>
@endsection
