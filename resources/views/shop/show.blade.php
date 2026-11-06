@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid lg:grid-cols-2 gap-12">
        {{-- Product Image --}}
        <div class="aspect-square bg-bg-card border border-border-dark rounded-2xl flex items-center justify-center overflow-hidden">
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
            @else
                <div class="text-9xl">👟</div>
            @endif
        </div>

        {{-- Product Info --}}
        <div>
            <div class="flex items-center gap-2 mb-4">
                @if($product->brand)
                    <span class="inline-block bg-accent-orange/20 text-accent-orange text-xs font-extrabold px-3.5 py-1 rounded-full uppercase tracking-wider">{{ $product->brand }}</span>
                @endif
                <span class="inline-block bg-accent-teal/20 text-accent-teal text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">{{ $product->category }}</span>
            </div>
            <h1 class="text-3xl lg:text-4xl font-black mb-4">{{ $product->name }}</h1>
            <p class="text-4xl font-bold text-accent-orange mb-6">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <p class="text-text-secondary mb-8 leading-relaxed">{{ $product->description }}</p>

            <form action="{{ route('cart.store') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Size Selector --}}
                @if($product->size_options)
                <div>
                    <label class="block text-sm font-semibold mb-3">Pilih Ukuran</label>
                    <div class="flex flex-wrap gap-2" x-data="{ selected: '{{ $product->size_options[0] ?? '' }}' }">
                        @foreach($product->size_options as $size)
                            <label class="cursor-pointer">
                                <input type="radio" name="size" value="{{ $size }}" x-model="selected" class="hidden">
                                <span :class="selected === '{{ $size }}' ? 'border-accent-orange bg-accent-orange/10 text-accent-orange' : 'border-border-dark text-text-secondary hover:border-text-muted'" class="inline-flex items-center justify-center w-12 h-12 border rounded-lg text-sm font-medium transition-all">{{ $size }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quantity --}}
                <div>
                    <label class="block text-sm font-semibold mb-3">Jumlah</label>
                    <div class="flex items-center gap-3" x-data="{ qty: 1 }">
                        <button type="button" @click="qty = Math.max(1, qty - 1)" class="w-10 h-10 bg-bg-card border border-border-dark rounded-lg flex items-center justify-center hover:border-accent-orange transition-colors">−</button>
                        <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}" class="w-16 h-10 bg-bg-card border border-border-dark rounded-lg text-center text-white outline-none focus:border-accent-orange">
                        <button type="button" @click="qty = Math.min({{ $product->stock }}, qty + 1)" class="w-10 h-10 bg-bg-card border border-border-dark rounded-lg flex items-center justify-center hover:border-accent-orange transition-colors">+</button>
                        <span class="text-text-muted text-sm ml-2">Stok: {{ $product->stock }}</span>
                    </div>
                </div>

                {{-- Add to Cart --}}
                @if($product->stock > 0)
                    <button type="submit" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-4 rounded-xl transition-all glow-orange-hover text-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                        Tambah ke Keranjang
                    </button>
                @else
                    <button disabled class="w-full bg-gray-700 text-gray-400 font-bold py-4 rounded-xl cursor-not-allowed">Stok Habis</button>
                @endif
            </form>
        </div>
    </div>

    {{-- Related Products --}}
    @if($relatedProducts->count())
    <section class="mt-20">
        <h2 class="text-2xl font-bold mb-8">Produk <span class="text-accent-orange">Serupa</span></h2>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            @foreach($relatedProducts as $related)
                @include('components.product-card', ['product' => $related])
            @endforeach
        </div>
    </section>
    @endif
</div>
@endsection
