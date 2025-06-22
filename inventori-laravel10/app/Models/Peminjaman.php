<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Barang;
use App\Models\Laporan;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'barang_id',
        'tujuan',
        'tanggal',
        'tanggal_kembali',
        'status_proses',
    ];

    // Peminjaman dimiliki oleh satu user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Peminjaman dimiliki oleh satu barang
    public function barang(){
        return $this->belongsTo(Barang::class);
    }

    // relasi 1:N
    public function laporans(){
        return $this->hasMany(Laporan::class);
    }

    // kalo pengen 1:1 ganti ini
    // public function laporan(){
    //     return $this->hasOne(Laporan::class);
    // }
}
