<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\BerandaController;


Route::get('/', function () {  
    return redirect()->route('backend.login'); 
}); 

Route::get('backend/index', [BerandaController::class, 'berandaBackend'])->name('backend.index')->middleware('auth');

Route::get('backend/login', [LoginController::class, 'login'])->name('backend.login');

Route::post('backend/auth', [LoginController::class, 'auth'])->name('backend.auth');

Route::post('backend/logout', [LoginController::class, 'logout'])->name('backend.logout');

// Untuk User

Route::resource('backend/user', UserController::class,['as' => 'backend'])->middleware('auth');

// (KESALAHAN DI MODUL * Menurut saia :v *) 
// di form action Ga ada route ini, jadi dia ga tau route mana yang harus di jalanin :v
Route::post('backend/user/add', [UserController::class, 'store'])->name('backend.user.store');

// Ni Untuk Hapus datanya
Route::post('backend/user/destroy/{id}', [UserController::class, 'destroy'])->name('backend.user.destroy');