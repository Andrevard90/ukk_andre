<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Siswa;

class AuthController extends Controller
{
    // Menampilkan form login
    public function loginForm()
    {
        return view('auth.login'); // pastikan view auth/login.blade.php ada
    }

    // Menangani proses login
    public function login(Request $request)
    {
        $credentials = $request->only('nis', 'password');

        if (Auth::guard('siswa')->attempt($credentials)) {
            return redirect('/siswa');
        }

        return redirect()->back()->with('error', 'NIS atau password salah');
    }

    // Menampilkan form registrasi
    public function registerForm()
    {
        return view('auth.register'); // pastikan view auth/register.blade.php ada
    }

    // Menangani registrasi
    public function register(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:siswa,nis',
            'kelas' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        Siswa::create([
            'nis' => $request->nis,
            'kelas' => $request->kelas,
            'password' => bcrypt($request->password)
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::guard('siswa')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.form')->with('success', 'Berhasil logout');
    }
}