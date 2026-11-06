<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        $total = $cartItems->sum('subtotal');
        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'nullable|string',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $existing = Cart::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->where('size', $request->size)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->get('quantity', 1));
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'size' => $request->size,
                'quantity' => $request->get('quantity', 1),
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);

        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);

        return redirect()->back()->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) abort(403);
        $cart->delete();
        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}
