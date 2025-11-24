<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Motor, Pesanan, Merk, JenisBayar, Perjalanan};

class DashboardController extends Controller
{
    public function index()
    {
        // Data untuk Card Statistik
        $totalMotor = Motor::count();
        $pesananPending = Pesanan::where('status', 'pending')->count();
        $totalOmset = Pesanan::where('status', 'selesai')->sum('total_harga');
        
        // Data Master untuk ditampilkan di halaman dashboard/settings (opsional)
        $merks = Merk::all();
        $bayars = JenisBayar::all();
        $rutes = Perjalanan::all();

        return view('admin.dashboard', compact('totalMotor', 'pesananPending', 'totalOmset', 'merks', 'bayars', 'rutes'));
    }

    // --- LOGIC MASTER DATA (Simpel Create/Delete) ---

    public function storeMerk(Request $request) {
        Merk::create($request->validate(['merk' => 'required']));
        return back()->with('success', 'Merk ditambahkan');
    }

    public function destroyMerk($id) {
        Merk::destroy($id);
        return back()->with('success', 'Merk dihapus');
    }

    public function storeBayar(Request $request) {
        JenisBayar::create($request->validate(['jenis_bayar' => 'required']));
        return back()->with('success', 'Metode bayar ditambahkan');
    }

    public function destroyBayar($id) {
        JenisBayar::destroy($id);
        return back()->with('success', 'Metode bayar dihapus');
    }

    public function storeRute(Request $request) {
        Perjalanan::create($request->validate([
            'asal' => 'required',
            'tujuan' => 'required',
            'jarak' => 'required|numeric'
        ]));
        return back()->with('success', 'Rute ditambahkan');
    }

    public function destroyRute($id) {
        Perjalanan::destroy($id);
        return back()->with('success', 'Rute dihapus');
    }
}