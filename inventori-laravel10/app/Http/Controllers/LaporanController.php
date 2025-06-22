<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $sevenDaysAgo = now()->subDays(7)->startOfDay();

        $harian = Peminjaman::where('status_proses', 'telah diproses')
            ->whereDate('tanggal', '>=', $sevenDaysAgo)
            ->selectRaw('DATE(tanggal) as label, count(*) as total')
            ->groupBy('label')->get();

        $bulanan = Peminjaman::where('status_proses', 'telah diproses')
            ->whereDate('tanggal', '>=', $sevenDaysAgo)
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as label, count(*) as total')
            ->groupBy('label')->get();

        $tahunan = Peminjaman::where('status_proses', 'telah diproses')
            ->whereDate('tanggal', '>=', $sevenDaysAgo)
            ->selectRaw('YEAR(tanggal) as label, count(*) as total')
            ->groupBy('label')->get();

        // Menampilkan semua peminjaman yang telah diproses sebagai barang keluar
        $keluar = Peminjaman::where('status_proses', 'telah diproses')
            ->whereDate('tanggal', '>=', $sevenDaysAgo)
            ->with('user', 'barang')
            ->latest()
            ->paginate(5, ['*'], 'keluar_page');

        // Barang masuk tetap hanya yang sudah dikembalikan
        $masuk = Peminjaman::whereNotNull('tanggal_kembali')
            ->whereDate('tanggal_kembali', '>=', $sevenDaysAgo)
            ->with('user', 'barang')
            ->latest()
            ->paginate(5, ['*'], 'masuk_page');

        return view('laporan.index', compact('harian', 'bulanan', 'tahunan', 'keluar', 'masuk'));
    }

    public function downloadPdf()
    {
        $keluar = Peminjaman::where('status_proses', 'telah diproses')
            ->with('user', 'barang')->get();

        $masuk = Peminjaman::whereNotNull('tanggal_kembali')
            ->with('user', 'barang')->get();

        $pdf = PDF::loadView('laporan.pdf', compact('keluar', 'masuk'));
        return $pdf->download('laporan_peminjaman.pdf');
    }
}