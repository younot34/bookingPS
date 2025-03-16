@extends('layouts.app')

@section('content')
<div class="container">
    <h2>📅 Buat Booking</h2>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Pilih Konsol</label>
            <select name="console" class="form-control">
                <option value="ps4">PS4 - Rp 30.000 / jam</option>
                <option value="ps5">PS5 - Rp 40.000 / jam</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Mulai</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Selesai</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">📌 Booking Sekarang</button>
    </form>
</div>
@endsection
