@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-2xl font-bold mb-8">Edit <span class="text-accent-orange">Produk</span></h1>
    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-bg-card border border-border-dark rounded-xl p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                    @foreach(['sneakers' => 'Sneakers & Streetwear', 'formal' => 'Sepatu Formal', 'sandal' => 'Sandal Kasual', 'perawatan' => 'Produk Perawatan'] as $val => $label)
                        <option value="{{ $val }}" {{ old('category', $product->category) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange resize-none">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Stok</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Ukuran (pisahkan dengan koma)</label>
                <input type="text" name="size_options" value="{{ old('size_options', $product->size_options ? implode(', ', $product->size_options) : '') }}" placeholder="38, 39, 40, 41, 42, 43, 44, 45" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Gambar Produk</label>
                @if($product->image)
                    <div class="mb-2"><img src="{{ asset('storage/' . $product->image) }}" class="w-20 h-20 object-cover rounded-lg border border-border-dark"></div>
                @endif
                <input type="file" name="image" accept="image/*" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-sm text-white file:mr-4 file:bg-accent-orange file:text-white file:border-0 file:rounded-lg file:px-4 file:py-2 file:text-sm file:cursor-pointer">
            </div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-border-dark bg-bg-secondary text-accent-orange">
                <span class="text-sm">Produk Aktif</span>
            </label>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-accent-orange hover:bg-accent-orange-dark text-white font-bold px-8 py-3 rounded-xl transition-all">Simpan Perubahan</button>
            <a href="{{ route('admin.products.index') }}" class="bg-bg-card border border-border-dark text-text-secondary hover:text-white px-8 py-3 rounded-xl transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
