<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InputAspirasi;

class AspirasiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required',
            'id_kategori' => 'required|integer|in:1,2,3,4,5',
            'lokasi' => 'required|string|max:100',
            'keterangan' => 'required|string|max:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // upload foto
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $namaFoto = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('foto_aspirasi'), $namaFoto);
        }

        Try {
            // Masukkan ke table input_aspirasi
            InputAspirasi::create([
                'nis' => $request->nis,
                'id_kategori' => $request->id_kategori,
                'lokasi' => $request->lokasi,
                'ket' => $request->keterangan,
                'foto' => $namaFoto,
                'tanggal' => \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->tanggal)->format('Y-m-d'),
            ]);

            return back()->with('success', 'Data aspirasi berhasil dikirim! Admin akan memproses segera.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}