<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Midtrans\Config;
use Midtrans\Transaction;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Ambil data dari Midtrans
        $notification = $request->all();
        $transactionStatus = $notification['transaction_status'];
        $orderId = $notification['order_id'];

        // Cari booking berdasarkan order_id
        $booking = Booking::where('id', $orderId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status berdasarkan transaksi Midtrans
        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            $booking->status = 'paid';
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $booking->status = 'canceled';
        }

        $booking->save();

        return response()->json(['message' => 'Success']);
    }
}
