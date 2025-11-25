<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// Import Controller Admin
use App\Http\Controllers\Admin\MotorController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
// Import Controller User
use App\Http\Controllers\Customer\BookingController;

// --- 1. HALAMAN DEPAN & REDIRECT LOGIN ---
Route::get('/', function () {
    if (auth()->check()) {
        // Cek role untuk redirect ke dashboard yang benar
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard');
    }
    return view('welcome');
});

// --- 2. ROUTE YANG BUTUH LOGIN (AUTH) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // === A. USER / CUSTOMER ROUTES ===
    // Dashboard User (Hanya bisa diakses role:user)
    Route::get('/dashboard', [BookingController::class, 'dashboard'])
        ->middleware('role:user')
        ->name('dashboard');

    // Group Fitur User
    Route::middleware('role:user')->group(function () {
        // Flow Booking
        Route::get('/booking', [BookingController::class, 'step1'])->name('booking.step1');
        Route::post('/booking/search', [BookingController::class, 'step2_search'])->name('booking.search');
        Route::post('/booking/process', [BookingController::class, 'processBooking'])->name('booking.process');
        Route::get('/booking/success', [BookingController::class, 'success'])->name('booking.success');
        
        // History
        Route::get('/history', [BookingController::class, 'history'])->name('booking.history');
    });


    // === B. ADMIN ROUTES ===
    // Semua route admin ada di bawah prefix '/admin'
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Motor (CRUD Otomatis: index, create, store, edit, update, destroy)
        Route::resource('motor', MotorController::class);
        
        // Manajemen Transaksi
        // 1. Halaman List Transaksi (Ini yang sebelumnya error 'Route Not Found')
        Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
        
        // 2. Proses Verifikasi (Terima/Tolak)
        Route::post('/transaksi/verifikasi/{id}', [TransaksiController::class, 'verifikasi'])->name('transaksi.verifikasi');
        
        // 3. Proses Pengembalian (Selesai)
        Route::post('/transaksi/kembali/{id}', [TransaksiController::class, 'kembalikan'])->name('transaksi.kembalikan');

        // Manajemen Admina
        Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class);
    });


    // === C. PROFILE ROUTES (Bawaan Breeze) ===
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';