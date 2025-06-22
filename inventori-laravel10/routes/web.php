<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KeluarMasukController;
use App\Http\Controllers\LaporanController;

// Halaman login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Redirect default
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Admin & User bisa akses dashboard, barang, keluar-masuk
Route::middleware(['auth', 'role:admin,user'])->group(function () {

    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');

    Route::get('/keluar-masuk', [KeluarMasukController::class, 'index'])->name('keluarmasuk.index');

    // ✅ Tambahan route GET untuk menampilkan form proses (Admin)
    Route::get('/keluar-masuk/{id}/form-proses', [KeluarMasukController::class, 'formProses'])->name('keluarmasuk.proses.form');

    // ✅ Tambahan route POST simpan peminjaman (user submit form)
    Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
});

// Admin khusus
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');

    Route::get('/barang/create', [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang', [BarangController::class, 'store'])->name('barang.store');

    Route::get('/barang/{barang}/edit', [BarangController::class, 'edit'])->name('barang.edit');
    Route::put('/barang/{barang}', [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{barang}', [BarangController::class, 'destroy'])->name('barang.destroy');

    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::post('/keluar-masuk/{id}/proses', [KeluarMasukController::class, 'proses'])->name('keluarmasuk.proses');
});

// Kepala hanya bisa lihat laporan
Route::middleware(['auth', 'role:admin,kepala'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/download', [LaporanController::class, 'downloadPdf'])->name('laporan.download');
});

// User biasa: hanya untuk peminjaman
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
});