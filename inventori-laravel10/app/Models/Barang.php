<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;
use App\Models\Laporan;

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

    // 📗 Relasi: Satu barang bisa dipinjam berkali-kali
    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // 📕 Relasi: Satu barang bisa muncul di banyak laporan
    public function laporans()
    {
        return $this->hasMany(Laporan::class);
    }
}