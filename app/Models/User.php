<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'tbl_akun'; // Custom table name

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'role', // 'admin' or 'user'
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: Satu user bisa punya banyak history data pemesan
    public function pemesan()
    {
        return $this->hasMany(Pemesan::class, 'id_akun');
    }
}