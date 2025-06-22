<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PeminjamanController extends Controller
{
    public function create(Request $request)
    {
        $barangs = Barang::where('status', 'tidak dipinjam')
                         ->where('kondisi', 'baik')
                         ->get();
        $selectedBarangId = $request->barang_id;
        return view('peminjaman.create', compact('barangs', 'selectedBarangId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tujuan' => 'required|string',
            'foto' => 'nullable',
        ]);

        $barang = Barang::where('id', $request->barang_id)
                        ->where('status', 'tidak dipinjam')
                        ->where('kondisi', 'baik')
                        ->first();

        if (!$barang) {
            return back()->withErrors(['barang_id' => 'Barang tidak valid atau tidak tersedia untuk dipinjam.']);
        }

        $peminjaman = new Peminjaman();
        $peminjaman->user_id = auth()->id();
        $peminjaman->barang_id = $barang->id;
        $peminjaman->tujuan = $request->tujuan;
        $peminjaman->tanggal = now();

        if ($request->filled('foto')) {
            $imageData = $request->input('foto');

            if (preg_match('/^data:image\/(\w+);base64,/', $imageData)) {
                $image = Image::make($imageData)->encode('jpg', 90);
                $fileName = time() . '.jpg';
                $path = 'peminjaman_foto/' . $fileName;
                Storage::disk('public')->put($path, $image);
                $peminjaman->foto = $path;
            }
        }

        $peminjaman->save();

        $barang->status = 'dipinjam';
        $barang->save();

        return redirect()->route('dashboard')->with('success', 'Peminjaman berhasil!');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = $peminjaman->barang;
        $barang->status = 'tidak dipinjam';
        $barang->save();
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