<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MotorController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Customer\BookingController;

// --- HALAMAN DEPAN (Redirect ke login atau booking jika sudah login) ---
Route::get('/', function () {
    return view('welcome');
});

// --- AUTHENTICATED ROUTES ---
Route::middleware(['auth'])->group(function () {

    // === ROLE: CUSTOMER (USER) ===
    Route::middleware('role:user')->group(function () {
        // Step 1: Pilih Tanggal
        Route::get('/booking', [BookingController::class, 'step1'])->name('booking.step1');
        
        // Step 2: Cari Motor & Hitung Harga
        Route::post('/booking/search', [BookingController::class, 'step2_search'])->name('booking.search');
        
        // Step 3: Proses Booking & Bayar
        Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');
        
        // Step 4: Sukses
        Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
        
        // History & Upload Bukti (Opsional jika bayar manual)
        Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
    });

    // === ROLE: ADMIN ===
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        // Dashboard (Bisa pakai index transaksi sebagai dashboard)
        Route::get('/dashboard', [TransaksiController::class, 'index'])->name('dashboard');
        
        // Manajemen Motor
        Route::resource('motor', MotorController::class);
        
        // Transaksi (Verifikasi & Pengembalian)
        Route::post('/transaksi/verifikasi/{id}', [TransaksiController::class, 'verifikasi'])->name('transaksi.verifikasi');
        Route::post('/transaksi/kembali/{id}', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembali');
    });

    // Profile Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';