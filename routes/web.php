<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



//tampilan awal website
Route::get('/', function () {
    return redirect()->route('backend.login');
});

//tampilkan form login
Route::get('backend/login', [LoginController::class, 'login'])->name('backend.login');

//tampilkan form index saat login
Route::get('backend/index', [BerandaController::class, 'berandaBackend'])->name('backend.index')->middleware('auth');

//proses auth login
Route::post('backend/auth', [LoginController::class, 'auth'])->name('backend.auth');

//proses logout
Route::post('backend/logout', [LoginController::class, 'logout'])->name('backend.logout');

// Untuk User
Route::resource('backend/user', UserController::class,['as' => 'backend'])->middleware('auth');
//input data user
Route::post('backend/user/add', [UserController::class, 'store'])->name('backend.user.store');
// Hapus data user
Route::post('backend/user/destroy/{id}', [UserController::class, 'destroy'])->name('backend.user.destroy');
//edit data user
Route::get('backend/user/edit/{id}', [UserController::class, 'edit'])->name('backend.user.edit');
//cetak data user
Route::get('backend/laporan/formuser', [UserController::class, 'formUser'])->name('backend.laporan.formuser')->middleware('auth');
Route::post('backend/laporan/cetakuser', [UserController::class, 'cetakUser'])->name('backend.laporan.cetakuser')->middleware('auth');

// Kategori
Route::resource('backend/kategori', KategoriController::class, ['as' => 'backend'])->middleware('auth');
//proses tambah kategori
Route::post('backend/kategori/add', [KategoriController::class, 'store'])->name('backend.kategori.store');

//proses tambah produk
Route::resource('backend/produk', ProdukController::class, ['as' => 'backend'])->middleware('auth');
Route::post('backend/produk/add', [ProdukController::class, 'store'])->name('backend.produk.store');

//proses tambah Foto produk
Route::post('backend/produk/addFoto', [ProdukController::class, 'storeFoto'])->name('backend.produk.storeFoto');

//Hapus Produk
Route::post('backend/produk/destroy/{id}', [ProdukController::class, 'destroy'])->name('backend.produk.destroy');

//hapus foto produk
Route::post('backend/foto_produk/destroy/{id}', [ProdukController::class, 'destroy_foto_produk'])->name('backend.destroy_foto_produk.destroy');

//cetak produk
Route::get('backend/laporan/formproduk', [ProdukController::class, 'formProduk'])->name('backend.laporan.formproduk')->middleware('auth');
Route::post('backend/laporan/cetakproduk', [ProdukController::class, 'cetakProduk'])->name('backend.laporan.cetakproduk')->middleware('auth');
