<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pesanan, Motor};
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Load data pesanan lengkap dengan relasi
        $pesanans = Pesanan::with(['pemesan', 'motor', 'jenisBayar'])->latest()->get();
        return view('admin.dashboard', compact('pesanans'));
    }

    public function verifikasi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        if ($request->aksi == 'terima') {
            $pesanan->update(['status' => 'disetujui']);
            
            // Ubah status motor jadi 'disewa' agar tidak muncul di pencarian user
            Motor::where('id', $pesanan->id_motor)->update(['status' => 'disewa']);
        } else {
            $pesanan->update(['status' => 'ditolak']);
        }

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function kembalikan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        // Tandai selesai
        $pesanan->update(['status' => 'selesai']);
        
        // Motor tersedia kembali
        Motor::where('id', $pesanan->id_motor)->update(['status' => 'tersedia']);

        return back()->with('success', 'Motor telah dikembalikan.');
    }
}