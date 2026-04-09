<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Menampilkan dashboard dengan input aspirasi yang masuk
    public function index(Request $request){
        $search = $request->query('search');
        $categoryFilter = $request->query('category');

        $kategoriOptions = [
            1 => 'Kebersihan',
            2 => 'Keselamatan',
            3 => 'Fasilitas',
            4 => 'Pembelajaran',
            5 => 'Administrasi',
        ];

        $inputAspirasiQuery = InputAspirasi::with('siswa', 'kategori');
        $aspirasiQuery = Aspirasi::with('kategori', 'inputAspirasi');

        if ($categoryFilter) {
            $inputAspirasiQuery->where('id_kategori', $categoryFilter);
            $aspirasiQuery->where('id_kategori', $categoryFilter);
        }

        if ($search) {
            $inputAspirasiQuery->where(function ($query) use ($search) {
                $query->where('lokasi', 'like', "%{$search}%")
                      ->orWhere('ket', 'like', "%{$search}%")
                      ->orWhere('id_pelaporan', 'like', "%{$search}%")
                      ->orWhereHas('siswa', function ($query) use ($search) {
                          $query->where('nis', 'like', "%{$search}%");
                      })
                      ->orWhereHas('kategori', function ($query) use ($search) {
                          $query->where('ket_kategori', 'like', "%{$search}%");
                      });
            });

            $aspirasiQuery->where(function ($query) use ($search) {
                $query->where('status', 'like', "%{$search}%")
                      ->orWhere('feedback', 'like', "%{$search}%")
                      ->orWhere('id_aspirasi', 'like', "%{$search}%")
                      ->orWhereHas('inputAspirasi', function ($query) use ($search) {
                          $query->where('lokasi', 'like', "%{$search}%")
                                ->orWhere('ket', 'like', "%{$search}%");
                      })
                      ->orWhereHas('kategori', function ($query) use ($search) {
                          $query->where('ket_kategori', 'like', "%{$search}%");
                      });
            });
        }

        $inputAspirasi = $inputAspirasiQuery->get();
        $aspirasi = $aspirasiQuery->whereHas('inputAspirasi')->get();

        // Statistik untuk dashboard admin
        $totalLaporan = $inputAspirasi->count() + $aspirasi->count();
        $totalDiproses = $aspirasi->count();
        $totalBelumDiproses = $inputAspirasi->count();

        // Statistik per kategori
        $kategoriStats = [];
        $kategoriLabels = ['Kebersihan', 'Keselamatan', 'Fasilitas', 'Pembelajaran', 'Administrasi'];
        foreach ($kategoriLabels as $index => $label) {
            $kategoriId = $index + 1;
            $count = Aspirasi::where('id_kategori', $kategoriId)->count() +
                    InputAspirasi::where('id_kategori', $kategoriId)->count();
            $kategoriStats[] = [
                'label' => $label,
                'count' => $count
            ];
        }

        // Statistik per bulan (6 bulan terakhir)
        $monthlyStats = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M Y');

            $count = Aspirasi::whereYear('created_at', $date->year)
                           ->whereMonth('created_at', $date->month)
                           ->count() +
                    InputAspirasi::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count();

            $monthlyStats[] = [
                'month' => $monthName,
                'count' => $count
            ];
        }

        // Statistik per status
        $statusStats = [
            'Menunggu' => $aspirasi->where('status', 'Menunggu')->count(),
            'Proses' => $aspirasi->where('status', 'Proses')->count(),
            'Selesai' => $aspirasi->where('status', 'Selesai')->count(),
        ];

        // Tren analisis
        $trenData = [];
        $currentMonth = now();
        for ($i = 11; $i >= 0; $i--) {
            $date = $currentMonth->copy()->subMonths($i);
            $count = Aspirasi::whereYear('created_at', $date->year)
                           ->whereMonth('created_at', $date->month)
                           ->count() +
                    InputAspirasi::whereYear('created_at', $date->year)
                               ->whereMonth('created_at', $date->month)
                               ->count();
            $trenData[] = $count;
        }

        return view('admin.dashboard', compact(
            'inputAspirasi',
            'aspirasi',
            'totalLaporan',
            'totalDiproses',
            'totalBelumDiproses',
            'kategoriStats',
            'monthlyStats',
            'statusStats',
            'trenData',
            'search',
            'categoryFilter',
            'kategoriOptions'
        ));
    }

    // Proses (move) input aspirasi ke aspirasi table
    public function processAspirasi(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
            'id_kategori' => 'required',
        ]);

        $input = InputAspirasi::find($id);

        if (!$input) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $aspirasi = Aspirasi::where('id_pelaporan', $input->id_pelaporan)->first();
        $data = [
            'id_pelaporan' => $input->id_pelaporan,
            'status' => $request->status,
            'id_kategori' => $request->id_kategori,
            'feedback' => $request->feedback,
        ];

        if ($aspirasi) {
            $aspirasi->update($data);
        } else {
            Aspirasi::create($data);
        }

        return redirect('/admin/dashboard?tab=processed')->with('success', 'Aspirasi berhasil diproses!');
    }

    // Update status dan feedback aspirasi
    public function update(Request $request, $id){
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
        ]);

        $aspirasi = Aspirasi::find($id);

        if (!$aspirasi) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $aspirasi->status = $request->status;
        $aspirasi->feedback = $request->feedback;
        $aspirasi->save();

        return redirect('/admin/dashboard?tab=processed')->with('success', 'Data berhasil diperbarui');
    }

    public function deleteInput($id)
    {
        $input = InputAspirasi::find($id);

        if (!$input) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $input->delete();
        return redirect('/admin/dashboard?tab=input')->with('success', 'Laporan masuk berhasil dihapus.');
    }

    public function deleteAspirasi($id)
    {
        $aspirasi = Aspirasi::find($id);

        if (!$aspirasi) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $aspirasi->delete();
        return redirect('/admin/dashboard?tab=processed')->with('success', 'Aspirasi berhasil dihapus.');
    }
}