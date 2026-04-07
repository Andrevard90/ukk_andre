<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(){
        $data = Aspirasi::where('nis', Auth::user()->nis)->get();
        return view('siswa.dashboard', compact('data'));
    }

    public function store(Request $r){
        $r->validate([
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'required',
        ]);

        Aspirasi::create([
            'nis' => Auth::user()->nis,
            'id_kategori' => $r->id_kategori,
            'lokasi' => $r->lokasi,
            'keterangan' => $r->keterangan,
            'status' => 'Menunggu'
        ]);
        return back();
    }
}