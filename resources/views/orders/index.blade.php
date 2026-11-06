@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Pesanan <span class="text-accent-orange">Saya</span></h1>
    @if($orders->count())
        <div class="space-y-4">
            @foreach($orders as $order)
            <a href="{{ route('orders.show', $order) }}" class="block bg-bg-card border border-border-dark rounded-xl p-6 hover:border-accent-orange/30 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <span class="font-mono text-sm text-accent-cyan">{{ $order->order_number }}</span>
                    <span class="text-xs px-3 py-1 rounded-full font-medium {{ $order->status_color }}">{{ $order->status_label }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-text-muted text-sm">{{ $order->created_at->format('d M Y, H:i') }}</span>
                    <span class="font-bold text-accent-orange">{{ $order->formatted_total }}</span>
                </div>
            </a>
            @endforeach
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">📦</div>
            <h3 class="text-xl font-bold mb-2">Belum Ada Pesanan</h3>
            <p class="text-text-muted mb-6">Mulai belanja untuk melihat pesananmu di sini.</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-8 py-3 rounded-xl transition-all">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
