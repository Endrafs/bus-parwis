<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Landing Page — daftar bus tersedia
Route::get('/', [BusController::class, 'index'])->name('home');

// Detail Bus
Route::get('/bus/{bus}', [BusController::class, 'show'])->name('bus.show');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Pelanggan)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Booking Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Form pemesanan
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    // Simpan booking
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    // Riwayat booking saya
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');

    // Upload pembayaran
    Route::get('/booking/{kodeBooking}/payment', [PaymentController::class, 'create'])->name('payment.create');
    // Simpan pembayaran
    Route::post('/booking/{kodeBooking}/payment', [PaymentController::class, 'store'])->name('payment.store');

    // Detail booking (berdasarkan kode_booking) — harus setelah payment routes
    Route::get('/booking/{kodeBooking}', [BookingController::class, 'show'])->name('booking.show');
});

require __DIR__.'/auth.php';
