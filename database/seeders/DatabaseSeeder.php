<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, JenisBayar};

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Admin & Test User
        $this->call(AdminSeeder::class);
        
        // 2. Jenis Bayar
        if(JenisBayar::count() == 0){
            JenisBayar::insert([
                ['jenis_bayar' => 'VA BANK'],
                ['jenis_bayar' => 'QRIS'],
            ]);
        }

        // 3. Motor & Pesanan (BARU)
        $this->call([
            MotorSeeder::class,
            PesananSeeder::class,
        ]);
    }
}