<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    /**
     * Create Snap token for an order
     */
    public static function createSnapToken(Order $order): ?string
    {
        $order->load('items.product', 'user');

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number . '-' . time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => $order->shipping_name,
                'email' => $order->user->email,
                'phone' => $order->shipping_phone,
                'shipping_address' => [
                    'first_name' => $order->shipping_name,
                    'phone' => $order->shipping_phone,
                    'address' => $order->shipping_address,
                ],
            ],
            'item_details' => [],
        ];

        foreach ($order->items as $item) {
            $params['item_details'][] = [
                'id' => (string) $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => substr($item->product->name ?? 'Produk', 0, 50),
            ];
        }

        $serverKey = config('midtrans.server_key');
        $apiUrl = config('midtrans.api_url') . '/snap/v1/transactions' ;

        // For sandbox demo, if the server key is default/placeholder, return a mock token
        if (str_contains($serverKey, 'XXXX')) {
            Log::info('Midtrans: Using mock snap token (no real server key configured)');
            return 'MOCK-SNAP-' . strtoupper(substr(md5($order->order_number . time()), 0, 16));
        }

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->post('https://app.sandbox.midtrans.com/snap/v1/transactions', $params);

            if ($response->successful()) {
                return $response->json('token');
            }

            Log::error('Midtrans Snap Error', ['response' => $response->json()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Midtrans Exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Verify notification signature
     */
    public static function verifySignature(array $notification): bool
    {
        $serverKey = config('midtrans.server_key');
        $orderId = $notification['order_id'] ?? '';
        $statusCode = $notification['status_code'] ?? '';
        $grossAmount = $notification['gross_amount'] ?? '';

        $expectedSignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        $actualSignature = $notification['signature_key'] ?? '';

        return $expectedSignature === $actualSignature;
    }
}
