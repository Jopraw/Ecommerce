<a href="{{ route('shop.show', $product) }}" class="product-card bg-bg-card rounded-xl overflow-hidden border border-border-dark group block">
    <div class="aspect-square bg-bg-secondary flex items-center justify-center overflow-hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        @else
            <div class="text-text-muted text-5xl group-hover:scale-110 transition-transform duration-300">👟</div>
        @endif
    </div>
    <div class="p-4">
        <div class="flex items-center justify-between gap-1 mb-1">
            <span class="text-xs font-bold text-accent-cyan uppercase tracking-wider">{{ $product->brand ?? 'AstroStep' }}</span>
            <span class="text-[10px] text-text-muted uppercase tracking-wider">{{ $product->category }}</span>
        </div>
        <h3 class="font-semibold text-sm truncate" title="{{ $product->name }}">{{ $product->name }}</h3>
        <div class="flex items-center justify-between mt-3">
            <span class="text-accent-orange font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
            <form action="{{ route('cart.store') }}" method="POST" onclick="event.stopPropagation();">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="size" value="{{ $product->size_options[0] ?? '' }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-8 h-8 rounded-lg bg-bg-secondary hover:bg-accent-orange flex items-center justify-center transition-colors" title="Tambah ke keranjang">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </button>
            </form>
        </div>
    </div>
</a>
