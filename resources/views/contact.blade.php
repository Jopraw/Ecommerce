@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center mb-12">
        <span class="text-accent-orange font-bold text-sm tracking-widest">CONTACT</span>
        <h1 class="text-4xl font-black mt-2">Hubungi <span class="text-accent-orange">Kami</span></h1>
    </div>
    <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
        <div class="space-y-6">
            <div class="bg-bg-card border border-border-dark rounded-xl p-6">
                <h3 class="font-bold text-accent-orange mb-4">Informasi Kontak</h3>
                <div class="space-y-3 text-text-secondary text-sm">
                    <p>📧 tim@astrostep.com</p>
                    <p>📱 +62 812-3456-7890 (WhatsApp)</p>
                    <p>🌐 www.astrostep.com</p>
                    <p>📍 Jakarta, Indonesia</p>
                </div>
            </div>
            <div class="bg-bg-card border border-border-dark rounded-xl p-6">
                <h3 class="font-bold text-accent-teal mb-4">Jam Operasional</h3>
                <div class="space-y-2 text-text-secondary text-sm">
                    <p>Senin - Jumat: 09:00 - 18:00 WIB</p>
                    <p>Sabtu: 09:00 - 15:00 WIB</p>
                    <p>Minggu & Hari Libur: Tutup</p>
                </div>
            </div>
        </div>
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <h3 class="font-bold mb-4">Kirim Pesan</h3>
            <form class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange" placeholder="Nama Anda">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange" placeholder="email@contoh.com">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Pesan</label>
                    <textarea rows="4" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange resize-none" placeholder="Tulis pesan Anda..."></textarea>
                </div>
                <button type="button" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-3 rounded-xl transition-all">Kirim Pesan</button>
            </form>
        </div>
    </div>
</div>
@endsection
