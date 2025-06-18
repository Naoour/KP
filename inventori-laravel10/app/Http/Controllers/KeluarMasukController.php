<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class KeluarMasukController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'barang')->latest()->get();
        return view('keluarmasuk.index', compact('peminjamans'));
    }

    public function proses($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_proses = 'telah diproses';
        $peminjaman->save();

        return redirect()->route('keluarmasuk.index')->with('success', 'Peminjaman telah diproses.');
    }

}
