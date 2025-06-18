<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function create(Request $request)
    {
        $barangs = Barang::where('status', 'tidak dipinjam')->get();
        $selectedBarangId = $request->barang_id; // tangkap dari URL jika ada
        return view('peminjaman.create', compact('barangs', 'selectedBarangId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tujuan' => 'required|string',
        ]);

        Peminjaman::create([
            'user_id' => auth()->id(),
            'barang_id' => $request->barang_id,
            'tujuan' => $request->tujuan,
            'tanggal' => now(),
        ]);

        $barang = Barang::find($request->barang_id);
        $barang->status = 'dipinjam';
        $barang->save();

        return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // Ubah status barang jadi "tidak dipinjam"
        $barang = $peminjaman->barang;
        $barang->status = 'tidak dipinjam';
        $barang->save();

        // Hapus data peminjaman
        $peminjaman->delete();

        return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil dihapus dan barang dikembalikan.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->user_id !== auth()->id()) {
            abort(403);
        }

        $peminjaman->tanggal_kembali = now();
        $peminjaman->save();

        $barang = $peminjaman->barang;
        $barang->status = 'tidak dipinjam';
        $barang->save();

        return redirect()->route('keluarmasuk.index')->with('success', 'Barang telah dikembalikan');
    }
}
