<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Motor, Pesanan, Pemesan, JenisBayar};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Step 1: Pilih Tanggal
    public function step1()
    {
        return view('customer.booking.step1');
    }

    // Step 2: Cari Motor
    public function processStep1(Request $request)
    {
        $request->validate([
            'tgl_pinjam' => 'required|date|after_or_equal:now',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        // Hitung Durasi
        $start = Carbon::parse($request->tgl_pinjam);
        $end = Carbon::parse($request->tgl_kembali);
        $durasiHari = ceil($start->floatDiffInHours($end) / 24);
        if ($durasiHari < 1) $durasiHari = 1;

        // Simpan ke Session
        session([
            'booking_start' => $request->tgl_pinjam,
            'booking_end' => $request->tgl_kembali,
            'booking_days' => $durasiHari
        ]);

        // Redirect ke Route GET (Agar URL berubah jadi /booking/select-bike)
        return redirect()->route('booking.step2');
    }

    // 2. Tampilkan Halaman Step 2 (Aman untuk Refresh/Redirect Back)
    public function step2()
    {
        // Cek jika user akses langsung tanpa input tanggal
        if (!session()->has('booking_start')) {
            return redirect()->route('booking.step1');
        }

        $durasiHari = session('booking_days');
        $motors = Motor::where('status', 'tersedia')->get();
        $jenisBayar = JenisBayar::all(); 

        return view('customer.booking.step2', compact('motors', 'durasiHari', 'jenisBayar'));
    }

    // Step 3: Simpan Draft Pesanan (Status: Belum Bayar)
    public function store(Request $request)
    {
        $request->validate([
            'id_motor' => 'required',
            'id_jenis_bayar' => 'required',
            'foto_ktp' => 'required|image|max:2048', // Wajib, Gambar, Max 2MB
            'alamat' => 'required|string',
            'nik'            => 'required|numeric|digits:16', 
            'jk'             => 'required|in:L,P',
        ]);

        $tglPinjam = session('booking_start');
        $tglKembali = session('booking_end');
        $durasi = session('booking_days');
        $motor = Motor::findOrFail($request->id_motor);
        $totalHarga = $motor->harga_sewa * $durasi;
        $user = Auth::user();

        // Simpan KTP
        $pathKtp = null;
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('ktp_pemesan', 'public');
        }

        $pemesan = Pemesan::create([
            'id_akun' => $user->id,
            'nama' => $user->nama,
            'nik'           => $request->nik,
            'alamat' => $request->alamat ?? '-', 
            'jenis_kelamin' => $request->jk,
            'foto_ktp' => $pathKtp
        ]);

        // Status awal 'pending_payment' (Menunggu Pembayaran)
        // Pastikan enum di database mendukung atau pakai string
        $pesanan = Pesanan::create([
            'tgl_pinjam' => $tglPinjam,
            'tgl_kembali' => $tglKembali,
            'total_harga' => $totalHarga,
            'status' => 'pending', // Kita anggap pending = menunggu verifikasi admin (setelah upload)
            'id_pemesan' => $pemesan->id,
            'id_motor' => $motor->id,
            'id_jenis_bayar' => $request->id_jenis_bayar
        ]);

        // Redirect ke Halaman Pembayaran
        return redirect()->route('booking.payment', $pesanan->id);
    }

    // Step 4: Halaman Pembayaran (Timer)
    public function payment($id)
    {
        $pesanan = Pesanan::with(['motor', 'jenisBayar'])->findOrFail($id);
        
        // Cek deadline (Misal 1 jam dari waktu create)
        $deadline = $pesanan->created_at->addHour();
        
        return view('customer.booking.payment', compact('pesanan', 'deadline'));
    }

    // Step 5: Proses Upload Bukti
    public function processPayment(Request $request, $id)
    {
        $request->validate(['bukti_bayar' => 'required|image|max:2048']);
        
        $pesanan = Pesanan::findOrFail($id);
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        
        $pesanan->update([
            'bukti_bayar' => $path,
            'status' => 'dibayar' // Masuk ke admin untuk diverifikasi
        ]);

        return redirect()->route('booking.success');
    }

    public function success() { return view('customer.booking.success'); }

    public function history(Request $request)
    {
        $query = Pesanan::whereHas('pemesan', function($q){
            $q->where('id_akun', Auth::id());
        })->with(['motor', 'jenisBayar']);

        // Filter Search (ID Pesanan atau Nama Motor)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('motor', function($subQ) use ($search) {
                      $subQ->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        // Filter Status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $perPage = $request->per_page ?? 10;
        $pesanans = $query->latest()->paginate($perPage)->withQueryString();

        if ($request->ajax()) {
            return view('customer.history', compact('pesanans'))->render(); 
            // Note: Pada practice Laravel modern biasanya partial view, 
            // tapi mengikuti pola referensi admin Anda yang me-replace container, kita return view utuh.
        }

        return view('customer.history', compact('pesanans'));
    }
}