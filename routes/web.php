<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\AdminController;

// ============= ROUTE PUBLIK (TANPA LOGIN) =============
Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============= REDIRECT JIKA SUDAH LOGIN =============
Route::middleware('auth:siswa')->group(function () {
    Route::get('/redirect', function () {
        return redirect('/dashboard');
    });
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/redirect', function () {
        return redirect('/admin/dashboard');
    });
});

// ============= ROUTE SISWA (HANYA BISA AKSES SISWA) =============
Route::middleware('auth:siswa')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
    Route::post('/aspirasi/store', [AspirasiController::class, 'store'])->name('aspirasi.store');
    Route::get('/laporan', [SiswaController::class, 'laporan'])->name('siswa.laporan');
    Route::post('/feedback/{id}', [SiswaController::class, 'feedback'])->name('siswa.feedback');
});

// ============= ROUTE ADMIN (HANYA BISA AKSES ADMIN) =============
Route::middleware('admin.only')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/aspirasi/process/{id}', [AdminController::class, 'processAspirasi'])->name('aspirasi.process');
    Route::post('/aspirasi/update/{id}', [AdminController::class, 'update'])->name('aspirasi.update');
    Route::post('/aspirasi/delete-input/{id}', [AdminController::class, 'deleteInput'])->name('aspirasi.deleteInput');
    Route::post('/aspirasi/delete/{id}', [AdminController::class, 'deleteAspirasi'])->name('aspirasi.delete');
});