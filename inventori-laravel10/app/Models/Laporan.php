<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peminjaman;
use App\Models\Barang;

class Laporan extends Model
{
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'jenis',
        'waktu',
    ];

    // 📙 Relasi: Laporan milik satu peminjaman
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    // 📕 Relasi: Laporan milik satu barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}