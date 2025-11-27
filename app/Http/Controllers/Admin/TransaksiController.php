<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Pesanan, Motor};
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['pemesan', 'motor', 'jenisBayar']);

        // 1. SMART SEARCH (Cari Nama User, Nama Motor, Plat Nomor, atau ID)
        if ($request->has('search') && $request->search != '') {
            $keywords = explode(' ', $request->search);

            $query->where(function($q) use ($keywords) {
                foreach ($keywords as $word) {
                    $q->where(function($subQ) use ($word) {
                        // Cari di relasi Pemesan
                        $subQ->whereHas('pemesan', function($userQ) use ($word) {
                            $userQ->where('nama', 'like', "%{$word}%");
                        })
                        // Cari di relasi Motor
                        ->orWhereHas('motor', function($motorQ) use ($word) {
                            $motorQ->where('nama', 'like', "%{$word}%")
                                ->orWhere('no_polisi', 'like', "%{$word}%");
                        })
                        // Cari ID Transaksi
                        ->orWhere('id', 'like', "%{$word}%");
                    });
                }
            });
        }

        // 2. Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 10);
        $pesanans = $query->latest()->paginate($perPage)->withQueryString();

        return view('admin.transaksi.index', compact('pesanans'));
    }

    /**
     * Verifikasi Pesanan (Terima atau Tolak).
     */
    public function verifikasi(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        if ($request->aksi == 'terima') {
            // 1. Ubah status pesanan jadi 'disetujui'
            $pesanan->update(['status' => 'disetujui']);
            
            // 2. Ubah status motor jadi 'disewa' agar tidak bisa dibooking orang lain
            Motor::where('id', $pesanan->id_motor)->update(['status' => 'disewa']);
            
            return back()->with('success', 'Order successfully APPROVED. The motorcycle is now RENTED.');
        } else {
            // Jika ditolak, status jadi 'ditolak', motor tetap 'tersedia'
            $pesanan->update(['status' => 'ditolak']);
            
            return back()->with('success', 'Order successfully REJECTED.');
        }
    }

    /**
     * Proses Pengembalian Motor (Selesai).
     */
    public function kembalikan($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        // Validasi: Hanya pesanan yang sedang berjalan (disetujui) yang bisa dikembalikan
        if ($pesanan->status != 'disetujui') {
            return back()->with('error', 'Only orders with the status "Approved" can be processed to completion.');
        }

        // 1. Tandai pesanan selesai
        $pesanan->update(['status' => 'selesai']);
        
        // 2. Motor kembali tersedia untuk disewa
        Motor::where('id', $pesanan->id_motor)->update(['status' => 'tersedia']);
        
        return back()->with('success', 'The motorcycle has been RETURNED. Transaction Completed.');
    }
}