<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;  // <-- import model Peminjaman

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kategori',
        'fungsi',
        'kondisi',
        'status',
        'foto',
    ];

    public function peminjaman()
    {
        return $this->hasOne(Peminjaman::class);
    }
}