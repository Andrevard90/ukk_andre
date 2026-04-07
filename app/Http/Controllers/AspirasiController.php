<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aspirasi;

class AspirasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'id_kategori' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'required',
            'foto' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date',
        ]);

        // upload foto
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('foto_aspirasi'), $namaFoto);
        }

        Aspirasi::create([
            'nis' => $request->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'foto' => $namaFoto,
            'tanggal' => $request->tanggal,
        ]);

        return back()->with('success', 'Data berhasil ditambahkan');
    }
}