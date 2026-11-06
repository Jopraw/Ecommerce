@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-bg-card border border-border-dark rounded-xl p-6">
                    <h2 class="text-lg font-bold mb-4 text-accent-orange">Informasi Pengiriman</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Nama Penerima</label>
                            <input type="text" name="shipping_name" value="{{ old('shipping_name', auth()->user()->name) }}" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                            @error('shipping_name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">No. Telepon</label>
                            <input type="tel" name="shipping_phone" value="{{ old('shipping_phone') }}" required placeholder="08xx-xxxx-xxxx" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                            @error('shipping_phone') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Alamat Lengkap</label>
                            <textarea name="shipping_address" rows="3" required placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos" class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange resize-none">{{ old('shipping_address') }}</textarea>
                            @error('shipping_address') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Catatan (opsional)</label>
                            <textarea name="notes" rows="2" placeholder="Catatan untuk pesanan..." class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange resize-none">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-bg-card border border-border-dark rounded-xl p-6 sticky top-24">
                    <h2 class="text-lg font-bold mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-3 mb-4">
                        @foreach($cartItems as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-text-secondary truncate mr-2">{{ $item->product->name }} x{{ $item->quantity }}</span>
                            <span class="shrink-0">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                    <div class="border-t border-border-dark pt-4 flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span class="text-accent-orange">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <button type="submit" class="w-full mt-6 bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-4 rounded-xl transition-all glow-orange-hover">
                        Buat Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
