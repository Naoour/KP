<h2>Laporan Barang Keluar</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal Pinjam</th>
            <th>Jam Pinjam</th> {{-- Kolom baru --}}
            <th>Nama Barang</th>
            <th>Tujuan</th>
            <th>Dipinjam Oleh</th>
        </tr>
    </thead>
    <tbody>
        @foreach($keluar as $p)
        <tr>
            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('H:i') }}</td> {{-- Jam pinjam --}}
            <td>{{ $p->barang->nama }}</td>
            <td>{{ $p->tujuan }}</td>
            <td>{{ $p->user->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br><br>

<h2>Laporan Barang Masuk</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal Kembali</th>
            <th>Jam Kembali</th> {{-- Kolom baru --}}
            <th>Nama Barang</th>
            <th>Tujuan</th>
            <th>Dipinjam Oleh</th>
        </tr>
    </thead>
    <tbody>
        @foreach($masuk as $p)
        <tr>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d-m-Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('H:i') }}</td> {{-- Jam kembali --}}
            <td>{{ $p->barang->nama }}</td>
            <td>{{ $p->tujuan }}</td>
            <td>{{ $p->user->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>