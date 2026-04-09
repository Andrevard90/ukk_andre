<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <title>Dashboard Siswa - E-Aspirasi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        :root {
            --primary-glow: rgba(6, 182, 212, 0.2);
            --accent-color: #06b6d4; 
        }

        .glass { 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px); 
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-focus-glow:focus {
            box-shadow: 0 0 20px var(--primary-glow);
            border-color: var(--accent-color) !important;
        }

        .btn-grad {
            background-size: 200% auto;
            transition: 0.5s;
            background-image: linear-gradient(to right, #0891b2 0%, #4f46e5 51%, #0891b2 100%);
        }
        .btn-grad:hover { background-position: right center; }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite alternate; }
    </style>
</head>
<body class="min-h-screen bg-[#020617] text-white p-4 md:p-8 relative overflow-x-hidden">

    {{-- Background Decorative Orbs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="animate-blob absolute top-0 -left-4 w-72 h-72 bg-cyan-600 rounded-full mix-blend-screen filter blur-[100px] opacity-10"></div>
        <div class="animate-blob animation-delay-2000 absolute bottom-0 right-0 w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-10"></div>
    </div>

    <div class="max-w-4xl mx-auto relative z-10">
        
        {{-- Header & Logout --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4 animate__animated animate__fadeInDown">
            <div>
                <h1 class="text-3xl font-extrabold tracking-tight">Dashboard <span class="text-cyan-400">Siswa</span></h1>
                <p class="text-slate-400 text-sm mt-1 uppercase tracking-widest font-bold opacity-70">Layanan Aspirasi & Pengaduan</p>
            </div>
            
            <div class="flex gap-3">
                <a href="{{ route('siswa.laporan') }}" class="group flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-500/10 border border-blue-500/20 text-blue-400 hover:bg-blue-500 hover:text-white transition-all duration-300 font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    LIHAT STATUS
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-6 py-3 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 hover:bg-red-500 hover:text-white transition-all duration-300 font-bold text-sm">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        LOGOUT
                    </button>
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
            {{-- Welcome Card --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="glass p-8 rounded-[2.5rem] animate__animated animate__fadeInLeft">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center mb-6 shadow-xl shadow-cyan-500/20">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Selamat Datang,</h2>
                    <p class="text-cyan-400 font-black text-2xl tracking-tight mt-1">{{ Auth::guard('siswa')->user()->username ?? 'Siswa' }}</p>
                    <div class="mt-6 pt-6 border-t border-white/5 space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500 font-bold uppercase tracking-tighter">NIS Anda</span>
                            <span class="text-slate-300 font-mono">{{ Auth::guard('siswa')->user()->nis }}</span>
                        </div>
                    </div>
                </div>

                {{-- Status Info --}}
                <div class="glass p-6 rounded-[2rem] border-l-4 border-l-cyan-500 animate__animated animate__fadeInLeft animate__delay-1s">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-1">Tips Melapor</p>
                    <p class="text-sm text-slate-300 leading-relaxed">Gunakan foto yang jelas dan tentukan lokasi spesifik agar laporan segera diproses.</p>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="lg:col-span-3">
                <div class="glass p-8 md:p-10 rounded-[2.5rem] shadow-2xl animate__animated animate__fadeInRight">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-xl bg-cyan-500/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <h3 class="text-xl font-bold">Buat Laporan Baru</h3>
                    </div>

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-2xl text-red-400">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-500/20 border border-red-500 rounded-2xl">
                            <ul class="text-red-400 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('aspirasi.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        {{-- Hidden/Readonly NIS --}}
                        <input type="hidden" name="nis" value="{{ Auth::guard('siswa')->user()->nis }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-widest mb-2 ml-1">Kategori</label>
                                <select name="id_kategori" required
                                    class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-5 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300">
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="1">Kebersihan</option>
                                    <option value="2">Keselamatan</option>
                                    <option value="3">Fasilitas</option>
                                    <option value="4">Pembelajaran</option>
                                    <option value="5">Administrasi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-widest mb-2 ml-1">Tanggal Kejadian</label>
                                <input type="date" name="tanggal_date" id="tanggalDate" required
                                    max="{{ now()->format('Y-m-d') }}"
                                    class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-5 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300">
                                <input type="hidden" name="tanggal" id="tanggalFull">
                                <p class="text-xs text-slate-400 mt-2"></p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-widest mb-2 ml-1">Lokasi Kejadian</label>
                            <input type="text" name="lokasi" required
                                class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-5 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300"
                                placeholder="Contoh: Kantin, Lab Komputer">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-widest mb-2 ml-1">Keterangan Aspirasi</label>
                            <textarea name="keterangan" rows="4" required
                                class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-5 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300 resize-none"
                                placeholder="Deskripsikan laporan Anda secara detail..."></textarea>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-widest mb-2 ml-1">Lampiran Foto <span class="text-slate-500 font-normal">(Opsional)</span></label>
                            <div class="relative group">
                                <input type="file" name="foto" id="fotoInput"
                                    accept="image/*"
                                    class="block w-full text-sm text-slate-400 file:mr-4 file:py-3 file:px-6 file:rounded-2xl file:border-0 file:text-xs file:font-black file:uppercase file:bg-cyan-500/10 file:text-cyan-400 hover:file:bg-cyan-500/20 transition-all cursor-pointer">
                            </div>
                            {{-- Preview Foto --}}
                            <div id="fotoPreview" class="mt-4 hidden flex justify-center">
                                <img id="previewImg" src="" alt="Preview" class="w-48 h-64 rounded-2xl border border-cyan-500/30 shadow-lg shadow-cyan-500/20 object-cover">
                                <button type="button" onclick="clearPreview()" class="mt-2 px-4 py-2 bg-red-500/20 hover:bg-red-500/40 text-red-400 rounded-lg text-sm font-semibold transition">
                                    Hapus Foto
                                </button>
                            </div>
                        </div>

                        <button type="submit"
                            class="btn-grad w-full rounded-2xl px-4 py-4 text-sm font-black text-white shadow-xl shadow-cyan-900/20 hover:shadow-cyan-500/30 transition-all duration-300 active:scale-95 uppercase tracking-widest mt-4">
                            KIRIM LAPORAN SEKARANG
                        </button>
                    </form>
                </div>
            </div>
        </div>

        </div>

        <p class="text-center text-[10px] font-bold text-slate-600 mt-12 uppercase tracking-[0.3em] animate__animated animate__fadeIn">&copy; {{ date('Y') }} E-Aspirasi Sekolah • Sistem Informasi Pengaduan</p>
    </div>

    <script>
        // Handle foto preview
        const fotoInput = document.getElementById('fotoInput');
        const fotoPreview = document.getElementById('fotoPreview');
        const previewImg = document.getElementById('previewImg');

        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImg.src = event.target.result;
                    fotoPreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function clearPreview() {
            fotoInput.value = '';
            fotoPreview.classList.add('hidden');
            previewImg.src = '';
        }

        // Handle automatic time insertion
        const tanggalDateInput = document.getElementById('tanggalDate');
        const tanggalFullInput = document.getElementById('tanggalFull');
        const submitBtn = document.querySelector('button[type="submit"]');

        // Get current time in HH:mm format
        function getCurrentTime() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            return `${hours}:${minutes}`;
        }

        // Update hidden tanggal field when date changes
        tanggalDateInput.addEventListener('change', function() {
            const selectedDate = tanggalDateInput.value;
            if (selectedDate) {
                const currentTime = getCurrentTime();
                tanggalFullInput.value = `${selectedDate}T${currentTime}`;
                console.log('Tanggal updated:', tanggalFullInput.value);
            }
        });

        // Also set on submit to ensure latest time (only for aspirasi form)
        const aspirasiForm = document.querySelector('form[action*="aspirasi.store"]');
        if (aspirasiForm) {
            aspirasiForm.addEventListener('submit', function(e) {
                const selectedDate = tanggalDateInput.value;
                if (!selectedDate) {
                    e.preventDefault();
                    alert('Silakan pilih tanggal kejadian');
                    return;
                }
                const currentTime = getCurrentTime();
                tanggalFullInput.value = `${selectedDate}T${currentTime}`;
                console.log('Form submitted with tanggal:', tanggalFullInput.value);
            });
        }
    </script>

</body>
</html>