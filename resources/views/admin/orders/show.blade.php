@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('admin.orders.index') }}" class="text-text-muted hover:text-white text-sm mb-4 inline-flex items-center gap-1">← Kembali</a>
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Pesanan <span class="text-accent-cyan">{{ $order->order_number }}</span></h1>
        <span class="px-4 py-2 rounded-full text-sm font-medium {{ $order->status_color }}">{{ $order->status_label }}</span>
    </div>

    {{-- Customer & Shipping --}}
    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <h3 class="font-bold mb-3 text-accent-orange">Info Customer</h3>
            <p class="text-sm text-text-secondary">{{ $order->user->name }}</p>
            <p class="text-sm text-text-muted">{{ $order->user->email }}</p>
        </div>
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <h3 class="font-bold mb-3 text-accent-orange">Info Pengiriman</h3>
            <p class="text-sm text-text-secondary">{{ $order->shipping_name }} · {{ $order->shipping_phone }}</p>
            <p class="text-sm text-text-muted mt-1">{{ $order->shipping_address }}</p>
        </div>
    </div>

    {{-- Items --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6 mb-6">
        <h3 class="font-bold mb-4">Produk Dipesan</h3>
        @foreach($order->items as $item)
        <div class="flex items-center justify-between py-3 {{ !$loop->last ? 'border-b border-border-dark' : '' }}">
            <div class="flex items-center gap-3">
                @if($item->product && $item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-12 h-12 object-cover rounded-lg border border-border-dark">
                @else
                    <div class="w-12 h-12 bg-bg-secondary rounded-lg flex items-center justify-center text-xl">👟</div>
                @endif
                <div>
                    <p class="font-medium text-sm">{{ $item->product->name ?? 'Dihapus' }}</p>
                    <p class="text-text-muted text-xs">Ukuran: {{ $item->size ?? '-' }} · Qty: {{ $item->quantity }}</p>
                </div>
            </div>
            <p class="font-bold text-sm">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
        </div>
        @endforeach
        <div class="border-t border-border-dark mt-2 pt-4 flex justify-between font-bold text-lg">
            <span>Total</span>
            <span class="text-accent-orange">{{ $order->formatted_total }}</span>
        </div>
    </div>

    {{-- Payment Info from Midtrans --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6 mb-6">
        <h3 class="font-bold mb-4 text-accent-cyan">💳 Informasi Pembayaran (Midtrans)</h3>
        @if($order->payment)
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
                <p class="text-text-muted">Status Pembayaran</p>
                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $order->payment->status_color }}">{{ $order->payment->status_label }}</span>
            </div>
            <div>
                <p class="text-text-muted">Waktu Pembayaran</p>
                <p class="font-medium">{{ $order->payment->payment_time?->format('d M Y, H:i') ?? '-' }}</p>
            </div>
            <div>
                <p class="text-text-muted">Jumlah Dibayar</p>
                <p class="font-bold text-accent-orange">Rp {{ number_format($order->payment->gross_amount, 0, ',', '.') }}</p>
            </div>
        </div>

        {{-- Payment History --}}
        @if($order->payments->count() > 1)
        <div class="mt-6 border-t border-border-dark pt-4">
            <h4 class="font-medium text-sm mb-3 text-text-muted">Riwayat Transaksi</h4>
            <div class="space-y-2">
                @foreach($order->payments->sortByDesc('created_at') as $p)
                <div class="flex items-center justify-between text-xs bg-bg-secondary rounded-lg px-4 py-2">
                    <span class="font-mono text-text-muted">{{ $p->transaction_id }}</span>
                    <span class="{{ $p->status_color }} px-2 py-0.5 rounded-full">{{ $p->status_label }}</span>
                    <span class="text-text-muted">{{ $p->created_at->format('d/m/Y H:i') }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        @else
        <p class="text-text-muted text-sm">Belum ada data pembayaran. Customer belum melakukan pembayaran melalui Midtrans.</p>
        @endif
    </div>

    {{-- Update Status --}}
    <div class="bg-bg-card border border-border-dark rounded-xl p-6">
        <h3 class="font-bold mb-4">Update Status</h3>
        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-4">
            @csrf @method('PATCH')
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Status</label>
                    <select name="status" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                        @foreach(['pending' => 'Pending', 'paid' => 'Sudah Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'] as $val => $label)
                            <option value="{{ $val }}" {{ $order->status === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">No. Resi (opsional)</label>
                    <input type="text" name="tracking_number" value="{{ $order->tracking_number }}" placeholder="Masukkan no resi..." class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                </div>
            </div>
            <button type="submit" class="bg-accent-orange hover:bg-accent-orange-dark text-white font-medium px-6 py-2 rounded-lg transition-colors">Update Status</button>
        </form>
    </div>
</div>
@endsection
