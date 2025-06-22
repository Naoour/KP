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
            <input 
                type="text" 
                class="form-control" 
                id="nama" 
                name="nama" 
                value="{{ old('nama', $barang->nama) }}" 
                required 
                minlength="3" 
                maxlength="40"
                pattern="[A-Za-z\s]+" 
                title="Nama hanya boleh huruf dan spasi, minimal 3 huruf dan maksimal 40 huruf"
            >
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
            <textarea 
                class="form-control" 
                id="fungsi" 
                name="fungsi" 
                rows="3" 
                required 
                maxlength="50"
                pattern="[A-Za-z\s]+"
                title="Fungsi hanya boleh huruf dan spasi, maksimal 50 karakter"
            >{{ old('fungsi', $barang->fungsi) }}</textarea>
        </div>

        @php
            $isDipinjam = $barang->status === 'dipinjam';
        @endphp
        <div class="mb-3">
            <label for="kondisi" class="form-label">Kondisi</label>
            <select class="form-select" id="kondisi" name="kondisi" {{ $isDipinjam ? 'disabled' : '' }} required>
                <option value="baik" {{ old('kondisi', $barang->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="diperbaiki" {{ old('kondisi', $barang->kondisi) == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                <option value="rusak" {{ old('kondisi', $barang->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
            </select>
            @if($isDipinjam)
                <input type="hidden" name="kondisi" value="{{ $barang->kondisi }}">
                <small class="text-danger">Kondisi tidak bisa diubah karena barang sedang dipinjam.</small>
            @endif
        </div>

        @php
            $isRusakAtauPerbaikan = in_array($barang->kondisi, ['rusak', 'diperbaiki']);
            $statusDisabled = $isDipinjam || $isRusakAtauPerbaikan;
        @endphp
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" {{ $statusDisabled ? 'disabled' : '' }} required>
                <option value="dipinjam" {{ old('status', $barang->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                <option value="tidak dipinjam" {{ old('status', $barang->status) == 'tidak dipinjam' ? 'selected' : '' }}>Tidak Dipinjam</option>
            </select>
            @if($statusDisabled)
                <input type="hidden" name="status" value="{{ $barang->status }}">
                <small class="text-danger">
                    Status tidak bisa diubah karena 
                    {{ $isDipinjam ? 'barang sedang dipinjam' : 'kondisi barang tidak baik' }}.
                </small>
            @endif
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto</label><br>
            @if($barang->foto)
                <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" width="120" class="mb-2"><br>
            @endif
            <input 
                type="file" 
                class="form-control" 
                id="foto" 
                name="foto" 
                accept="image/*" 
                onchange="validateSize(this)"
                required
            >
            <small class="text-danger">Wajib unggah foto baru. Maksimal ukuran 5MB.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
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