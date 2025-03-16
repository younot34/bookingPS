<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller {
    public function index()
    {
        return view('bookings.index');
    }

    public function create() {
        return view('bookings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'console' => 'required|in:ps4,ps5',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Hitung durasi dalam jam
        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $total_hours = $start->diffInHours($end);

        // Tentukan harga per jam
        $pricePerHour = ($request->console == 'ps4') ? 30000 : 40000;
        $totalPrice = $total_hours * $pricePerHour;
        if ($start->isWeekend()) {
            $totalPrice += 50000;
        }

        // Buat booking di database
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'console' => $request->console,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_price' => $totalPrice,
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi
        $transaction = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        // Buat Snap Token Midtrans
        $snapToken = Snap::getSnapToken($transaction);

        // Redirect ke halaman pembayaran
        return view('bookings.payment', compact('snapToken', 'booking'));
    }

    public function pay(Booking $booking)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Gunakan true untuk live
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Data transaksi
        $transaction = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id,
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        // Buat Snap Token Midtrans
        $snapToken = Snap::getSnapToken($transaction);

        // Redirect ke halaman pembayaran
        return view('bookings.payment', compact('snapToken', 'booking'));
    }

    public function destroy(Booking $booking) {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibatalkan.');
    }

    public function getBookings()
    {
        $bookings = Booking::all();

        $events = [];

        foreach ($bookings as $booking) {
            $events[] = [
                'title' => $booking->console,
                'start' => $booking->start_time->format('Y-m-d\TH:i:s'),
                'end' => $booking->end_time->format('Y-m-d\TH:i:s'),
                'color' => ($booking->console === 'ps4') ? '#007bff' : '#28a745',
            ];
        }

        return response()->json($events);
    }
}
