<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MidtransWebhookController;
use App\Models\Booking;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::middleware(['auth'])->group(function () {
});
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);
Route::post('/bookings/{booking}/pay', [BookingController::class, 'pay'])->name('bookings.pay');
Route::resource('bookings', BookingController::class);
Route::get('/bookings/data', [BookingController::class, 'getBookings'])->name('bookings.data');
