@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('orders.index') }}" class="text-text-muted hover:text-white text-sm mb-4 inline-flex items-center gap-1">← Kembali ke Pesanan</a>
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Pesanan <span class="text-accent-cyan">{{ $order->order_number }}</span></h1>
        <span class="px-4 py-2 rounded-full text-sm font-medium {{ $order->status_color }}">{{ $order->status_label }}</span>
    </div>

    {{-- Progress Tracker --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6 mb-6">
        @php
            $steps = ['pending' => 'Menunggu', 'paid' => 'Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'];
            $statuses = array_keys($steps);
            $currentIdx = array_search($order->status, $statuses);
            if ($currentIdx === false) $currentIdx = -1;
        @endphp
        <div class="flex items-center justify-between">
            @foreach($steps as $key => $label)
                @php $idx = array_search($key, $statuses); @endphp
                <div class="flex flex-col items-center text-center flex-1">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold {{ $idx <= $currentIdx ? 'bg-accent-orange text-white' : 'bg-bg-secondary text-text-muted border border-border-dark' }}">
                        @if($idx < $currentIdx) ✓ @else {{ $idx + 1 }} @endif
                    </div>
                    <span class="text-xs mt-2 {{ $idx <= $currentIdx ? 'text-white' : 'text-text-muted' }}">{{ $label }}</span>
                </div>
                @if(!$loop->last)
                    <div class="h-0.5 flex-1 {{ $idx < $currentIdx ? 'bg-accent-orange' : 'bg-border-dark' }} -mt-6"></div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Cancelled/Expired Notice --}}
    @if(in_array($order->status, ['cancelled', 'expired']))
    <div class="bg-red-500/10 border border-red-500/30 rounded-xl p-6 mb-6">
        <div class="flex items-center gap-3">
            <span class="text-3xl">❌</span>
            <div>
                <h2 class="font-bold text-red-400">Pesanan {{ $order->status === 'cancelled' ? 'Dibatalkan' : 'Kedaluwarsa' }}</h2>
                <p class="text-text-muted text-sm">{{ $order->status === 'cancelled' ? 'Pembayaran dibatalkan atau ditolak.' : 'Waktu pembayaran telah habis.' }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Order Items --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6 mb-6">
        <h2 class="font-bold mb-4">Detail Produk</h2>
        <div class="space-y-3">
            @foreach($order->items as $item)
            <div class="flex items-center gap-4">
                @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-14 h-14 object-cover rounded-lg shrink-0 border border-border-dark">
                @else
                    <div class="w-14 h-14 bg-bg-secondary rounded-lg flex items-center justify-center shrink-0 text-2xl">👟</div>
                @endif
                <div class="flex-1">
                    <p class="font-medium text-sm">{{ $item->product->name ?? 'Produk dihapus' }}</p>
                    <p class="text-text-muted text-xs">Ukuran: {{ $item->size ?? '-' }} · Qty: {{ $item->quantity }}</p>
                </div>
                <p class="font-bold text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
            @endforeach
        </div>
        <div class="border-t border-border-dark mt-4 pt-4 flex justify-between font-bold text-lg">
            <span>Total</span>
            <span class="text-accent-orange">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- Shipping Info --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6 mb-6">
        <h2 class="font-bold mb-4">Informasi Pengiriman</h2>
        <div class="text-sm space-y-2 text-text-secondary">
            <p><span class="text-text-muted">Nama:</span> {{ $order->shipping_name }}</p>
            <p><span class="text-text-muted">Telepon:</span> {{ $order->shipping_phone }}</p>
            <p><span class="text-text-muted">Alamat:</span> {{ $order->shipping_address }}</p>
            @if($order->tracking_number)
                <p><span class="text-text-muted">No. Resi:</span> <span class="text-accent-teal font-mono">{{ $order->tracking_number }}</span></p>
            @endif
        </div>
    </div>

    {{-- Midtrans Payment Section --}}
    @if($order->status === 'pending')
    <div class="bg-bg-card border border-accent-orange/30 rounded-xl p-6 mb-6">
        <h2 class="font-bold mb-2 text-accent-orange">💳 Pembayaran via Midtrans</h2>
        <p class="text-text-muted text-sm mb-4">Klik tombol di bawah untuk melakukan pembayaran melalui Midtrans. Tersedia berbagai metode: QRIS, GoPay, Transfer Bank, Kartu Kredit, dan lainnya.</p>
        
        <div class="bg-bg-secondary rounded-lg p-4 mb-4">
            <div class="flex items-center gap-4 text-sm text-text-secondary">
                <div class="flex items-center gap-2"><span class="text-lg">📱</span> QRIS</div>
                <div class="flex items-center gap-2"><span class="text-lg">🏦</span> Bank Transfer</div>
                <div class="flex items-center gap-2"><span class="text-lg">💳</span> Kartu Kredit</div>
                <div class="flex items-center gap-2"><span class="text-lg">📲</span> E-Wallet</div>
            </div>
        </div>

        @if($snapToken && !str_contains($snapToken, 'MOCK'))
        {{-- Real Midtrans Snap Button --}}
        <button id="pay-button" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-4 rounded-xl transition-all text-lg flex items-center justify-center gap-2">
            <span>🔒</span> Bayar Sekarang — {{ $order->formatted_total }}
        </button>
        @else
        {{-- Simulation button for demo --}}
        <form action="{{ route('orders.simulatePayment', $order) }}" method="POST">
            @csrf
            <button type="submit" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-4 rounded-xl transition-all text-lg flex items-center justify-center gap-2">
                <span>🔒</span> Bayar Sekarang — {{ $order->formatted_total }}
            </button>
            <p class="text-center text-text-muted text-xs mt-2">🧪 Mode Sandbox — Pembayaran akan disimulasikan</p>
        </form>
        @endif
    </div>
    @endif

    {{-- Payment Info (after payment) --}}
    @if($order->payment)
    <div class="bg-bg-card border border-green-500/30 rounded-xl p-6 mb-6">
        <h2 class="font-bold mb-4 text-green-400">✅ Informasi Pembayaran</h2>
        <div class="grid md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-text-muted">Transaction ID</p>
                <p class="font-mono text-accent-cyan">{{ $order->payment->transaction_id }}</p>
            </div>
            <div>
                <p class="text-text-muted">Metode Pembayaran</p>
                <p class="font-medium">{{ strtoupper(str_replace('_', ' ', $order->payment->payment_type)) }}</p>
            </div>
            <div>
                <p class="text-text-muted">Status</p>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->payment->status_color }}">{{ $order->payment->status_label }}</span>
            </div>
            <div>
                <p class="text-text-muted">Waktu Pembayaran</p>
                <p class="font-medium">{{ $order->payment->payment_time?->format('d M Y, H:i') ?? '-' }}</p>
            </div>
            <div>
                <p class="text-text-muted">Jumlah</p>
                <p class="font-bold text-accent-orange">Rp {{ number_format($order->payment->gross_amount, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
    @endif
</div>

@if($order->status === 'pending' && $snapToken && !str_contains($snapToken, 'MOCK'))
{{-- Midtrans Snap.js --}}
<script src="{{ $snapUrl }}" data-client-key="{{ $clientKey }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                fetch('{{ route("midtrans.notification") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result)
                }).finally(() => {
                    window.location.reload();
                });
            },
            onPending: function(result) {
                fetch('{{ route("midtrans.notification") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(result)
                }).finally(() => {
                    window.location.reload();
                });
            },
            onError: function(result) {
                alert('Pembayaran gagal atau dibatalkan.');
            },
            onClose: function() {
                // User closed popup
            }
        });
    });
</script>
@endif
@endsection
