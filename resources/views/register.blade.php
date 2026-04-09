<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Siswa - E-Aspirasi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #020617;
        }

        .glass { 
            backdrop-filter: blur(25px); 
            -webkit-backdrop-filter: blur(25px); 
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .input-focus-glow:focus {
            box-shadow: 0 0 20px rgba(6, 182, 212, 0.15);
            border-color: #06b6d4 !important;
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
<body class="min-h-screen flex items-center justify-center p-4 overflow-hidden relative">

    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="animate-blob absolute -bottom-8 -left-4 w-72 h-72 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
        <div class="animate-blob animation-delay-2000 absolute top-0 right-0 w-80 h-80 bg-cyan-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20"></div>
    </div>

    <div class="w-full max-w-md relative z-10 animate__animated animate__zoomIn">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-cyan-500/10 border border-cyan-500/20 mb-4">
                <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight uppercase">Daftar Akun</h1>
            <p class="text-slate-500 text-xs mt-2 font-bold uppercase tracking-widest">Siswa E-Aspirasi</p>
        </div>

        <div class="glass rounded-[2.5rem] p-8 md:p-10 shadow-2xl border border-white/5">
            
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 animate__animated animate__headShake">
                    <ul class="text-red-400 text-xs font-bold space-y-1">
                        @foreach($errors->all() as $err)
                            <li class="flex items-center gap-2">
                                <span class="w-1 h-1 bg-red-400 rounded-full"></span>
                                {{ $err }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-center animate__animated animate__fadeInUp">
                    <div class="text-emerald-400 text-sm font-bold mb-2 flex justify-center gap-2">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                         {!! session('success') !!}
                    </div>
                    <p class="text-slate-400 text-[10px] uppercase font-bold tracking-wider leading-relaxed">Silakan login dengan NIS dan password yang telah didaftarkan.</p>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] mb-2 ml-1">Nomor Induk Siswa (NIS)</label>
                    <input type="text" name="nis" required placeholder="Contoh: 12345"
                        class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-6 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300" value="{{ old('nis') }}">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] mb-2 ml-1">Kelas Saat Ini</label>
                    <input type="text" name="kelas" required placeholder="Contoh: XII RPL 2"
                        class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-6 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300" value="{{ old('kelas') }}">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password"
                        class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-6 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300">
                </div>

                <button type="submit" 
                    class="btn-grad w-full rounded-2xl py-4 text-xs font-black text-white shadow-xl shadow-cyan-900/20 uppercase tracking-widest mt-2 active:scale-95 transition-transform">
                    Daftar Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-sm text-slate-500 font-medium">
                    Sudah terdaftar? 
                    <a href="{{ route('login') }}" class="text-cyan-400 hover:text-white transition-colors font-bold decoration-cyan-500/30 underline underline-offset-4">Masuk ke Akun</a>
                </p>
            </div>
        </div>
        
        <p class="text-center text-[10px] font-bold text-slate-600 mt-10 uppercase tracking-[0.3em] animate__animated animate__fadeIn">&copy; {{ date('Y') }} E-Aspirasi Sekolah</p>
    </div>

</body>
</html>