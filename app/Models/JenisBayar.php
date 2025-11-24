<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisBayar extends Model
{
    protected $table = 'tbl_jenis_bayar';
    protected $guarded = ['id'];

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_jenis_bayar');
    }
}