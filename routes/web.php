<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController;

Route::post('/aspirasi/store', [AspirasiController::class, 'store'])->name('aspirasi.store');
// Show registration form
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');

// Handle registration submission
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Halaman login
Route::get('/login', [AuthController::class, 'loginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Halaman registrasi siswa
Route::get('/register', [AuthController::class, 'registerForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/siswa', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard')->middleware('auth:siswa');

Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');