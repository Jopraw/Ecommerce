@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Kelola <span class="text-accent-orange">Pesanan</span></h1>
        <div class="flex gap-2">
            @foreach(['all' => 'Semua', 'pending' => 'Pending', 'paid' => 'Dibayar', 'processing' => 'Diproses', 'shipped' => 'Dikirim', 'completed' => 'Selesai'] as $key => $label)
                <a href="{{ route('admin.orders.index', $key === 'all' ? [] : ['status' => $key]) }}" class="px-3 py-1 rounded-lg text-xs font-medium {{ request('status') === $key || ($key === 'all' && !request('status')) ? 'bg-accent-orange text-white' : 'bg-bg-card border border-border-dark text-text-secondary hover:text-white' }} transition-colors">{{ $label }}</a>
            @endforeach
        </div>
    </div>
    <div class="bg-bg-card border border-border-dark rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-bg-secondary text-text-muted">
                    <tr>
                        <th class="px-4 py-3 text-left">Order</th>
                        <th class="px-4 py-3 text-left">Customer</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-dark">
                    @forelse($orders as $order)
                    <tr class="hover:bg-bg-secondary/50">
                        <td class="px-4 py-3 font-mono text-accent-cyan text-xs">{{ $order->order_number }}</td>
                        <td class="px-4 py-3">{{ $order->user->name }}</td>
                        <td class="px-4 py-3 text-right font-medium text-accent-orange">{{ $order->formatted_total }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium {{ $order->status_color }}">{{ $order->status_label }}</span></td>
                        <td class="px-4 py-3 text-text-muted">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.orders.show', $order) }}" class="text-accent-orange hover:underline text-xs">Detail</a></td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-text-muted">Tidak ada pesanan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $orders->links() }}</div>
</div>
@endsection
