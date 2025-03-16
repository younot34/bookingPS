<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Booking PS') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="bg-dark text-white vh-100 p-3" style="width: 250px;">
            <h4 class="text-center">Dashboard</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('home') }}">🏠 Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('roles.index') }}">🔑 Manajemen Role</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('bookings.index') }}">🎮 Booking PS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        🚪 Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Top Bar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
                <div class="container-fluid">
                    <span class="navbar-brand">
                        👋 Halo, {{ auth()->check() ? Auth::user()->name : 'Guest' }}
                    </span>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container mt-4">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
