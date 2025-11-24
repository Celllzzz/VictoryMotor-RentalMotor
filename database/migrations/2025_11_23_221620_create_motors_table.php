<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_motor', function (Blueprint $table) {
            $table->id();
            $table->string('nama');      // Contoh: Vario 160
            $table->string('merk');      // Manual input: Honda (Pengganti tabel merk)
            $table->string('warna');
            $table->string('no_polisi')->unique();
            $table->integer('tahun_beli');
            $table->integer('harga_sewa'); // Harga per hari
            $table->string('gambar');
            $table->enum('status', ['tersedia', 'disewa'])->default('tersedia');
            
            // Tidak ada foreign key ke tbl_merk lagi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motors');
    }
};
