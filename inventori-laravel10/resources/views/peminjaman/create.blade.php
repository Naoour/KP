@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Ajukan Peminjaman</h2>

    @if(isset($selectedBarangId))
        @php
            $selectedBarang = $barangs->firstWhere('id', $selectedBarangId);
        @endphp
        <div class="alert alert-info">
            Barang yang dipilih: <strong>{{ $selectedBarang->nama ?? '-' }}</strong>
        </div>
    @endif

    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="barang_id" class="form-label">Pilih Barang</label>
            <select name="barang_id" class="form-control" required>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" 
                        {{ (isset($selectedBarangId) && $selectedBarangId == $barang->id) ? 'selected' : '' }}>
                        {{ $barang->nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="tujuan" class="form-label">Tujuan</label>
            <input type="text" name="tujuan" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Ajukan</button>
    </form>
</div>
@endsection
