<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\BarangController;

// ─── Route Publik (belum login) ───────────────────────────────────────────────
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// ─── Route Terproteksi (harus login) ─────────────────────────────────────────
    Route::middleware([\App\Http\Middleware\AuthMiddleware::class])->group(function () {

    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');


    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ── Pelanggan (CRUD) ──────────────────────────────────────────────────────
    Route::get('/pelanggan',              [PelangganController::class, 'index'])  ->name('pelanggan.index');
    Route::get('/pelanggan/create',       [PelangganController::class, 'create']) ->name('pelanggan.create');
    Route::post('/pelanggan',             [PelangganController::class, 'store'])  ->name('pelanggan.store');
    Route::get('/pelanggan/{id}/edit',    [PelangganController::class, 'edit'])   ->name('pelanggan.edit');
    Route::put('/pelanggan/{id}',         [PelangganController::class, 'update']) ->name('pelanggan.update');
    Route::delete('/pelanggan/{id}',      [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // ── Barang ────────────────────────────────────────────────────────────────
    Route::get('/barang',           [BarangController::class, 'index']) ->name('barang.index');
    Route::get('/barang/create',    [BarangController::class, 'create'])->name('barang.create');
    Route::post('/barang',          [BarangController::class, 'store']) ->name('barang.store');
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit'])  ->name('barang.edit');
    Route::put('/barang/{id}',      [BarangController::class, 'update'])->name('barang.update');
    Route::delete('/barang/{id}',   [BarangController::class, 'destroy'])->name('barang.destroy');

    // ── Transaksi ─────────────────────────────────────────────────────────────
    Route::get('/transaksi',         [TransaksiController::class, 'index']) ->name('transaksi.index');
    Route::get('/transaksi/create',  [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi',        [TransaksiController::class, 'store']) ->name('transaksi.store');
    Route::get('/transaksi/{id}',    [TransaksiController::class, 'show'])  ->name('transaksi.show');

});