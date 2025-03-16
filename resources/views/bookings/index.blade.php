@extends('layouts.app')

@section('content')
<div class="container">
    <h2>🎮 Daftar Booking</h2>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary mb-3">Buat Booking</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container">
        <h2>📅 Kalender Booking</h2>
        <div id="calendar"></div>
    </div>
</div>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/bootstrap5@6.1.15/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          themeSystem: 'bootstrap5',
          events: function(fetchInfo, successCallback, failureCallback) {
            fetch("{{ route('bookings.data') }}")
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => failureCallback(error));
        }
        });
        calendar.render();
      });
</script>
@endsection
<style>
    #calendar {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
    }
</style>
