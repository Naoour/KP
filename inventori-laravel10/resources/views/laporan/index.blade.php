@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Laporan Peminjaman</h1>
    <a href="{{ route('laporan.download') }}" class="btn btn-danger mb-3">Download PDF</a>

    <h4 class="mt-4">Grafik Harian (Barang Keluar)</h4>
    <canvas id="harianChart" class="mb-5"></canvas>

    <h4>Grafik Bulanan (Barang Keluar)</h4>
    <canvas id="bulananChart" class="mb-5"></canvas>

    <h4>Grafik Tahunan (Barang Keluar)</h4>
    <canvas id="tahunanChart" class="mb-5"></canvas>

    <h3 class="mt-5">Laporan Barang Keluar</h3>
    <table class="table table-bordered">
        <thead class="table-success">
            <tr>
                <th>Tanggal Pinjam</th>
                <th>Jam Pinjam</th> {{-- Tambahan --}}
                <th>Nama Barang</th>
                <th>Tujuan</th>
                <th>Dipinjam Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keluar as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('H:i') }}</td>
                    <td>{{ $p->barang->nama }}</td>
                    <td>{{ $p->tujuan }}</td>
                    <td>{{ $p->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $keluar->onEachSide(0)->links('vendor.pagination.simple-bootstrap-4') }}

    <h3 class="mt-5">Laporan Barang Masuk</h3>
    <table class="table table-bordered">
        <thead class="table-primary">
            <tr>
                <th>Tanggal Kembali</th>
                <th>Jam Kembali</th> {{-- Tambahan --}}
                <th>Nama Barang</th>
                <th>Tujuan</th>
                <th>Dipinjam Oleh</th>
            </tr>
        </thead>
        <tbody>
            @foreach($masuk as $p)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('H:i') }}</td>
                    <td>{{ $p->barang->nama }}</td>
                    <td>{{ $p->tujuan }}</td>
                    <td>{{ $p->user->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $masuk->onEachSide(0)->links('vendor.pagination.simple-bootstrap-4') }}
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Harian
new Chart(document.getElementById('harianChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($harian->pluck('label')) !!},
        datasets: [{
            label: 'Barang Keluar per Hari',
            data: {!! json_encode($harian->pluck('total')) !!},
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    }
});

// Grafik Bulanan
new Chart(document.getElementById('bulananChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($bulanan->pluck('label')) !!},
        datasets: [{
            label: 'Barang Keluar per Bulan',
            data: {!! json_encode($bulanan->pluck('total')) !!},
            backgroundColor: 'rgba(255, 159, 64, 0.6)'
        }]
    }
});

// Grafik Tahunan
new Chart(document.getElementById('tahunanChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($tahunan->pluck('label')) !!},
        datasets: [{
            label: 'Barang Keluar per Tahun',
            data: {!! json_encode($tahunan->pluck('total')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
        }]
    }
});
</script>
@endsection