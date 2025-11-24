<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesan extends Model
{
    protected $table = 'tbl_pemesan';
    protected $guarded = ['id'];

    // Relasi ke User (Akun login)
    public function akun()
    {
        return $this->belongsTo(User::class, 'id_akun');
    }

    // Relasi ke Pesanan (1 Data Pemesan = 1 Transaksi)
    public function pesanan()
    {
        return $this->hasOne(Pesanan::class, 'id_pemesan');
    }
}