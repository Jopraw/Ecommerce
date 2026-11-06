@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <span class="text-accent-orange font-bold text-sm tracking-widest">COLLECTIONS</span>
        <h1 class="text-4xl font-black mt-2">Koleksi <span class="text-accent-orange">Kami</span></h1>
        <p class="text-text-secondary mt-3">Jelajahi kategori produk pilihan terbaik</p>
    </div>
    <div class="grid md:grid-cols-2 gap-6">
        <a href="{{ route('shop.index', ['category' => 'sneakers']) }}" class="group relative h-72 bg-bg-card border border-border-dark rounded-2xl overflow-hidden flex items-end p-8 hover:border-accent-orange/50 transition-all glow-orange-hover">
            <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/90 to-transparent z-10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-8xl opacity-30 group-hover:scale-110 transition-transform">👟</div>
            <div class="relative z-20">
                <h2 class="text-2xl font-black">Sneakers & <span class="text-accent-orange">Streetwear</span></h2>
                <p class="text-text-muted text-sm mt-1">Tren fashion urban terkini</p>
            </div>
        </a>
        <a href="{{ route('shop.index', ['category' => 'formal']) }}" class="group relative h-72 bg-bg-card border border-border-dark rounded-2xl overflow-hidden flex items-end p-8 hover:border-accent-teal/50 transition-all">
            <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/90 to-transparent z-10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-8xl opacity-30 group-hover:scale-110 transition-transform">👞</div>
            <div class="relative z-20">
                <h2 class="text-2xl font-black">Sepatu <span class="text-accent-teal">Formal</span></h2>
                <p class="text-text-muted text-sm mt-1">Profesional dan elegan</p>
            </div>
        </a>
        <a href="{{ route('shop.index', ['category' => 'sandal']) }}" class="group relative h-72 bg-bg-card border border-border-dark rounded-2xl overflow-hidden flex items-end p-8 hover:border-accent-cyan/50 transition-all">
            <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/90 to-transparent z-10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-8xl opacity-30 group-hover:scale-110 transition-transform">🩴</div>
            <div class="relative z-20">
                <h2 class="text-2xl font-black">Sandal <span class="text-accent-cyan">Kasual</span></h2>
                <p class="text-text-muted text-sm mt-1">Kenyamanan sehari-hari</p>
            </div>
        </a>
        <a href="{{ route('shop.index', ['category' => 'perawatan']) }}" class="group relative h-72 bg-bg-card border border-border-dark rounded-2xl overflow-hidden flex items-end p-8 hover:border-accent-orange/50 transition-all">
            <div class="absolute inset-0 bg-gradient-to-t from-bg-primary/90 to-transparent z-10"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-8xl opacity-30 group-hover:scale-110 transition-transform">🧴</div>
            <div class="relative z-20">
                <h2 class="text-2xl font-black">Perawatan <span class="text-accent-orange">Sepatu</span></h2>
                <p class="text-text-muted text-sm mt-1">Jaga kualitas sepatumu</p>
            </div>
        </a>
    </div>
</div>
@endsection
