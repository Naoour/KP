<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class KeluarMasukController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'barang')->latest()->get();

        $showAnyAction = $peminjamans->some(fn($p) =>
            ($p->status_proses === 'diproses' && auth()->user()->role == 'admin') ||
            (auth()->user()->id == $p->user_id && is_null($p->tanggal_kembali))
        );

        return view('keluarmasuk.index', compact('peminjamans', 'showAnyAction'));
    }

    public function proses($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_proses = 'telah diproses';
        $peminjaman->tanggal = now(); // ✅ Simpan waktu proses saat ini
        $peminjaman->save();

        return redirect()->route('keluarmasuk.index')->with('success', 'Peminjaman telah diproses.');
    }

    // ✅ Tambahan method untuk menampilkan form proses detail
    public function formProses($id)
    {
        $peminjaman = Peminjaman::with('user', 'barang')->findOrFail($id);
        return view('keluarmasuk.form-proses', compact('peminjaman'));
    }
}