@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Keluar/Masuk Barang</h2>

    @if(auth()->user()->role == 'user')
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary mb-3">+ Ajukan Peminjaman</a>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-success">
            <tr>
                <th>User</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                @if($showAnyAction)
                    <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $peminjaman)
                @php
                    $showProcessBtn = auth()->user()->role == 'admin' && $peminjaman->status_proses == 'diproses';
                    $showReturnBtn = auth()->user()->id == $peminjaman->user_id && is_null($peminjaman->tanggal_kembali) && $peminjaman->status_proses == 'telah diproses';
                    $alreadyReturned = auth()->user()->id == $peminjaman->user_id && $peminjaman->tanggal_kembali;
                    $showActions = $showProcessBtn || $showReturnBtn || $alreadyReturned;
                @endphp
                <tr>
                    <td>{{ $peminjaman->user->name }}</td>
                    <td>{{ $peminjaman->barang->nama }}</td>

                    {{-- Tanggal Pinjam --}}
                    <td>
                        @if($peminjaman->status_proses == 'telah diproses')
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal)->format('d-m-Y') }}
                        @else
                            <span class="text-muted">Belum diproses</span>
                        @endif
                    </td>

                    {{-- Tanggal Kembali --}}
                    <td>
                        @if($peminjaman->tanggal_kembali)
                            {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d-m-Y') }}
                        @else
                            Belum dikembalikan
                        @endif
                    </td>

                    <td>
                        @if($peminjaman->status_proses == 'telah diproses')
                            <span class="badge bg-success">Telah Diproses</span>
                        @else
                            <span class="badge bg-warning">Sedang diverifikasi Admin</span>
                        @endif
                    </td>

                    @if($showAnyAction)
                        <td class="d-flex gap-2">
                            @if($showActions)
                                @if($showProcessBtn)
                                    {{-- ✅ Tombol proses admin menuju form detail --}}
                                    <a href="{{ route('keluarmasuk.proses.form', $peminjaman->id) }}" class="btn btn-success btn-sm">✔️ Proses</a>
                                @endif

                                @if($alreadyReturned)
                                    <span class="badge bg-info">Sudah Dikembalikan</span>
                                @elseif($showReturnBtn)
                                    <form action="{{ route('peminjaman.kembalikan', $peminjaman->id) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-danger">🔁 Kembalikan</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection