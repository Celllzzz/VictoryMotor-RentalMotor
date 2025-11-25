<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motor;

class MotorSeeder extends Seeder
{
    public function run(): void
    {
        $motors = [
            [
                'nama' => 'Vario 160 ABS',
                'merk' => 'Honda',
                'warna' => 'Hitam Matte',
                'no_polisi' => 'H 4567 XY',
                'tahun_beli' => 2024,
                'harga_sewa' => 100000,
                'gambar' => 'https://placehold.co/600x400/black/white?text=Vario+160', // Link Gambar
                'status' => 'tersedia'
            ],
            [
                'nama' => 'NMAX 155 Connected',
                'merk' => 'Yamaha',
                'warna' => 'Abu-abu',
                'no_polisi' => 'H 9988 AB',
                'tahun_beli' => 2023,
                'harga_sewa' => 130000,
                'gambar' => 'https://placehold.co/600x400/grey/white?text=NMAX+155',
                'status' => 'tersedia'
            ],
            [
                'nama' => 'Vespa Sprint S',
                'merk' => 'Piaggio',
                'warna' => 'Kuning',
                'no_polisi' => 'H 1234 VV',
                'tahun_beli' => 2022,
                'harga_sewa' => 200000,
                'gambar' => 'https://placehold.co/600x400/F4E06D/black?text=Vespa+Sprint',
                'status' => 'disewa' // Simulasi sedang disewa
            ],
            [
                'nama' => 'Beat Street',
                'merk' => 'Honda',
                'warna' => 'Hitam',
                'no_polisi' => 'H 2233 CC',
                'tahun_beli' => 2021,
                'harga_sewa' => 80000,
                'gambar' => 'https://placehold.co/600x400/black/white?text=Beat+Street',
                'status' => 'tersedia'
            ],
            [
                'nama' => 'PCX 160',
                'merk' => 'Honda',
                'warna' => 'Putih',
                'no_polisi' => 'H 7766 DD',
                'tahun_beli' => 2023,
                'harga_sewa' => 140000,
                'gambar' => 'https://placehold.co/600x400/white/black?text=PCX+160',
                'status' => 'tersedia'
            ],
        ];

        foreach ($motors as $motor) {
            // Cek biar tidak duplikat no polisi saat seeding ulang
            if (!Motor::where('no_polisi', $motor['no_polisi'])->exists()) {
                Motor::create($motor);
            }
        }
    }
}