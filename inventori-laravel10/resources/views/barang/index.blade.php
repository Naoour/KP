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
                        @if(auth()->user()->role == 'admin')
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($barangs as $barang)
                    <tr class="{{ in_array($barang->status, ['dipinjam']) || in_array($barang->kondisi, ['rusak', 'diperbaiki']) ? 'opacity-50' : '' }}">
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

                        @if(auth()->user()->role == 'admin')
                        <td class="text-center">
                            <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            
                            <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endsection