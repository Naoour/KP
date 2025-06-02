@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Selamat datang, {{ auth()->user()->name }}</h2>
    <p>Ini adalah dashboard inventori.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <hr>
    <h4>Barang yang Sedang Dipinjam</h4>

    @if($peminjamans->isEmpty())
        <p class="text-muted">Tidak ada barang yang sedang dipinjam.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Tujuan</th>
                        <th>Tanggal Pinjam</th>
                        <th>Dipinjam Oleh</th>
                        @if(auth()->user()->role === 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamans as $pinjam)
                    <tr>
                        <td>{{ $pinjam->barang->nama }}</td>
                        <td>{{ $pinjam->barang->status }}</td>
                        <td>{{ $pinjam->tujuan }}</td>
                        <td>{{ $pinjam->tanggal }}</td>
                        <td>{{ $pinjam->user->name }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td class="text-center">
                            <form action="{{ route('peminjaman.destroy', $pinjam->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data peminjaman ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
