<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    /**
     * Handle Midtrans payment notification (webhook)
     */
    public function notification(Request $request)
    {
        $notification = $request->all();
        Log::info('Midtrans Notification Received', $notification);

        // Extract order_number from order_id (format: AS-YYYYMMDD-XXXX-timestamp)
        $orderId = $notification['order_id'] ?? '';
        // Remove the timestamp suffix we added when creating snap token
        $orderNumber = preg_replace('/-\d+$/', '', $orderId);

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            Log::warning('Midtrans: Order not found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        $transactionStatus = $notification['transaction_status'] ?? '';
        $paymentType = $notification['payment_type'] ?? '';
        $transactionId = $notification['transaction_id'] ?? $orderId;
        $grossAmount = $notification['gross_amount'] ?? $order->total_price;

        // Save payment record
        Payment::updateOrCreate(
            ['transaction_id' => $transactionId],
            [
                'order_id' => $order->id,
                'payment_type' => $paymentType,
                'gross_amount' => $grossAmount,
                'transaction_status' => $transactionStatus,
                'payment_time' => $notification['transaction_time'] ?? now(),
                'raw_response' => $notification,
            ]
        );

        // Update order status based on transaction status
        $newStatus = match($transactionStatus) {
            'capture', 'settlement' => 'paid',
            'pending' => 'pending',
            'deny', 'cancel' => 'cancelled',
            'expire' => 'expired',
            default => $order->status,
        };

        // Only update if the new status is a valid progression
        if ($order->status === 'pending' || in_array($newStatus, ['cancelled', 'expired'])) {
            $order->update(['status' => $newStatus]);
        }

        return response()->json(['message' => 'OK']);
    }

    /**
     * Simulate payment success (for demo/testing without real Midtrans)
     */
    public function simulatePayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) abort(403);
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan ini sudah tidak bisa dibayar.');
        }

        // Create mock payment record
        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => 'MOCK-' . strtoupper(substr(md5(time()), 0, 12)),
            'payment_type' => 'qris',
            'gross_amount' => $order->total_price,
            'transaction_status' => 'settlement',
            'payment_time' => now(),
            'raw_response' => ['simulated' => true, 'note' => 'Demo payment - Midtrans Sandbox'],
        ]);

        $order->update(['status' => 'paid']);

        return redirect()->back()->with('success', 'Pembayaran berhasil! (Simulasi Midtrans Sandbox)');
    }
}
