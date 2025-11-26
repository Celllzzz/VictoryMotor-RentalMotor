<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motor;
use App\Models\Pesanan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalMotor = Motor::count();
        $motorTersedia = Motor::where('status', 'tersedia')->count();
        $motorDisewa = Motor::where('status', 'disewa')->count();
        
        // 2. Transaksi
        // Menghitung pesanan yang butuh verifikasi (Pending)
        $pesananDibayar = Pesanan::where('status', 'dibayar')->count();
        
        // Menghitung total pendapatan (hanya dari yang selesai/disetujui)
        $totalPendapatan = Pesanan::whereIn('status', ['selesai', 'disetujui'])->sum('total_harga');

        // 3. Data Terbaru untuk Tabel (5 Pesanan Terakhir)
        $recentOrders = Pesanan::with(['motor', 'pemesan'])
                        ->latest()
                        ->take(5)
                        ->get();

        return view('admin.dashboard', compact(
            'totalMotor', 
            'motorTersedia', 
            'motorDisewa', 
            'pesananDibayar', 
            'totalPendapatan',
            'recentOrders'
        ));
    }
    
}