@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Daftar Barang</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(auth()->user()->role == 'admin')
        <a href="{{ route('barang.create') }}" class="btn btn-success mb-3">Tambah Barang</a>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-success text-center">
                <tr>
                    <th>Foto</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Fungsi</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                    <th class="text-center" style="min-width: 160px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $barang)
                <tr class="{{ $barang->status == 'dipinjam' ? 'opacity-50' : '' }}">
                    <td class="text-center">
                        @if($barang->foto && file_exists(public_path('storage/' . $barang->foto)))
                            <img src="{{ asset('storage/' . $barang->foto) }}" width="80" height="80" style="object-fit: cover;">
                        @else
                            <span class="text-muted">Tidak Ada</span>
                        @endif
                    </td>
                    <td>{{ $barang->nama }}</td>
                    <td>{{ $barang->kategori }}</td>
                    <td>{{ $barang->fungsi }}</td>
                    <td class="text-center">
                        @if($barang->kondisi == 'baik')
                            <span class="badge bg-success px-3 py-2">Baik</span>
                        @elseif($barang->kondisi == 'diperbaiki')
                            <span class="badge bg-warning text-dark px-3 py-2">Diperbaiki</span>
                        @elseif($barang->kondisi == 'rusak')
                            <span class="badge bg-danger px-3 py-2">Rusak</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">Tidak Diketahui</span>
                        @endif
                    </td>
                    <td>{{ $barang->status }}</td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            @if(auth()->user()->role == 'admin')
                                <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-outline-warning d-flex align-items-center gap-1">
                                    ✏️ <span>Edit</span>
                                </a>
                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger d-flex align-items-center gap-1">
                                        🗑️ <span>Hapus</span>
                                    </button>
                                </form>
                            @elseif(auth()->user()->role == 'user' && $barang->status == 'tidak dipinjam' && $barang->kondisi == 'baik')
                                <a href="{{ route('peminjaman.create', ['barang_id' => $barang->id]) }}" class="btn btn-sm btn-primary d-flex align-items-center gap-1">
                                    📄 <span>Ajukan Peminjaman</span>
                                </a>
                            @else
                                <span class="text-muted fst-italic">Tidak tersedia</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
