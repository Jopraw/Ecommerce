@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header Banner --}}
    <div class="mb-8">
        <h1 class="text-3xl font-black tracking-tight">Katalog <span class="text-accent-orange">Alas Kaki</span></h1>
        <p class="text-text-muted text-sm mt-1">Koleksi sneakers dan footwear 100% original dari brand terkemuka.</p>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Sidebar Filters --}}
        <aside class="lg:w-64 shrink-0" x-data="{ open: false }">
            <button @click="open = !open" class="lg:hidden w-full bg-bg-card border border-border-dark rounded-xl px-4 py-3 flex items-center justify-between mb-4">
                <span class="font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter & Kategori
                </span>
                <svg class="w-5 h-5 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div :class="open ? 'block' : 'hidden'" class="lg:block space-y-5">
                {{-- Search --}}
                <form action="{{ route('shop.index') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari model sepatu..." class="w-full bg-bg-card border border-border-dark rounded-xl px-4 py-3 text-sm text-white placeholder-text-muted focus:border-accent-orange focus:ring-1 focus:ring-accent-orange outline-none transition-all">
                        <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-muted hover:text-accent-orange">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </button>
                    </div>
                    @if(request('brand')) <input type="hidden" name="brand" value="{{ request('brand') }}"> @endif
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                {{-- Filter Brand / Merek --}}
                <div class="bg-bg-card border border-border-dark rounded-xl p-4 mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-sm text-accent-cyan flex items-center gap-1.5">
                            <span>🏷️</span> Merek (Brand)
                        </h3>
                        @if(request('brand'))
                            <a href="{{ route('shop.index', array_merge(request()->except('brand', 'page'))) }}" class="text-[11px] text-text-muted hover:text-accent-orange transition-colors">Reset</a>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('shop.index', array_merge(request()->except('brand', 'page'))) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !request('brand') ? 'bg-accent-orange text-white font-bold' : 'text-text-secondary hover:bg-bg-secondary hover:text-white' }} transition-all">
                            <span>Semua Merek</span>
                            @if(!request('brand')) <span class="text-xs">✓</span> @endif
                        </a>
                        @foreach($brands as $b)
                            <a href="{{ route('shop.index', array_merge(request()->except('page'), ['brand' => $b])) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request('brand') === $b ? 'bg-accent-orange text-white font-bold' : 'text-text-secondary hover:bg-bg-secondary hover:text-white' }} transition-all">
                                <span>{{ $b }}</span>
                                @if(request('brand') === $b)
                                    <span class="text-xs">✓</span>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Categories --}}
                <div class="bg-bg-card border border-border-dark rounded-xl p-4 mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="font-bold text-sm text-accent-orange flex items-center gap-1.5">
                            <span>👟</span> Kategori
                        </h3>
                        @if(request('category'))
                            <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" class="text-[11px] text-text-muted hover:text-accent-orange transition-colors">Reset</a>
                        @endif
                    </div>
                    <div class="space-y-1">
                        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !request('category') ? 'bg-accent-orange/15 text-accent-orange font-bold border border-accent-orange/30' : 'text-text-secondary hover:bg-bg-secondary hover:text-white' }} transition-all">
                            <span>Semua Kategori</span>
                        </a>
                        @foreach($categories as $slug => $name)
                            <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $slug])) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ request('category') === $slug ? 'bg-accent-orange/15 text-accent-orange font-bold border border-accent-orange/30' : 'text-text-secondary hover:bg-bg-secondary hover:text-white' }} transition-all">
                                <span>{{ $name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Sort --}}
                <div class="bg-bg-card border border-border-dark rounded-xl p-4 mt-4">
                    <h3 class="font-bold text-sm mb-3 text-text-muted flex items-center gap-1.5">
                        <span>⚡</span> Urutkan
                    </h3>
                    <select name="sort" onchange="this.form.submit()" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-accent-orange transition-colors">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                    </select>
                </div>
                </form>

                {{-- Active Filters Reset --}}
                @if(request('brand') || request('category') || request('search'))
                    <a href="{{ route('shop.index') }}" class="block text-center py-2 text-xs text-red-400 hover:text-red-300 transition-colors">
                        ✕ Hapus Semua Filter
                    </a>
                @endif
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6 bg-bg-card border border-border-dark rounded-xl px-4 py-3">
                <p class="text-text-muted text-sm">
                    Menampilkan <span class="text-white font-bold">{{ $products->total() }}</span> produk
                    @if(request('brand'))
                        merek <span class="text-accent-cyan font-semibold">"{{ request('brand') }}"</span>
                    @endif
                    @if(request('category'))
                        kategori <span class="text-accent-orange font-semibold">"{{ $categories[request('category')] ?? request('category') }}"</span>
                    @endif
                </p>
                @if(request('brand') || request('category') || request('search'))
                    <a href="{{ route('shop.index') }}" class="text-xs text-accent-orange hover:underline font-medium">Reset Filter</a>
                @endif
            </div>

            @if($products->count())
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
                    @foreach($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @endforeach
                </div>

                {{-- Dark Futuristic Pagination --}}
                {{ $products->links('components.pagination') }}
            @else
                <div class="text-center py-20 bg-bg-card border border-border-dark rounded-2xl p-8">
                    <div class="text-6xl mb-4">👟</div>
                    <h3 class="text-xl font-bold mb-2">Produk tidak ditemukan</h3>
                    <p class="text-text-muted text-sm mb-6">Tidak ada sepatu yang cocok dengan filter yang dipilih.</p>
                    <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-6 py-3 rounded-xl transition-all text-sm">
                        Lihat Semua Sepatu
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
