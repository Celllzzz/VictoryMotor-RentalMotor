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
        Schema::table('tbl_pemesan', function (Blueprint $table) {
            // Menambahkan kolom NIK setelah nama, tipe string agar 0 di depan tidak hilang
            $table->string('nik', 16)->after('nama'); 
        });
    }

    public function down(): void
    {
        Schema::table('tbl_pemesan', function (Blueprint $table) {
            $table->dropColumn('nik');
        });
    }
};
