<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data peminjaman lengkap dengan relasi barang dan user
        $peminjamans = Peminjaman::with(['barang', 'user'])->get();

        // Kirim data ke view dashboard, variabel harus sama
        return view('dashboard', compact('peminjamans'));
    }
}
