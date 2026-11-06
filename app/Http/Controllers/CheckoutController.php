<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }
        $total = $cartItems->sum('subtotal');
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
        ]);

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $total = $cartItems->sum('subtotal');

        DB::transaction(function () use ($request, $cartItems, $total, &$order) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'shipping_name' => $request->shipping_name,
                'shipping_phone' => $request->shipping_phone,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'size' => $item->size,
                    'price' => $item->product->price,
                ]);

                // Kurangi stok
                $item->product->decrement('stock', $item->quantity);
            }

            // Kosongkan keranjang
            Cart::where('user_id', auth()->id())->delete();
        });

        // Generate Midtrans Snap Token
        $snapToken = MidtransService::createSnapToken($order);
        if ($snapToken) {
            $order->update(['snap_token' => $snapToken]);
        }

        return redirect()->route('orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
