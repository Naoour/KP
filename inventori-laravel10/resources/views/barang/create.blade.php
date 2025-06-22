@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Barang</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Barang</label>
            <input 
                type="text" 
                class="form-control" 
                id="nama" 
                name="nama" 
                value="{{ old('nama') }}" 
                required
                minlength="3"
                maxlength="40"
                pattern="[A-Za-z\s]+"
                title="Nama hanya boleh huruf dan minimal 3 huruf, maksimal 40 huruf"
            >
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" id="kategori" name="kategori" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <option value="alat" {{ old('kategori') == 'alat' ? 'selected' : '' }}>Alat</option>
                <option value="bahan" {{ old('kategori') == 'bahan' ? 'selected' : '' }}>Bahan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="fungsi" class="form-label">Fungsi</label>
            <textarea 
                class="form-control" 
                id="fungsi" 
                name="fungsi" 
                rows="3" 
                maxlength="50" 
                required
                pattern="[A-Za-z\s]+"
                title="Fungsi hanya boleh huruf dan spasi, maksimal 50 karakter"
            >{{ old('fungsi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="kondisi" class="form-label">Kondisi</label>
            <select class="form-select" id="kondisi" name="kondisi" required>
                <option value="" disabled selected>Pilih Kondisi</option>
                <option value="baik" {{ old('kondisi') == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="diperbaiki" {{ old('kondisi') == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                <option value="rusak" {{ old('kondisi') == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="" disabled selected>Pilih Status</option>
                <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="tidak dipinjam" {{ old('status') == 'tidak dipinjam' ? 'selected' : '' }}>Tidak Dipinjam</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input 
                type="file" 
                class="form-control" 
                id="foto" 
                name="foto" 
                accept="image/*"
                onchange="validateSize(this)"
                required
            >
            <small class="text-danger">Foto wajib diunggah. Maksimal ukuran 5MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    function validateSize(input) {
        const file = input.files[0];
        if (file && file.size > 5 * 1024 * 1024) {
            alert("Ukuran file tidak boleh lebih dari 5MB");
            input.value = "";
        }
    }
</script>
@endsection