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
        Schema::create('tbl_pemesan', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Nama sesuai KTP
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('foto_ktp');
            $table->foreignId('id_akun')->constrained('tbl_akun')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesans');
    }
};
