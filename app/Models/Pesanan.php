<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'tbl_pesanan';
    protected $guarded = ['id'];

    // Casting agar otomatis jadi object Carbon (Date & Time)
    protected $casts = [
        'tgl_pinjam' => 'datetime',
        'tgl_kembali' => 'datetime',
    ];

    public function motor()
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    public function pemesan()
    {
        return $this->belongsTo(Pemesan::class, 'id_pemesan');
    }

    public function jenisBayar()
    {
        return $this->belongsTo(JenisBayar::class, 'id_jenis_bayar');
    }
}