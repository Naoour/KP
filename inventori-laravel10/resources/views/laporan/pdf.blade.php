<h2>Laporan Peminjaman Barang</h2>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Nama Alat</th>
            <th>Tujuan</th>
            <th>Dipinjam Oleh</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $p)
        <tr>
            <td>{{ $p->tanggal_pinjam }}</td>
            <td>{{ $p->tanggal_kembali }}</td>
            <td>{{ $p->nama_barang }}</td>
            <td>{{ $p->tujuan }}</td>
            <td>{{ $p->user->name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
