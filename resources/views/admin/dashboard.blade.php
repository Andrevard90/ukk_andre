<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard Admin - E-Aspirasi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(circle at top left, #1e293b, #0f172a);
        }
        
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .tab-btn.active {
            color: #38bdf8;
            border-bottom: 2px solid #38bdf8;
            background: rgba(56, 189, 248, 0.05);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .glass-card { border: 1px solid #ddd !important; background: white !important; }
        }
    </style>
</head>
<body class="min-h-screen text-slate-200 p-4 md:p-8">

    <div class="max-w-6xl mx-auto">
        {{-- Header Section --}}
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="h-2 w-8 bg-blue-500 rounded-full"></span>
                    <span class="text-blue-400 font-bold tracking-widest text-xs uppercase">Management System</span>
                </div>
                <h1 class="text-4xl font-extrabold text-white tracking-tight">
                    Dashboard <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-300">Admin</span>
                </h1>
                <p class="text-slate-400 text-sm mt-1">Otoritas penuh pengelolaan laporan aspirasi siswa.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="cetakSemuaLaporan()" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-200 rounded-xl text-sm font-semibold transition-all flex items-center gap-2 no-print">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak Rekap
                </button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 bg-red-500/10 hover:bg-red-500 border border-red-500/20 text-red-500 hover:text-white rounded-xl text-sm font-semibold transition-all">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        {{-- Search Bar --}}
        <form method="GET" action="{{ route('admin.dashboard') }}" class="mb-6 flex flex-col lg:flex-row gap-3 items-center justify-between">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 flex-1 min-w-0">
                <div class="col-span-1 md:col-span-1">
                    <select name="category" class="w-full rounded-2xl border border-slate-700 bg-slate-900/70 text-slate-100 px-5 py-3 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoriOptions as $key => $label)
                            <option value="{{ $key }}" {{ (string)($categoryFilter ?? '') === (string)$key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-1 md:col-span-2 relative">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari laporan berdasarkan NIS, lokasi, status, atau kata kunci..."
                        class="w-full rounded-2xl border border-slate-700 bg-slate-900/70 text-slate-100 placeholder-slate-500 px-5 py-3 pr-32 focus:border-blue-400 focus:ring-2 focus:ring-blue-400 outline-none" />
                    <button type="submit" class="absolute right-2 top-1/2 -translate-y-1/2 bg-blue-500 hover:bg-blue-400 text-white rounded-2xl px-4 py-2 text-sm font-semibold transition-all">Cari</button>
                </div>
            </div>
            <input type="hidden" name="tab" value="{{ request('tab', 'input') }}" id="searchTabInput">
            @if(!empty($search) || !empty($categoryFilter))
                <div class="text-sm text-slate-300 bg-slate-800/70 border border-slate-700 rounded-2xl px-4 py-3">
                    Hasil pencarian untuk: <span class="font-semibold text-white">"{{ $search ?? '-' }}"</span>
                    @if(!empty($categoryFilter))
                        | Kategori: <span class="font-semibold text-white">{{ $kategoriOptions[$categoryFilter] ?? 'Semua' }}</span>
                    @endif
                </div>
            @endif
        </form>

        {{-- Alert --}}
        @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl text-emerald-400 flex items-center gap-3 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Tabs Navigation --}}
        <div class="flex gap-2 mb-8 bg-slate-800/40 p-1.5 rounded-2xl w-fit no-print">
            <button onclick="switchTab('input')" class="tab-btn active px-6 py-2.5 rounded-xl text-sm font-bold transition-all">
                Laporan Baru <span class="ml-2 px-2 py-0.5 bg-blue-500 text-white text-[10px] rounded-full">{{ $inputAspirasi->count() }}</span>
            </button>
            <button onclick="switchTab('processed')" class="tab-btn px-6 py-2.5 rounded-xl text-sm font-bold text-slate-400 transition-all hover:text-slate-200">
                Riwayat Proses <span class="ml-2 px-2 py-0.5 bg-slate-700 text-slate-300 text-[10px] rounded-full">{{ $aspirasi->count() }}</span>
            </button>
            <button onclick="switchTab('statistics')" class="tab-btn px-6 py-2.5 rounded-xl text-sm font-bold text-slate-400 transition-all hover:text-slate-200">
                📊 Laporan & Statistik
            </button>
        </div>

        {{-- TAB 1: LAPORAN MASUK --}}
        <div id="input" class="tab-content block space-y-6">
            @forelse($inputAspirasi as $item)
                <div class="glass-card rounded-3xl overflow-hidden group transition-all hover:border-blue-500/30">
                    <div class="p-6 md:p-8 flex flex-col lg:flex-row gap-8">
                        {{-- Image Section --}}
                        @if($item->foto)
                        <div class="w-full lg:w-48 h-64 flex-shrink-0">
                            <img src="{{ asset('foto_aspirasi/' . $item->foto) }}" class="w-full h-full object-cover rounded-2xl border border-slate-700 shadow-2xl transition-transform group-hover:scale-[1.02]">
                        </div>
                        @else
                        <div class="w-full lg:w-48 h-64 bg-slate-800/50 rounded-2xl flex items-center justify-center border border-dashed border-slate-700">
                            <span class="text-slate-600 text-xs italic text-center px-4">Tanpa lampiran foto</span>
                        </div>
                        @endif

                        {{-- Content Section --}}
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-black uppercase tracking-widest rounded-lg border border-blue-500/20">
                                    {{ $item->kategori->ket_kategori ?? 'UMUM' }}
                                </span>
                                <span class="text-slate-500 text-xs flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $item->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-white mb-2">{{ $item->lokasi }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed mb-6">{{ $item->ket }}</p>
                            
                            <div class="grid grid-cols-2 gap-4 py-4 border-y border-slate-700/50 mb-6">
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">Pelapor</p>
                                    <p class="text-sm text-slate-200">{{ $item->siswa->nis ?? 'Anonim' }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">Tanggal Kejadian</p>
                                    <p class="text-sm text-slate-200">{{ $item->tanggal->format('d F Y') }}</p>
                                </div>
                            </div>

                            {{-- Action Form --}}
                            <form method="POST" action="{{ route('aspirasi.process', $item->id_pelaporan) }}" class="space-y-4 bg-slate-900/40 p-5 rounded-2xl border border-slate-700/50">
                                @csrf
                                <input type="hidden" name="id_kategori" value="{{ $item->id_kategori }}">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-1">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2">Ubah Status</label>
                                        <select name="status" class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white focus:ring-1 focus:ring-blue-500 outline-none">
                                            <option value="Menunggu">Menunggu</option>
                                            <option value="Proses">Proses</option>
                                            <option value="Selesai">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2">Tanggapan Admin</label>
                                        <input type="text" name="feedback" placeholder="Ketik instruksi atau jawaban..." class="w-full px-4 py-2.5 bg-slate-800 border border-slate-700 rounded-xl text-xs text-white focus:ring-1 focus:ring-blue-500 outline-none">
                                    </div>
                                </div>
                                <div class="flex flex-col sm:flex-row gap-2">
                                    <button type="submit" class="flex-1 py-3 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition-all shadow-lg shadow-blue-900/20 uppercase tracking-widest">
                                        Update & Simpan
                                    </button>
                                    <button type="button" onclick="cetakLaporanAdmin('laporan-admin-{{ $item->id_pelaporan }}')" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl text-xs font-bold transition-all uppercase tracking-widest no-print">
                                        🖨️
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="laporan-admin-{{ $item->id_pelaporan }}" style="display:none;">
                    <div style="font-family: Arial, sans-serif; padding: 20px; color: #000;">
                        <h2 style="margin-bottom: 10px;">LAPORAN BARU</h2>
                        <p><strong>No. Pelaporan:</strong> {{ $item->id_pelaporan }}</p>
                        <p><strong>NIS:</strong> {{ $item->siswa->nis ?? 'Unknown' }}</p>
                        <p><strong>Kategori:</strong> {{ $item->kategori->ket_kategori ?? 'UMUM' }}</p>
                        <p><strong>Lokasi:</strong> {{ $item->lokasi }}</p>
                        <p><strong>Tanggal Kejadian:</strong> {{ $item->tanggal->format('d F Y') }}</p>
                        <p><strong>Keterangan:</strong><br>{{ $item->ket }}</p>
                        @if($item->foto)
                            <div style="margin-top: 15px; text-align: center;">
                                <img src="{{ asset('foto_aspirasi/' . $item->foto) }}" style="max-width: 100%; height: auto; border: 1px solid #ccc;" />
                            </div>
                        @endif
                        <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
                            <p><strong>Dicetak oleh Admin:</strong> {{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</p>
                            <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-slate-800/20 rounded-3xl border border-dashed border-slate-700">
                    <p class="text-slate-500 italic">Inbox kosong. Tidak ada laporan baru saat ini.</p>
                </div>
            @endforelse
        </div>

        {{-- TAB 2: RIWAYAT PROSES --}}
        <div id="processed" class="tab-content hidden space-y-4">
            @forelse($aspirasi as $item)
                <div class="glass-card p-5 rounded-2xl border-l-4 {{ $item->status == 'Selesai' ? 'border-l-emerald-500' : 'border-l-blue-500' }}">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[10px] font-black text-slate-500 tracking-tighter uppercase">#{{ $item->id_aspirasi }}</span>
                                <span class="text-xs font-bold {{ $item->status == 'Selesai' ? 'text-emerald-400' : 'text-blue-400' }}">{{ $item->status }}</span>
                            </div>
                            <h4 class="font-bold text-white">{{ $item->kategori->ket_kategori ?? 'Laporan' }}</h4>
                            <p class="text-xs text-slate-400 mt-1 italic">"{{ $item->feedback }}"</p>
                        </div>

                        {{-- Foto Preview --}}
                        @if($item->inputAspirasi && $item->inputAspirasi->foto)
                        <div class="flex-shrink-0">
                            <div class="relative group">
                                <img src="{{ asset('foto_aspirasi/' . $item->inputAspirasi->foto) }}"
                                     alt="Foto Laporan"
                                     class="w-16 h-16 rounded-xl object-cover border-2 border-slate-600 hover:border-cyan-400 transition-all cursor-pointer"
                                     onclick="showFotoModal('{{ asset('foto_aspirasi/' . $item->inputAspirasi->foto) }}', '{{ $item->id_aspirasi }}')">
                                <div class="absolute inset-0 bg-black/50 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-slate-700/50 border-2 border-slate-600 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        @endif

                        <div class="flex gap-2 w-full md:w-auto no-print">
                            <button onclick="cetakLaporanAdmin('laporan-proses-{{ $item->id_aspirasi }}')" class="p-2.5 bg-slate-700 hover:bg-slate-600 rounded-xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                            </button>
                            <form method="POST" action="{{ route('aspirasi.delete', $item->id_aspirasi) }}" onsubmit="return confirm('Hapus riwayat ini?')">
                                @csrf
                                <button type="submit" class="p-2.5 bg-red-500/10 hover:bg-red-500 border border-red-500/20 text-red-500 hover:text-white rounded-xl transition-all">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('aspirasi.update', $item->id_aspirasi) }}" class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4 bg-slate-900/50 p-4 rounded-2xl border border-slate-700">
                        @csrf
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Status Saat Ini</label>
                            <select name="status" class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white focus:ring-1 focus:ring-blue-500 outline-none">
                                <option value="Menunggu" {{ $item->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="Proses" {{ $item->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ $item->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Ubah Feedback Admin</label>
                            <input type="text" name="feedback" value="{{ $item->feedback }}" placeholder="Perbarui feedback..." class="w-full px-3 py-2 bg-slate-800 border border-slate-700 rounded-xl text-sm text-white focus:ring-1 focus:ring-blue-500 outline-none">
                        </div>
                        <div class="md:col-span-3 flex justify-end">
                            <button type="submit" class="px-5 py-2.5 bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl text-sm font-semibold transition-all">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
                
                {{-- Hidden Print Areas --}}
                <div id="laporan-proses-{{ $item->id_aspirasi }}" style="display:none;">
                    <div style="font-family: Arial, sans-serif; padding: 20px; color: #000;">
                        <h2 style="margin-bottom: 10px;">LAPORAN PROSES</h2>
                        <p><strong>No. Aspirasi:</strong> {{ $item->id_aspirasi }}</p>
                        <p><strong>Status:</strong> {{ $item->status }}</p>
                        <p><strong>Kategori:</strong> {{ $item->kategori->ket_kategori ?? 'N/A' }}</p>
                        @if($item->inputAspirasi)
                            <p><strong>Lokasi:</strong> {{ $item->inputAspirasi->lokasi }}</p>
                            <p><strong>Tanggal Kejadian:</strong> {{ $item->inputAspirasi->tanggal ? $item->inputAspirasi->tanggal->format('d F Y') : 'N/A' }}</p>
                            <p><strong>Keterangan Awal:</strong><br>{{ $item->inputAspirasi->ket }}</p>
                            @if($item->inputAspirasi->foto)
                                <div style="margin-top: 15px; text-align: center;">
                                    <img src="{{ asset('foto_aspirasi/' . $item->inputAspirasi->foto) }}" style="max-width: 100%; height: auto; border: 1px solid #ccc;" />
                                </div>
                            @endif
                        @endif
                        <p><strong>Feedback Admin:</strong><br>{{ $item->feedback ?? 'Belum ada feedback' }}</p>
                        <p><strong>Feedback Siswa:</strong><br>{{ $item->siswa_feedback ?? 'Belum ada feedback siswa' }}</p>
                        <div style="margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px;">
                            <p><strong>Dicetak oleh Admin:</strong> {{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</p>
                            <p><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i:s') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-500 text-sm">Belum ada riwayat proses.</div>
            @endforelse
        </div>

        {{-- TAB 3: LAPORAN & STATISTIK --}}
        <div id="statistics" class="tab-content hidden space-y-8">
            {{-- Overview Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="glass-card p-6 rounded-2xl border-l-4 border-l-blue-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Total Laporan</p>
                            <p class="text-3xl font-black text-white mt-1">{{ $totalLaporan }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl border-l-4 border-l-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Sudah Diproses</p>
                            <p class="text-3xl font-black text-white mt-1">{{ $totalDiproses }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl border-l-4 border-l-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Belum Diproses</p>
                            <p class="text-3xl font-black text-white mt-1">{{ $totalBelumDiproses }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-6 rounded-2xl border-l-4 border-l-purple-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Tingkat Penyelesaian</p>
                            <p class="text-3xl font-black text-white mt-1">
                                {{ $totalLaporan > 0 ? round(($totalDiproses / $totalLaporan) * 100, 1) : 0 }}%
                            </p>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Chart Kategori --}}
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4"/>
                        </path>
                        Pengaduan per Kategori
                    </h3>
                    <div class="h-80">
                        <canvas id="kategoriChart"></canvas>
                    </div>
                </div>

                {{-- Chart Status --}}
                <div class="glass-card p-8 rounded-2xl">
                    <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </path>
                        Status Pengaduan
                    </h3>
                    <div class="h-80">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>

            {{-- Chart Bulanan --}}
            <div class="glass-card p-8 rounded-2xl">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </path>
                    Tren Pengaduan per Bulan (6 Bulan Terakhir)
                </h3>
                <div class="h-80">
                    <canvas id="monthlyChart"></canvas>
                </div>
            </div>

            {{-- Analisis Tren --}}
            <div class="glass-card p-8 rounded-2xl">
                <h3 class="text-xl font-bold mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </path>
                    Analisis Tren Pengaduan (12 Bulan Terakhir)
                </h3>
                <div class="h-80">
                    <canvas id="trenChart"></canvas>
                </div>

                {{-- Summary Stats --}}
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                        <p class="text-sm text-slate-400">Kategori Terbanyak</p>
                        <p class="text-lg font-bold text-white">
                            {{ collect($kategoriStats)->sortByDesc('count')->first()['label'] ?? 'N/A' }}
                            ({{ collect($kategoriStats)->sortByDesc('count')->first()['count'] ?? 0 }})
                        </p>
                    </div>
                    <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                        <p class="text-sm text-slate-400">Bulan Teramai</p>
                        <p class="text-lg font-bold text-white">
                            {{ collect($monthlyStats)->sortByDesc('count')->first()['month'] ?? 'N/A' }}
                            ({{ collect($monthlyStats)->sortByDesc('count')->first()['count'] ?? 0 }})
                        </p>
                    </div>
                    <div class="bg-slate-800/50 p-4 rounded-xl border border-slate-700">
                        <p class="text-sm text-slate-400">Rata-rata per Bulan</p>
                        <p class="text-lg font-bold text-white">
                            {{ count($monthlyStats) > 0 ? round(collect($monthlyStats)->avg('count'), 1) : 0 }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Logic script tetap sama --}}
    <script>
        function switchTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            // Reset all tab buttons
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('active', 'text-blue-400');
                el.classList.add('text-slate-400');
            });
            // Show selected tab
            document.getElementById(tab).classList.remove('hidden');
            // Activate corresponding button
            const activeBtn = document.querySelector(`[onclick="switchTab('${tab}')"]`);
            if (activeBtn) {
                activeBtn.classList.add('active', 'text-blue-400');
                activeBtn.classList.remove('text-slate-400');
            }

            const searchTabInput = document.getElementById('searchTabInput');
            if (searchTabInput) {
                searchTabInput.value = tab;
            }
        }

        // Auto-switch tab based on URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const tab = urlParams.get('tab');
            if (tab === 'processed') {
                switchTab('processed');
            } else if (tab === 'input') {
                switchTab('input');
            } else if (tab === 'statistics') {
                switchTab('statistics');
                initCharts();
            }
        });

        // Initialize charts when statistics tab is shown
        function initCharts() {
            // Data untuk chart kategori
            const kategoriLabels = @json(collect($kategoriStats)->pluck('label'));
            const kategoriData = @json(collect($kategoriStats)->pluck('count'));

            // Data untuk chart status
            const statusLabels = ['Menunggu', 'Proses', 'Selesai'];
            const statusData = [@json($statusStats['Menunggu']), @json($statusStats['Proses']), @json($statusStats['Selesai'])];

            // Data untuk chart bulanan
            const monthlyLabels = @json(collect($monthlyStats)->pluck('month'));
            const monthlyData = @json(collect($monthlyStats)->pluck('count'));

            // Data untuk chart tren
            const trenData = @json($trenData);

            // Chart Kategori (Bar Chart)
            const kategoriCtx = document.getElementById('kategoriChart').getContext('2d');
            new Chart(kategoriCtx, {
                type: 'bar',
                data: {
                    labels: kategoriLabels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: kategoriData,
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(139, 92, 246, 0.8)',
                            'rgba(236, 72, 153, 0.8)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(236, 72, 153, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        }
                    }
                }
            });

            // Chart Status (Doughnut Chart)
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            'rgba(239, 68, 68, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(16, 185, 129, 0.8)'
                        ],
                        borderColor: [
                            'rgba(239, 68, 68, 1)',
                            'rgba(245, 158, 11, 1)',
                            'rgba(16, 185, 129, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: 'rgba(255, 255, 255, 0.8)',
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });

            // Chart Bulanan (Line Chart)
            const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
            new Chart(monthlyCtx, {
                type: 'line',
                data: {
                    labels: monthlyLabels,
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: monthlyData,
                        borderColor: 'rgba(139, 92, 246, 1)',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(139, 92, 246, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        }
                    }
                }
            });

            // Chart Tren (Area Chart)
            const trenCtx = document.getElementById('trenChart').getContext('2d');
            const trenLabels = [];
            for (let i = 11; i >= 0; i--) {
                const date = new Date();
                date.setMonth(date.getMonth() - i);
                trenLabels.push(date.toLocaleDateString('id-ID', { month: 'short', year: 'numeric' }));
            }

            new Chart(trenCtx, {
                type: 'line',
                data: {
                    labels: trenLabels,
                    datasets: [{
                        label: 'Tren Pengaduan',
                        data: trenData,
                        borderColor: 'rgba(249, 115, 22, 1)',
                        backgroundColor: 'rgba(249, 115, 22, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: 'rgba(249, 115, 22, 1)',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: 'rgba(255, 255, 255, 0.8)',
                                maxTicksLimit: 12
                            }
                        }
                    }
                }
            });
        }

        function cetakLaporanAdmin(elementId) {
            const element = document.getElementById(elementId);
            if (!element) {
                alert('Data laporan tidak ditemukan');
                return;
            }

            const printWindow = window.open('', '_blank', 'width=900,height=700,scrollbars=yes,resizable=yes');
            if (!printWindow) {
                alert('Popup blocker mungkin aktif. Izinkan popup untuk situs ini.');
                return;
            }

            const styles = `
                <style>
                    body { font-family: Arial, sans-serif; color: #000; margin: 0; padding: 20px; }
                    h2 { margin-bottom: 16px; }
                    p { margin: 8px 0; line-height: 1.5; }
                    img { max-width: 100%; height: auto; margin-top: 15px; border: 1px solid #ccc; }
                </style>
            `;

            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Cetak Laporan</title>
                        ${styles}
                    </head>
                    <body>
                        ${element.innerHTML}
                    </body>
                </html>
            `);
            printWindow.document.close();

            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                }, 500);
            };
        }

        function cetakSemuaLaporan() {
            const blocks = Array.from(document.querySelectorAll('[id^="laporan-admin-"], [id^="laporan-proses-"]'));
            const printBlocks = blocks.filter(block => block.innerHTML.trim().length > 0);

            if (printBlocks.length === 0) {
                alert('Tidak ada laporan untuk dicetak.');
                return;
            }

            const content = printBlocks.map(block => `<div style="page-break-after: always; margin-bottom: 30px;">${block.innerHTML}</div>`).join('');
            const printWindow = window.open('', '_blank', 'width=1000,height=800,scrollbars=yes,resizable=yes');

            if (!printWindow) {
                alert('Popup blocker mungkin aktif. Izinkan popup untuk situs ini.');
                return;
            }

            const styles = `
                <style>
                    body { font-family: Arial, sans-serif; color: #000; margin: 0; padding: 20px; }
                    h1, h2 { margin: 0 0 16px; }
                    p { margin: 8px 0; line-height: 1.6; }
                    img { max-width: 100%; height: auto; margin-top: 15px; border: 1px solid #ccc; }
                    .report-block { margin-bottom: 40px; }
                </style>
            `;

            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>Cetak Semua Laporan</title>
                        ${styles}
                    </head>
                    <body>
                        <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px;">
                            <h1 style="margin-bottom: 10px;">Rekap Laporan Aspirasi</h1>
                            <p style="margin: 5px 0;"><strong>Dicetak oleh Admin:</strong> {{ Auth::guard('admin')->user()->nama ?? 'Admin' }}</p>
                            <p style="margin: 5px 0;"><strong>Tanggal Cetak:</strong> {{ now()->format('d F Y H:i:s') }}</p>
                            <p style="margin: 5px 0;"><strong>Total Laporan:</strong> ${printBlocks.length} laporan</p>
                        </div>
                        ${content}
                    </body>
                </html>
            `);
            printWindow.document.close();

            printWindow.onload = function() {
                setTimeout(function() {
                    printWindow.focus();
                    printWindow.print();
                    printWindow.close();
                }, 500);
            };
        }

        // Function to show photo modal
        function showFotoModal(fotoSrc, idAspirasi) {
            const modal = document.getElementById('fotoModal');
            const modalImg = document.getElementById('modalFotoImg');
            const modalTitle = document.getElementById('modalFotoTitle');

            modalImg.src = fotoSrc;
            modalTitle.textContent = `Foto Laporan #${idAspirasi}`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        // Function to close photo modal
        function closeFotoModal() {
            const modal = document.getElementById('fotoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('fotoModal');
            if (e.target === modal) {
                closeFotoModal();
            }
        });

        // Close modal with ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeFotoModal();
            }
        });
    </script>

    {{-- Foto Modal --}}
    <div id="fotoModal" class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50 p-4">
        <div class="relative max-w-4xl max-h-full bg-slate-800 rounded-2xl p-6 shadow-2xl">
            <div class="flex items-center justify-between mb-4">
                <h3 id="modalFotoTitle" class="text-xl font-bold text-white">Foto Laporan</h3>
                <button onclick="closeFotoModal()" class="text-slate-400 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="flex justify-center">
                <img id="modalFotoImg" src="" alt="Foto Laporan" class="max-w-full max-h-96 rounded-xl object-contain border border-slate-600">
            </div>
            <div class="mt-4 text-center">
                <p class="text-sm text-slate-400">Klik di luar modal atau tekan ESC untuk menutup</p>
            </div>
        </div>
    </div>
</body>
</html>