<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motor extends Model
{
    use HasFactory;

    protected $table = 'tbl_motor';
    protected $guarded = ['id']; // Semua kolom bisa diisi kecuali ID

    // Relasi: Satu motor bisa ada di banyak pesanan (history)
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'id_motor');
    }
}