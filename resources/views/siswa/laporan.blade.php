<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Status Laporan - E-Aspirasi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 to-slate-800 text-white p-4 md:p-8">

    <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-bold">Status <span class="text-blue-400">Laporan</span></h1>
                <p class="text-slate-400 text-sm mt-2">Pantau status laporan aspirasi Anda</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('siswa.dashboard') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition">
                    ← Kembali
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 rounded-lg font-semibold transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500/20 border border-green-500 rounded-lg text-green-200">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-lg text-red-200">
                {{ session('error') }}
            </div>
        @endif

        {{-- Tabs Navigation --}}
        <div class="flex gap-4 mb-8 border-b border-slate-700">
            <button onclick="switchTab('masuk')" class="tab-btn active px-6 py-3 font-semibold text-blue-400 border-b-2 border-blue-400">
                ⏳ Sedang Diproses ({{ $laporanMasuk->count() }})
            </button>
            <button onclick="switchTab('diproses')" class="tab-btn px-6 py-3 font-semibold text-slate-400 hover:text-white">
                ✅ Sudah Diproses ({{ $laporanDiproses->count() }})
            </button>
        </div>

        {{-- TAB 1: LAPORAN SEDANG DIPROSES --}}
        <div id="masuk" class="tab-content block space-y-6">
            @forelse($laporanMasuk as $item)
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 bg-yellow-500/20 text-yellow-300 rounded-full text-sm font-semibold">
                                    ⏳ Menunggu Diproses
                                </span>
                                <span class="text-slate-400 text-sm">{{ $item->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ $item->kategori->ket_kategori ?? 'N/A' }}</h3>
                        </div>
                        <span class="text-slate-400 text-sm">#{{ $item->id_pelaporan }}</span>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="text-sm text-slate-400">Lokasi:</label>
                            <p class="text-slate-200">{{ $item->lokasi }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-slate-400">Keterangan:</label>
                            <p class="text-slate-200">{{ $item->ket }}</p>
                        </div>
                        <div>
                            <label class="text-sm text-slate-400">Tanggal Laporan:</label>
                            <p class="text-slate-200">📅 {{ $item->tanggal->format('d M Y') }}</p>
                        </div>
                        @if($item->foto)
                            <div>
                                <label class="text-sm text-slate-400">Foto:</label>
                                <div class="mt-2 flex justify-center">
                                    <img src="{{ asset('foto_aspirasi/' . $item->foto) }}" alt="Foto Laporan" class="w-48 h-64 rounded-lg border border-slate-600 shadow-lg object-cover">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400">
                    <p class="text-xl">Tidak ada laporan yang sedang diproses</p>
                </div>
            @endforelse
        </div>

        {{-- TAB 2: LAPORAN SUDAH DIPROSES --}}
        <div id="diproses" class="tab-content hidden space-y-6">
            @forelse($laporanDiproses as $item)
                <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ 
                                    $item->status == 'Menunggu' ? 'bg-yellow-500/20 text-yellow-300' :
                                    ($item->status == 'Proses' ? 'bg-blue-500/20 text-blue-300' :
                                    'bg-green-500/20 text-green-300')
                                }}">
                                    {{ 
                                        $item->status == 'Menunggu' ? '⏳ Menunggu' :
                                        ($item->status == 'Proses' ? '🔄 Dalam Proses' :
                                        '✅ Selesai')
                                    }}
                                </span>
                                <span class="text-slate-400 text-sm">{{ $item->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <h3 class="text-lg font-bold mb-2">{{ $item->kategori->ket_kategori ?? 'N/A' }}</h3>
                        </div>
                        <span class="text-slate-400 text-sm">#{{ $item->id_aspirasi }}</span>
                    </div>

                    <div class="space-y-3 bg-slate-900/50 p-4 rounded-lg">
                        @if($item->inputAspirasi)
                            <div>
                                <label class="text-sm text-slate-400">Lokasi:</label>
                                <p class="text-slate-200">{{ $item->inputAspirasi->lokasi }}</p>
                            </div>
                            <div>
                                <label class="text-sm text-slate-400">Keterangan Awal:</label>
                                <p class="text-slate-200">{{ $item->inputAspirasi->ket }}</p>
                            </div>
                            @if($item->inputAspirasi->foto)
                                <div>
                                    <label class="text-sm text-slate-400">Foto Laporan:</label>
                                    <div class="mt-2 flex justify-center">
                                        <img src="{{ asset('foto_aspirasi/' . $item->inputAspirasi->foto) }}" alt="Foto Laporan" class="w-48 h-64 rounded-lg border border-slate-600 shadow-lg object-cover">
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div>
                            <label class="text-sm text-slate-400">📝 Tanggapan Admin:</label>
                            <p class="text-slate-200 bg-slate-800 p-3 rounded">{{ $item->feedback ?? 'Belum ada tanggapan dari admin' }}</p>
                        </div>
                        <div class="space-y-3 mt-4 bg-slate-900/50 p-4 rounded-lg border border-slate-700">
                            <label class="block text-sm font-semibold mb-2">Balas Tanggapan Admin</label>
                            <form method="POST" action="{{ route('siswa.feedback', $item->id_aspirasi) }}">
                                @csrf
                                <textarea name="siswa_feedback" rows="3" class="w-full px-3 py-2 bg-slate-800 border border-slate-600 rounded-lg text-white placeholder-slate-500 focus:border-cyan-400" placeholder="Tulis jawaban atau catatan Anda...">{{ $item->siswa_feedback }}</textarea>
                                <button type="submit" class="mt-3 w-full px-4 py-2 bg-cyan-600 hover:bg-cyan-700 rounded-lg font-semibold transition">
                                    Kirim Tanggapan
                                </button>
                            </form>
                        </div>
                        @if($item->siswa_feedback)
                            <div class="mt-4 p-4 bg-slate-900/60 rounded-lg border border-slate-700">
                                <p class="text-sm text-slate-400 mb-2">🧑‍🎓 Feedback Anda:</p>
                                <p class="text-slate-200">{{ $item->siswa_feedback }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-slate-400">
                    <p class="text-xl">Tidak ada laporan yang sudah diproses</p>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });

            // Remove active style from all buttons
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('active', 'border-b-2', 'border-blue-400', 'text-blue-400');
                btn.classList.add('text-slate-400');
            });

            // Show selected tab
            document.getElementById(tabName).classList.remove('hidden');

            // Add active style to clicked button
            event.target.classList.add('active', 'border-b-2', 'border-blue-400', 'text-blue-400');
            event.target.classList.remove('text-slate-400');
        }
    </script>

</body>
</html>
