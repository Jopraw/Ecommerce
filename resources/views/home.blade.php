@extends('layouts.app')
@section('content')
{{-- Hero Section --}}
<section class="relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <span class="inline-block bg-accent-orange/20 text-accent-orange text-sm font-bold px-4 py-1 rounded-full mb-6 tracking-wider">NEW DROP</span>
                <h1 class="text-5xl lg:text-7xl font-black leading-tight mb-6">
                    STEP <span class="text-accent-orange">BOLD.</span><br>
                    MOVE <span class="text-accent-teal">FORWARD.</span>
                </h1>
                <p class="text-text-secondary text-lg mb-8 max-w-lg">Streetwear premium dengan desain eksklusif untuk setiap langkahmu. Produk asli terverifikasi, transaksi aman.</p>
                <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-8 py-4 rounded-xl transition-all glow-orange-hover text-lg">
                    SHOP NOW
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
            <div class="relative flex items-center justify-center">
                <div class="w-80 h-80 lg:w-96 lg:h-96 rounded-full bg-gradient-to-br from-accent-orange/20 via-accent-teal/10 to-transparent blur-3xl absolute"></div>
                <div class="relative z-10 text-center">
                    <div class="text-9xl">👟</div>
                    <div class="w-48 h-2 mx-auto bg-gradient-to-r from-transparent via-accent-orange/50 to-transparent rounded-full mt-4"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-accent-orange/5 to-transparent pointer-events-none"></div>
</section>

{{-- Featured Products --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-10">
        <div>
            <span class="text-accent-orange font-bold text-sm tracking-widest">FEATURED</span>
            <h2 class="text-3xl font-bold mt-1">Produk Unggulan</h2>
        </div>
        <a href="{{ route('shop.index') }}" class="text-text-secondary hover:text-accent-orange transition-colors text-sm font-medium flex items-center gap-1">
            Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 lg:gap-6">
        @foreach($featuredProducts as $product)
            @include('components.product-card', ['product' => $product])
        @endforeach
    </div>
</section>

{{-- Categories --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-10">
        <span class="text-accent-orange font-bold text-sm tracking-widest">CATEGORIES</span>
        <h2 class="text-3xl font-bold mt-1">Jelajahi Kategori</h2>
    </div>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
        @php
        $cats = [
            ['slug' => 'sneakers', 'name' => 'Sneakers & Streetwear', 'icon' => '👟', 'desc' => 'Tren fashion urban terkini'],
            ['slug' => 'formal', 'name' => 'Sepatu Formal', 'icon' => '👞', 'desc' => 'Profesional dan elegan'],
            ['slug' => 'sandal', 'name' => 'Sandal Kasual', 'icon' => '🩴', 'desc' => 'Kenyamanan sehari-hari'],
            ['slug' => 'perawatan', 'name' => 'Perawatan Sepatu', 'icon' => '🧴', 'desc' => 'Jaga kualitas sepatumu'],
        ];
        @endphp
        @foreach($cats as $cat)
        <a href="{{ route('shop.index', ['category' => $cat['slug']]) }}" class="group bg-bg-card border border-border-dark rounded-xl p-6 text-center hover:border-accent-orange/50 transition-all glow-orange-hover">
            <div class="text-4xl mb-3">{{ $cat['icon'] }}</div>
            <h3 class="font-bold text-sm lg:text-base">{{ $cat['name'] }}</h3>
            <p class="text-text-muted text-xs mt-1">{{ $cat['desc'] }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- Trust Badges --}}
<section class="bg-bg-secondary py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-accent-teal/10 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Produk Original</h3>
                <p class="text-text-muted text-sm">Verifikasi keaslian dengan teknologi Authenticator</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-accent-orange/10 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Pembayaran Aman</h3>
                <p class="text-text-muted text-sm">Enkripsi data tingkat tinggi untuk keamanan transaksi</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 mx-auto bg-accent-cyan/10 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-lg mb-2">Pengiriman Cepat</h3>
                <p class="text-text-muted text-sm">Pelacakan real-time untuk setiap pesanan</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="bg-gradient-to-r from-accent-orange/20 to-accent-teal/10 rounded-2xl p-12 text-center border border-accent-orange/20">
        <h2 class="text-4xl font-black mb-4">Siap <span class="text-accent-orange">Melangkah?</span></h2>
        <p class="text-text-secondary mb-8 max-w-lg mx-auto">Temukan koleksi terbaru kami dan jadilah yang pertama mendapatkan drop eksklusif.</p>
        <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-8 py-4 rounded-xl transition-all glow-orange-hover">
            Jelajahi Sekarang
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
        </a>
    </div>
</section>
@endsection
