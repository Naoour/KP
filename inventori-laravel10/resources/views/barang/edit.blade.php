@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Barang</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $barang->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="alat" {{ old('kategori', $barang->kategori) == 'alat' ? 'selected' : '' }}>Alat</option>
                <option value="bahan" {{ old('kategori', $barang->kategori) == 'bahan' ? 'selected' : '' }}>Bahan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fungsi" class="form-label">Fungsi</label>
            <textarea class="form-control" id="fungsi" name="fungsi" rows="3" required>{{ old('fungsi', $barang->fungsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="kondisi" class="form-label">Kondisi</label>
            <select class="form-select" id="kondisi" name="kondisi" required>
                <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="diperbaiki" {{ old('kondisi', $barang->kondisi) == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                <option value="rusak" {{ old('kondisi', $barang->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="dipinjam" {{ old('status', $barang->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="tidak dipinjam" {{ old('status', $barang->status) == 'tidak dipinjam' ? 'selected' : '' }}>Tidak Dipinjam</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto (opsional)</label><br>
            @if($barang->foto)
                <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" width="120" class="mb-2"><br>
            @endif
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
