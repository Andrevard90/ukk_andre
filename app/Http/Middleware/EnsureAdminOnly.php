<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Jika siswa mencoba akses admin dashboard - logout dan redirect ke login
        if (Auth::guard('siswa')->check()) {
            Auth::guard('siswa')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect('/')->withErrors(['login' => 'Anda login sebagai siswa. Hanya admin yang dapat mengakses dashboard admin. Silakan login sebagai admin.']);
        }

        // Jika belum login atau tidak login sebagai admin - redirect ke login
        if (!Auth::guard('admin')->check()) {
            return redirect('/')->withErrors(['login' => 'Anda harus login sebagai admin terlebih dahulu untuk mengakses halaman ini.']);
        }

        // Jika sudah login sebagai admin, lanjutkan
        return $next($request);
    }
}
