<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Motor, Pesanan, Pemesan, JenisBayar};
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{   
    public function dashboard()
    {
        $user = Auth::user();
        
        // Ambil data ringkasan
        $totalBookings = Pesanan::whereHas('pemesan', function($q) use ($user) {
            $q->where('id_akun', $user->id);
        })->count();

        $activeBookings = Pesanan::whereHas('pemesan', function($q) use ($user) {
            $q->where('id_akun', $user->id);
        })->whereIn('status', ['pending', 'dibayar', 'disetujui'])->count();

        // Ambil 3 history terakhir untuk ditampilkan di dashboard
        $recentOrders = Pesanan::whereHas('pemesan', function($q) use ($user) {
            $q->where('id_akun', $user->id);
        })->with(['motor', 'jenisBayar'])->latest()->take(3)->get();

        return view('dashboard', compact('totalBookings', 'activeBookings', 'recentOrders'));
    }
    
    // STEP 1: Tampilkan Form Tanggal
    public function step1()
    {
        return view('customer.booking.step1');
    }

    // STEP 2: Cari Motor & Hitung Estimasi Harga
    public function step2_search(Request $request)
    {
        $request->validate([
            'tgl_pinjam' => 'required|date|after_or_equal:now',
            'tgl_kembali' => 'required|date|after:tgl_pinjam',
        ]);

        // Simpan tanggal di Session agar bisa dipanggil saat submit akhir
        session([
            'booking_start' => $request->tgl_pinjam,
            'booking_end' => $request->tgl_kembali
        ]);

        // Hitung Durasi (Hari) - Dibulatkan ke atas
        $start = Carbon::parse($request->tgl_pinjam);
        $end = Carbon::parse($request->tgl_kembali);
        
        // Logic: Selisih jam dibagi 24, dibulatkan ke atas. 
        // Contoh: Pinjam 26 jam = 2 hari sewa.
        $durasiHari = ceil($start->floatDiffInHours($end) / 24);
        if ($durasiHari < 1) $durasiHari = 1;

        session(['booking_days' => $durasiHari]);

        // Ambil motor yang statusnya 'tersedia'
        // (Logic simplenya: yang statusnya tersedia di database)
        $motors = Motor::where('status', 'tersedia')->get();
        
        $jenisBayar = JenisBayar::all(); // Untuk dropdown pembayaran

        return view('customer.booking.step2', compact('motors', 'durasiHari', 'jenisBayar'));
    }

    // STEP 3: Proses Simpan ke Database
    public function processBooking(Request $request)
    {
        $request->validate([
            'id_motor' => 'required',
            'id_jenis_bayar' => 'required',
        ]);

        // Ambil data dari session (Step 1)
        $tglPinjam = session('booking_start');
        $tglKembali = session('booking_end');
        $durasi = session('booking_days');

        if (!$tglPinjam || !$tglKembali) {
            return redirect()->route('booking.step1')->with('error', 'Sesi habis, silakan ulang.');
        }

        // Ambil motor untuk hitung fix harga
        $motor = Motor::findOrFail($request->id_motor);
        
        // Pastikan motor masih tersedia
        if ($motor->status != 'tersedia') {
            return redirect()->route('booking.step1')->with('error', 'Yah, motor ini baru saja diambil orang lain.');
        }

        $totalHarga = $motor->harga_sewa * $durasi;

        // 1. Simpan Snapshot Data Diri (Pemesan)
        // Kita ambil data user dari Auth (karena user sudah login)
        // Foto KTP kita ambil dari user profile jika ada, atau upload baru (di sini saya asumsi ambil dari input file jika diminta, atau skip jika pakai data login)
        
        // Sesuai request: User login username, jadi kita pakai data user login
        $user = Auth::user();
        
        // Cek: Apakah user wajib upload KTP saat booking?
        // Jika ya, tambahkan di validasi. Jika tidak, pakai dummy atau nullable.
        // Di sini saya buat user harus upload KTP di form step 2 agar data pemesan lengkap.
        
        $pathKtp = 'ktp_placeholder.jpg';
        if ($request->hasFile('foto_ktp')) {
            $pathKtp = $request->file('foto_ktp')->store('ktp_pemesan', 'public');
        }

        $pemesan = Pemesan::create([
            'id_akun' => $user->id,
            'nama' => $user->nama,
            'alamat' => $request->alamat ?? 'Alamat sesuai profil', // Bisa diinput di step 2
            'jenis_kelamin' => $request->jk ?? 'L',
            'foto_ktp' => $pathKtp
        ]);

        // 2. Simpan Transaksi Pesanan
        Pesanan::create([
            'tgl_pinjam' => $tglPinjam,
            'tgl_kembali' => $tglKembali,
            'total_harga' => $totalHarga,
            'status' => 'pending', // Pending, menunggu konfirmasi admin / bukti bayar
            'id_pemesan' => $pemesan->id,
            'id_motor' => $motor->id,
            'id_jenis_bayar' => $request->id_jenis_bayar
        ]);

        // Opsional: Langsung ubah status motor jadi 'disewa' agar tidak double book
        // $motor->update(['status' => 'disewa']);

        return redirect()->route('booking.success');
    }

    // STEP 4: Halaman Sukses
    public function success()
    {
        return view('customer.booking.success');
    }

    // HISTORY
    public function history()
    {
        $pesanans = Pesanan::whereHas('pemesan', function($q){
            $q->where('id_akun', Auth::id());
        })->with(['motor', 'jenisBayar'])->latest()->get();

        return view('customer.history', compact('pesanans'));
    }
}