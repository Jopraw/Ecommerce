@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold">Admin <span class="text-accent-orange">Dashboard</span></h1>
            <p class="text-text-muted text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.products.create') }}" class="bg-accent-orange hover:bg-accent-orange-dark text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors">+ Tambah Produk</a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <p class="text-text-muted text-sm">Total Pesanan</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['total_orders'] }}</p>
        </div>
        <div class="bg-bg-card border border-accent-orange/30 rounded-xl p-6">
            <p class="text-text-muted text-sm">Menunggu Verifikasi</p>
            <p class="text-3xl font-bold text-yellow-400 mt-1">{{ $stats['paid_orders'] }}</p>
        </div>
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <p class="text-text-muted text-sm">Pendapatan</p>
            <p class="text-2xl font-bold text-accent-teal mt-1">Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-bg-card border border-border-dark rounded-xl p-6">
            <p class="text-text-muted text-sm">Total Produk</p>
            <p class="text-3xl font-bold mt-1">{{ $stats['total_products'] }}</p>
        </div>
    </div>

    {{-- Quick Links --}}
    <div class="grid md:grid-cols-3 gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="bg-bg-card border border-border-dark rounded-xl p-6 hover:border-accent-orange/50 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-accent-orange/10 rounded-lg flex items-center justify-center text-2xl">📦</div>
            <div>
                <h3 class="font-bold">Kelola Produk</h3>
                <p class="text-text-muted text-sm">{{ $stats['total_products'] }} produk</p>
            </div>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="bg-bg-card border border-border-dark rounded-xl p-6 hover:border-accent-orange/50 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-accent-teal/10 rounded-lg flex items-center justify-center text-2xl">🛒</div>
            <div>
                <h3 class="font-bold">Kelola Pesanan</h3>
                <p class="text-text-muted text-sm">{{ $stats['pending_orders'] }} pending</p>
            </div>
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'paid']) }}" class="bg-bg-card border border-accent-orange/30 rounded-xl p-6 hover:border-accent-orange/50 transition-all flex items-center gap-4">
            <div class="w-12 h-12 bg-yellow-400/10 rounded-lg flex items-center justify-center text-2xl">💳</div>
            <div>
                <h3 class="font-bold text-yellow-400">Verifikasi Pembayaran</h3>
                <p class="text-text-muted text-sm">{{ $stats['paid_orders'] }} menunggu</p>
            </div>
        </a>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-bg-card border border-border-dark rounded-xl overflow-hidden">
        <div class="px-6 py-4 border-b border-border-dark flex items-center justify-between">
            <h2 class="font-bold">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-accent-orange text-sm hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-bg-secondary text-text-muted">
                    <tr>
                        <th class="px-6 py-3 text-left">Order</th>
                        <th class="px-6 py-3 text-left">Customer</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-left">Tanggal</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-dark">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-bg-secondary/50">
                        <td class="px-6 py-4 font-mono text-accent-cyan text-xs">{{ $order->order_number }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4 font-medium">{{ $order->formatted_total }}</td>
                        <td class="px-6 py-4"><span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->status_color }}">{{ $order->status_label }}</span></td>
                        <td class="px-6 py-4 text-text-muted">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-accent-orange hover:underline text-xs">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-text-muted">Belum ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
