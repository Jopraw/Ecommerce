<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
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
                'order_id' => $order->order_number,
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
        $snapApiUrl = config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        // For sandbox demo, if the server key is default/placeholder, return a mock token
        if (str_contains($serverKey, 'XXXX')) {
            Log::info('Midtrans: Using mock snap token (no real server key configured)');
            return 'MOCK-SNAP-' . strtoupper(substr(md5($order->order_number . time()), 0, 16));
        }

        try {
            $response = Http::withBasicAuth($serverKey, '')
                ->acceptJson()
                ->post($snapApiUrl, $params);

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
     * Query Midtrans API directly to sync transaction status for a pending order
     */
    public static function syncTransactionStatus(Order $order): bool
    {
        $serverKey = config('midtrans.server_key');
        if (!$serverKey || str_contains($serverKey, 'XXXX')) {
            return false;
        }

        // Check both exact order_number and any stored midtrans order_id from previous payment logs
        $candidateIds = array_unique(array_filter([
            $order->payment?->raw_response['order_id'] ?? null,
            $order->order_number,
        ]));

        $apiUrl = config('midtrans.api_url');

        foreach ($candidateIds as $midtransOrderId) {
            try {
                $response = Http::withBasicAuth($serverKey, '')
                    ->acceptJson()
                    ->timeout(5)
                    ->get("{$apiUrl}/{$midtransOrderId}/status");

                if (!$response->successful()) {
                    continue;
                }

                $data = $response->json();
                $statusCode = (string) ($data['status_code'] ?? '');
                if (!in_array($statusCode, ['200', '201', '202'])) {
                    continue;
                }

                $transactionStatus = $data['transaction_status'] ?? '';
                $paymentType = $data['payment_type'] ?? '';
                $transactionId = $data['transaction_id'] ?? $midtransOrderId;
                $grossAmount = $data['gross_amount'] ?? $order->total_price;

                Payment::updateOrCreate(
                    ['transaction_id' => $transactionId],
                    [
                        'order_id' => $order->id,
                        'payment_type' => $paymentType,
                        'gross_amount' => $grossAmount,
                        'transaction_status' => $transactionStatus,
                        'payment_time' => $data['settlement_time'] ?? $data['transaction_time'] ?? now(),
                        'raw_response' => $data,
                    ]
                );

                $newStatus = match ($transactionStatus) {
                    'capture', 'settlement' => 'paid',
                    'pending' => 'pending',
                    'deny', 'cancel' => 'cancelled',
                    'expire' => 'expired',
                    default => $order->status,
                };

                if ($order->status === 'pending' && $newStatus !== 'pending') {
                    $order->update(['status' => $newStatus]);
                }

                return true;
            } catch (\Exception $e) {
                Log::warning('Midtrans status check failed', ['message' => $e->getMessage()]);
            }
        }

        return false;
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
