<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MotorController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Customer\BookingController;

// --- 1. HALAMAN DEPAN (LANDING PAGE) ---
Route::get('/', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
})->name('home');

// --- 2. GROUP USER (CUSTOMER) ---
Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    
    // Step 1
    Route::get('/booking', [BookingController::class, 'step1'])->name('booking.step1');
    Route::post('/booking/search', [BookingController::class, 'processStep1'])->name('booking.search'); // Ubah nama function
    
    // Step 2 (BARU: Pisahkan Route GET agar aman saat refresh/validasi error)
    Route::get('/booking/select-bike', [BookingController::class, 'step2'])->name('booking.step2'); 

    // Step 3 & Payment
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/payment/{id}', [BookingController::class, 'payment'])->name('booking.payment');
    Route::post('/booking/payment/{id}', [BookingController::class, 'processPayment'])->name('booking.process_payment');
    Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
    Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
});

// --- 3. GROUP ADMIN (Tetap) ---
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('motor', MotorController::class);
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/verifikasi/{id}', [TransaksiController::class, 'verifikasi'])->name('transaksi.verifikasi');
    Route::post('/transaksi/kembali/{id}', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembali');
    Route::resource('users', AdminUserController::class);
});

// --- 4. PROFILE ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';