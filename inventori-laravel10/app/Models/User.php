<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Peminjaman;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // 📘 Relasi: Satu user bisa melakukan banyak peminjaman
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}