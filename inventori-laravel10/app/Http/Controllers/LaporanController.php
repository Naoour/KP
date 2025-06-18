<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use PDF;

class LaporanController extends Controller
{
    public function index()
    {
        // Ambil data per hari
        $harian = Peminjaman::selectRaw('DATE(tanggal) as label, count(*) as total')
            ->groupBy('label')->get();

        // Ambil data per bulan
        $bulanan = Peminjaman::selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as label, count(*) as total')
            ->groupBy('label')->get();

        // Ambil data per tahun
        $tahunan = Peminjaman::selectRaw('YEAR(tanggal) as label, count(*) as total')
            ->groupBy('label')->get();

        return view('laporan.index', compact('harian', 'bulanan', 'tahunan'));
    }

    public function downloadPdf()
    {
        $peminjaman = Peminjaman::with('user')->get();

        $pdf = PDF::loadView('laporan.pdf', compact('peminjaman'));
        return $pdf->download('laporan_peminjaman.pdf');
    }
}
