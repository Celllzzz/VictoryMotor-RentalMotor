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
        Schema::create('tbl_pesanan', function (Blueprint $table) {
            $table->id();
            
            // PENTING: Pakai dateTime untuk tanggal & jam
            $table->dateTime('tgl_pinjam'); 
            $table->dateTime('tgl_kembali');
            
            $table->integer('total_harga');
            $table->enum('status', ['pending', 'dibayar', 'disetujui', 'selesai', 'ditolak'])->default('pending');
            $table->string('bukti_bayar')->nullable();
            
            // Foreign Keys
            $table->foreignId('id_pemesan')->constrained('tbl_pemesan')->onDelete('cascade');
            $table->foreignId('id_motor')->constrained('tbl_motor')->onDelete('cascade');
            $table->foreignId('id_jenis_bayar')->constrained('tbl_jenis_bayar');
            
            // Hapus id_perjalanan
            $table->timestamps();
        });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
