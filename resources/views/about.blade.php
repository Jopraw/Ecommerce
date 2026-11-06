@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <span class="text-accent-orange font-bold text-sm tracking-widest">ABOUT US</span>
        <h1 class="text-4xl font-black mt-2">Tentang <span class="text-accent-orange">AstroStep</span></h1>
    </div>
    <div class="max-w-3xl mx-auto space-y-8">
        <div class="bg-bg-card border border-border-dark rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-4 text-accent-teal">Misi Kami</h2>
            <p class="text-text-secondary leading-relaxed">AstroStep hadir sebagai solusi platform e-commerce alas kaki terpercaya di Indonesia. Kami berkomitmen menyediakan produk original dengan harga kompetitif, transaksi yang aman, dan pengalaman belanja yang menyenangkan.</p>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-bg-card border border-border-dark rounded-xl p-6 text-center">
                <div class="text-4xl mb-3">✅</div>
                <h3 class="font-bold mb-2">100% Original</h3>
                <p class="text-text-muted text-sm">Setiap produk terverifikasi keasliannya</p>
            </div>
            <div class="bg-bg-card border border-border-dark rounded-xl p-6 text-center">
                <div class="text-4xl mb-3">🔒</div>
                <h3 class="font-bold mb-2">Transaksi Aman</h3>
                <p class="text-text-muted text-sm">Data terenkripsi, pembayaran terproteksi</p>
            </div>
            <div class="bg-bg-card border border-border-dark rounded-xl p-6 text-center">
                <div class="text-4xl mb-3">🚀</div>
                <h3 class="font-bold mb-2">Pengiriman Cepat</h3>
                <p class="text-text-muted text-sm">Seluruh Indonesia dengan tracking real-time</p>
            </div>
        </div>
        <div class="bg-bg-card border border-border-dark rounded-xl p-8">
            <h2 class="text-2xl font-bold mb-4 text-accent-orange">Tim Kami</h2>
            <p class="text-text-secondary leading-relaxed">Kelompok 2 — Romanov Putra Anugrah & Jojo Prawinata Situmeang. Kami adalah tim yang berdedikasi membangun platform e-commerce terbaik untuk kebutuhan alas kaki Anda.</p>
        </div>
    </div>
</div>
@endsection
