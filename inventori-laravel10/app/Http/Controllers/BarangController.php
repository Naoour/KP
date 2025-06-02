<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Tampilkan semua barang
    public function index()
    {
        $barangs = Barang::all();
        return view('barang.index', compact('barangs'));
    }

    // Tampilkan form tambah barang (hanya admin)
    public function create()
    {
        return view('barang.create');
    }

    // Simpan barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'fungsi' => 'required',
            'kondisi' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto_barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    // Tampilkan form edit barang (hanya admin)
    public function edit(Barang $barang)
    {
        return view('barang.edit', compact('barang'));
    }

    // Update data barang
    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'fungsi' => 'required',
            'kondisi' => 'required',
            'status' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto && \Storage::disk('public')->exists($barang->foto)) {
                \Storage::disk('public')->delete($barang->foto);
            }
            $data['foto'] = $request->file('foto')->store('foto_barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diupdate');
    }

    // Hapus barang
    public function destroy(Barang $barang)
    {
        if ($barang->foto && \Storage::disk('public')->exists($barang->foto)) {
            \Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }
}
