@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold">Kelola <span class="text-accent-orange">Produk</span></h1>
        <a href="{{ route('admin.products.create') }}" class="bg-accent-orange hover:bg-accent-orange-dark text-white font-medium px-4 py-2 rounded-lg text-sm transition-colors">+ Tambah Produk</a>
    </div>
    <div class="bg-bg-card border border-border-dark rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-bg-secondary text-text-muted">
                    <tr>
                        <th class="px-4 py-3 text-left">Produk</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-right">Harga</th>
                        <th class="px-4 py-3 text-center">Stok</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-dark">
                    @foreach($products as $product)
                    <tr class="hover:bg-bg-secondary/50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-bg-secondary rounded-lg flex items-center justify-center text-lg shrink-0">
                                    @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-lg"> @else 👟 @endif
                                </div>
                                <span class="font-medium truncate max-w-[200px]">{{ $product->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 capitalize text-text-secondary">{{ $product->category }}</td>
                        <td class="px-4 py-3 text-right font-medium text-accent-orange">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">{{ $product->stock }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs {{ $product->is_active ? 'text-green-400 bg-green-400/10' : 'text-gray-400 bg-gray-400/10' }}">{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-accent-cyan hover:underline text-xs mr-3">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-400 hover:underline text-xs">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
