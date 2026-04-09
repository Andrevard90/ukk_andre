<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ================= TAMPILKAN LOGIN & REGISTER =================
    public function showLogin()
    {
        return view('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // ================= UNIFIED LOGIN (SISWA & ADMIN) =================
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $login = $request->login;
        $password = $request->password;

        // Coba login sebagai SISWA terlebih dahulu (gunakan NIS)
        if (Auth::guard('siswa')->attempt(['nis' => $login, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect('/dashboard')->with('success', 'Login berhasil!');
        }

        // Jika siswa gagal, coba login sebagai ADMIN
        if (Auth::guard('admin')->attempt(['username' => $login, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect('/admin/dashboard')->with('success', 'Login berhasil!');
        }

        // Login gagal
        return back()->withErrors(['login' => 'NIS atau password salah. Pastikan password untuk siswa adalah kelas.'])->onlyInput('login');
    }

    // ================= REGISTER (HANYA SISWA) =================
    public function register(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nis'      => 'required|unique:siswa,nis|max:10',
            'kelas'    => 'required|max:50',
            'password' => 'required|min:6',
        ], [
            'nis.unique' => 'NIS ini sudah terdaftar!',
            'nis.required' => 'NIS wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        try {
            // 2. Simpan ke tabel siswa
            Siswa::create([
                'nis'      => $request->nis,
                'kelas'    => $request->kelas,
                'password' => bcrypt($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Registrasi Berhasil! Silakan login dengan NIS dan password Anda.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Gagal registrasi: ' . $e->getMessage()]);
        }
    }

    // ================= LOGOUT =================
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout berhasil!');
    }
}