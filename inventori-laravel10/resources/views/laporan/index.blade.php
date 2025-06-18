@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Laporan Peminjaman</h1>
    <a href="{{ route('laporan.download') }}" class="btn btn-danger mb-3">Download PDF</a>

    <canvas id="laporanChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('laporanChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($harian->pluck('label')) !!},
        datasets: [{
            label: 'Dipinjam',
            data: {!! json_encode($harian->pluck('total')) !!},
            backgroundColor: 'rgba(255, 99, 132, 0.5)'
        }]
    },
});
</script>
@endsection
