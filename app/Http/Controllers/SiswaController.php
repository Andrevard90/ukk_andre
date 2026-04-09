<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(){
        $nis = Auth::guard('siswa')->user()->nis;

        // Data laporan siswa
        $data = Aspirasi::whereHas('inputAspirasi', function ($query) use ($nis) {
            $query->where('nis', $nis);
        })->with('inputAspirasi', 'kategori')->get();

        return view('siswa.dashboard', compact('data'));
    }

    public function store(Request $r){
        $r->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'required',
        ]);

        Aspirasi::create([
            'nis' => Auth::guard('siswa')->user()->nis,
            'id_kategori' => $r->id_kategori,
            'lokasi' => $r->lokasi,
            'keterangan' => $r->keterangan,
            'status' => 'Menunggu'
        ]);
        return back();
    }

    public function laporan()
    {
        $nis = Auth::guard('siswa')->user()->nis;
        
        // Ambil laporan yang masih di input_aspirasi (belum diproses)
        $laporanMasuk = InputAspirasi::where('nis', $nis)->orderBy('created_at', 'desc')->get();
        
        // Ambil laporan yang sudah diproses by admin
        $laporanDiproses = Aspirasi::whereIn('id_pelaporan', 
            InputAspirasi::where('nis', $nis)->pluck('id_pelaporan')
        )->with('kategori', 'inputAspirasi')->orderBy('created_at', 'desc')->get();
        
        return view('siswa.laporan', [
            'laporanMasuk' => $laporanMasuk,
            'laporanDiproses' => $laporanDiproses
        ]);
    }

    public function feedback(Request $request, $id)
    {
        $request->validate([
            'siswa_feedback' => 'nullable|string|max:1000',
        ]);

        $aspirasi = Aspirasi::with('inputAspirasi')->find($id);

        if (!$aspirasi || !$aspirasi->inputAspirasi) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        if ($aspirasi->inputAspirasi->nis !== Auth::guard('siswa')->user()->nis) {
            return back()->with('error', 'Akses ditolak');
        }

        $aspirasi->siswa_feedback = $request->siswa_feedback;
        $aspirasi->save();

        return back()->with('success', 'Feedback berhasil disimpan.');
    }
}