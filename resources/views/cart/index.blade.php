@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Keranjang <span class="text-accent-orange">Belanja</span></h1>

    @if($cartItems->count())
        <div class="space-y-4">
            @foreach($cartItems as $item)
            <div class="bg-bg-card border border-border-dark rounded-xl p-4 flex items-center gap-4">
                <div class="w-20 h-20 bg-bg-secondary rounded-lg flex items-center justify-center shrink-0">
                    @if($item->product->image)
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <span class="text-3xl">👟</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold truncate">{{ $item->product->name }}</h3>
                    <p class="text-text-muted text-sm">Ukuran: {{ $item->size ?? '-' }}</p>
                    <p class="text-accent-orange font-bold mt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center gap-1">
                        @csrf @method('PATCH')
                        <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="w-8 h-8 bg-bg-secondary border border-border-dark rounded-lg flex items-center justify-center hover:border-accent-orange text-sm">−</button>
                        <span class="w-8 text-center text-sm">{{ $item->quantity }}</span>
                        <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-8 h-8 bg-bg-secondary border border-border-dark rounded-lg flex items-center justify-center hover:border-accent-orange text-sm">+</button>
                    </form>
                </div>
                <div class="text-right shrink-0">
                    <p class="font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    <form action="{{ route('cart.destroy', $item) }}" method="POST" class="mt-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-300 text-xs">Hapus</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 bg-bg-card border border-border-dark rounded-xl p-6">
            <div class="flex items-center justify-between text-lg mb-4">
                <span class="text-text-secondary">Total</span>
                <span class="font-bold text-accent-orange text-2xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.index') }}" class="block w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-4 rounded-xl transition-all glow-orange-hover text-center text-lg">
                Checkout
            </a>
        </div>
    @else
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🛒</div>
            <h3 class="text-xl font-bold mb-2">Keranjang Kosong</h3>
            <p class="text-text-muted mb-6">Belum ada produk di keranjang.</p>
            <a href="{{ route('shop.index') }}" class="inline-block bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-8 py-3 rounded-xl transition-all">Mulai Belanja</a>
        </div>
    @endif
</div>
@endsection
