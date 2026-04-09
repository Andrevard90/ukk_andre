<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Pengaduan Siswa</title>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4"/>
                </svg>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight uppercase">Pengaduan Siswa</h1>
            <p class="text-slate-500 text-xs mt-2 font-bold uppercase tracking-widest">Platform Aspirasi Siswa</p>
        </div>

        <!-- ERROR MESSAGES -->
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

        <!-- SUCCESS MESSAGE -->
        @if(session('success'))
            <div class="mb-6 p-5 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-center animate__animated animate__fadeInUp">
                <div class="text-emerald-400 text-sm font-bold mb-2 flex justify-center gap-2">
                     <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                     {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="glass rounded-[2.5rem] shadow-2xl p-8 md:p-10">

            <!-- LOGIN FORM -->
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] mb-2 ml-1">Username / NIS</label>
                    <input type="text" name="login" required placeholder="Masukkan username atau NIS"
                        class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-6 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300" value="{{ old('login') }}">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-cyan-500 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Masukkan password"
                        class="input-focus-glow w-full rounded-2xl border border-white/5 bg-white/[0.02] px-6 py-3.5 text-white placeholder-white/10 outline-none transition-all duration-300">
                </div>

                <button type="submit" class="btn-grad w-full text-white font-bold py-3.5 px-6 rounded-2xl transition-all duration-300 hover:shadow-lg hover:shadow-cyan-500/20 uppercase tracking-widest font-black text-sm">
                    Masuk
                </button>

                <p class="text-center text-white/60 text-xs">
                    Belum punya akun? <a href="{{ route('register') }}" class="text-cyan-400 font-bold hover:underline">Daftar sekarang</a>
                </p>
            </form>

        </div>

        <p class="text-center text-[10px] font-bold text-slate-600 mt-8 uppercase tracking-[0.3em]">&copy; {{ date('Y') }} E-Aspirasi Sekolah • Sistem Informasi Pengaduan</p>

    </div>

</body>
</html>