<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
	return view('dashboard', [
		'jumlahBuku' => Buku::count(),
		'jumlahAnggota' => Anggota::count(),
		'totalPeminjam' => Peminjaman::query()->distinct()->count('anggota_id'),
		'sudahDikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
		'belumDikembalikan' => Peminjaman::where('status', 'dipinjam')->count(),
		'terlambat' => Peminjaman::where('status', 'terlambat')->count(),
	]);
})->name('dashboard');

Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
Route::get('/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
Route::post('/anggota', [AnggotaController::class, 'store'])->name('anggota.store');
Route::get('/anggota/{anggota}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit');
Route::put('/anggota/{anggota}', [AnggotaController::class, 'update'])->name('anggota.update');
Route::delete('/anggota/{anggota}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('/peminjaman/{peminjaman}', [PeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('/peminjaman/{peminjaman}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
