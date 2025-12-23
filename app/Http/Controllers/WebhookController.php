<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $xenditXCallbackToken = $request->header('x-callback-token');
        // Ambil data dari request Xendit
        $data = $request->all();
        Log::info('Xendit Webhook Received:', $data);
        
        // Pastikan ada external_id (Nomor Invoice)
        $externalId = $data['external_id'] ?? null;
        $status = $data['status'] ?? null;

        if (!$externalId || !$status) {
            return response()->json(['message' => 'Invalid data'], 400);
        }

        // Cari Order berdasarkan Number
        $order = Order::where('number', $externalId)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->payment_status == '2' && $status == 'PAID') {
            return response()->json(['message' => 'Order already paid']);
        }

        DB::beginTransaction();
        try {
            if ($status === 'PAID') {
                // Jika user sudah bayar
                $order->update([
                    'payment_status' => '2',       // 2 = Paid
                    'order_status'   => 'processing' // Masuk tahap pengerjaan
                ]);
            } elseif ($status === 'EXPIRED') {
                // Jika waktu habis (12 jam lewat)
                $order->update([
                    'payment_status' => '3',       // 3 = Expired
                    'order_status'   => 'cancelled' // Order dibatalkan
                ]);
            }

            DB::commit();
            return response()->json(['message' => 'Webhook received successfully']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Webhook Error: ' . $e->getMessage());
            return response()->json(['message' => 'Error updating order'], 500);
        }
    }
}