<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Pesanan, Pemesan, User, Motor, JenisBayar};
use Carbon\Carbon;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil User 'Test User' atau buat baru jika tidak ada
        $user = User::where('email', 'test@example.com')->first() ?? User::factory()->create([
            'nama' => 'Test User',
            'email' => 'test@example.com',
            'role' => 'user'
        ]);

        // Ambil Data Pendukung
        $motor1 = Motor::where('nama', 'Vespa Sprint S')->first(); // Yang statusnya 'disewa' tadi
        $motor2 = Motor::where('nama', 'Vario 160 ABS')->first();
        $jenisBayar = JenisBayar::first(); // Ambil pembayaran pertama (Transfer BCA)

        // Pastikan motor & jenis bayar ada (untuk safety)
        if (!$motor1 || !$jenisBayar) {
            $this->command->info('Motor atau Jenis Bayar belum di-seed. Jalankan MotorSeeder dulu.');
            return;
        }

        // --- KASUS 1: PESANAN YANG SUDAH SELESAI (HISTORY) ---
        // 1. Buat Data Pemesan (Snapshot User saat itu)
        $pemesan1 = Pemesan::create([
            'id_akun' => $user->id,
            'nama' => $user->nama,
            'alamat' => 'Jl. Simpang Lima No. 1, Semarang',
            'jenis_kelamin' => 'L',
            'foto_ktp' => 'https://placehold.co/600x400?text=Foto+KTP+User' // Link KTP
        ]);

        // 2. Buat Pesanan Selesai
        Pesanan::create([
            'id_pemesan' => $pemesan1->id,
            'id_motor' => $motor2->id, // Vario
            'id_jenis_bayar' => $jenisBayar->id,
            'tgl_pinjam' => Carbon::now()->subDays(5), // 5 hari lalu
            'tgl_kembali' => Carbon::now()->subDays(3), // 3 hari lalu
            'total_harga' => $motor2->harga_sewa * 2, // 2 hari
            'status' => 'selesai',
            'bukti_bayar' => 'https://placehold.co/400x600?text=Struk+Lunas'
        ]);

        // --- KASUS 2: PESANAN AKTIF (SEDANG DISEWA) ---
        // 1. Buat Data Pemesan Baru (Misal user ganti alamat/transaksi baru)
        $pemesan2 = Pemesan::create([
            'id_akun' => $user->id,
            'nama' => $user->nama,
            'alamat' => 'Jl. Pemuda No. 10, Semarang', // Alamat beda dikit
            'jenis_kelamin' => 'L',
            'foto_ktp' => 'https://placehold.co/600x400?text=Foto+KTP+User'
        ]);

        // 2. Buat Pesanan Aktif (Disetujui)
        Pesanan::create([
            'id_pemesan' => $pemesan2->id,
            'id_motor' => $motor1->id, // Vespa (Status di MotorSeeder sudah 'disewa')
            'id_jenis_bayar' => $jenisBayar->id,
            'tgl_pinjam' => Carbon::now()->subDays(1), // Kemarin
            'tgl_kembali' => Carbon::now()->addDays(1), // Besok
            'total_harga' => $motor1->harga_sewa * 2,
            'status' => 'disetujui',
            'bukti_bayar' => 'https://placehold.co/400x600?text=Struk+DP'
        ]);

        // --- KASUS 3: PESANAN PENDING (BARU BOOKING) ---
        $pemesan3 = Pemesan::create([
            'id_akun' => $user->id,
            'nama' => $user->nama,
            'alamat' => 'Jl. Pemuda No. 10, Semarang',
            'jenis_kelamin' => 'L',
            'foto_ktp' => 'https://placehold.co/600x400?text=Foto+KTP+User'
        ]);

        Pesanan::create([
            'id_pemesan' => $pemesan3->id,
            'id_motor' => $motor2->id, // Vario lagi (ceritanya mau sewa lagi)
            'id_jenis_bayar' => $jenisBayar->id,
            'tgl_pinjam' => Carbon::now()->addDays(2),
            'tgl_kembali' => Carbon::now()->addDays(4),
            'total_harga' => $motor2->harga_sewa * 2,
            'status' => 'pending',
            'bukti_bayar' => null // Belum bayar
        ]);
    }
}