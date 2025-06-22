@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Verifikasi Peminjaman</h3>

    <div class="mb-3">
        <label>Nama Peminjam</label>
        <input type="text" class="form-control" value="{{ $peminjaman->user->name }}" readonly>
    </div>

    <div class="mb-3">
        <label>Barang</label>
        <input type="text" class="form-control" value="{{ $peminjaman->barang->nama }}" readonly>
    </div>

    <div class="mb-3">
        <label>Tujuan</label>
        <input type="text" class="form-control" value="{{ $peminjaman->tujuan }}" readonly>
    </div>

    @if($peminjaman->foto)
        <div class="mb-3">
            <label>Foto Bukti/Surat</label><br>
            <img src="{{ asset('storage/' . $peminjaman->foto) }}" width="100%" style="max-width: 400px;">
        </div>
    @endif

    <form action="{{ route('keluarmasuk.proses', $peminjaman->id) }}" method="POST">
        @csrf
        <button class="btn btn-success">✔️ Proses Sekarang</button>
        <a href="{{ route('keluarmasuk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection