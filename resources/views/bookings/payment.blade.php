@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pembayaran Booking #{{ $booking->id }}</h2>
    <p>Total: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function () {
            snap.pay("{{ $snapToken }}", {
                onSuccess: function(result){
                    alert("Pembayaran berhasil!");
                    window.location.href = "{{ route('bookings.index') }}";
                },
                onPending: function(result){
                    alert("Menunggu pembayaran...");
                },
                onError: function(result){
                    alert("Pembayaran gagal!");
                }
            });
        };
    </script>
</div>
@endsection
