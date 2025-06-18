@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Keluar/Masuk Barang</h2>

    <table class="table table-bordered mt-3">
        <thead class="table-success">
            <tr>
                <th>User</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $peminjaman)
                <tr>
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->barang->nama }}</td>
                    <td>{{ $peminjaman->tanggal }}</td>
                    <td>{{ $peminjaman->tanggal_kembali ?? 'Belum dikembalikan' }}</td>
                    <td>
                        @if($peminjaman->status_proses == 'telah diproses')
                            <span class="badge bg-success">Telah Diproses</span>
                        @else
                            <span class="badge bg-warning">Menunggu Admin</span>
                        @endif
                    </td>
                    <td class="d-flex gap-2">
                        {{-- Tombol untuk admin memproses --}}
                        @if(auth()->user()->role == 'admin' && $peminjaman->status_proses == 'diproses')
                            <form action="{{ route('keluarmasuk.proses', $peminjaman->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">✔️ Proses</button>
                            </form>
                        @endif

                        {{-- Tombol kembalikan hanya muncul untuk user & setelah admin proses --}}
                        @if(auth()->user()->id == $peminjaman->user_id)
                            @if($peminjaman->tanggal_kembali)
                                <span class="badge bg-info">Sudah Dikembalikan</span>
                            @elseif($peminjaman->status_proses == 'telah diproses')
                                <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-sm btn-danger">🔁 Kembalikan</button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>Menunggu Proses Admin</button>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
