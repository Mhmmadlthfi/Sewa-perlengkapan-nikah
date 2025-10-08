<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Midtrans\Notification;
use Midtrans\Config;
use Midtrans\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function handleCallback(Request $request)
    {
        // Inisialisasi konfigurasi Midtrans (jika belum di AppServiceProvider)
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil notifikasi dari Midtrans
        $notif = new Notification();

        // Cari order berdasarkan order_code
        $order = Order::where('order_code', $notif->order_id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update payment_status sesuai status dari Midtrans
        switch ($notif->transaction_status) {
            case 'settlement':
                $order->payment_status = 'paid';
                break;
            case 'pending':
                $order->payment_status = 'pending';
                break;
            case 'expire':
                $order->payment_status = 'expired';
                break;
            case 'cancel':
            case 'deny':
                $order->payment_status = 'failed';
                break;
            default:
                $order->payment_status = 'unpaid';
        }

        // Simpan response notifikasi ke payment_response
        $order->payment_response = json_encode([
            'transaction_status' => $notif->transaction_status,
            'transaction_id' => $notif->transaction_id,
            'order_id' => $notif->order_id,
            'payment_type' => $notif->payment_type,
            'gross_amount' => $notif->gross_amount,
            'currency' => $notif->currency,
            'transaction_time' => $notif->transaction_time,
            'status_code' => $notif->status_code,
            'signature_key' => $notif->signature_key,
            'fraud_status' => $notif->fraud_status ?? null,
            'settlement_time' => $notif->settlement_time ?? null,
        ]);
        $order->save();

        return response()->json(['message' => 'Payment status updated']);
    }

    public function finish(Request $request)
    {
        $orderId = $request->query('order_id');
        $transactionStatus = $request->query('transaction_status');

        if (auth()->check()) {
            return redirect()->route('order.index', [
                'order' => $orderId,
                'transaction_status' => $transactionStatus,
            ]);
        }

        // Customer (mobile)
        return redirect(route('payment.finish', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
        ]));
    }

    public function checkStatus($order_code)
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');

        $order = Order::where('order_code', $order_code)->firstOrFail();

        $status = Transaction::status($order->order_code);

        if ($status->transaction_status === 'expire' && $order->payment_status !== 'expired') {
            $order->payment_status = 'expired';
            $order->save();
        }

        return response()->json([
            'order_code' => $order->order_code,
            'payment_status' => $order->payment_status,
            'midtrans_status' => $status->transaction_status,
        ]);
    }
}
