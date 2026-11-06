<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $order->load('items.product', 'payment', 'payments');

        $snapToken = $order->snap_token;
        $clientKey = config('midtrans.client_key');
        $snapUrl = config('midtrans.snap_url');

        return view('orders.show', compact('order', 'snapToken', 'clientKey', 'snapUrl'));
    }
}
