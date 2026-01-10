<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>403 - Akses Ditolak | RumahKedua</title>

    <link rel="icon" href="{{ asset('assets/image/favicon/logo.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .layered-surface {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow:
                0 4px 6px -1px rgba(0, 0, 0, 0.05),
                0 20px 40px -10px rgba(0, 0, 0, 0.08);
        }

        .error-glow {
            box-shadow: 0 0 50px -10px rgba(59, 130, 246, 0.3);
        }

        @keyframes pulse-soft {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
            }

            50% {
                opacity: 0.8;
                transform: scale(0.95);
            }
        }

        .animate-pulse-soft {
            animation: pulse-soft 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-100/50 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-slate-200/50 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 text-center">

        <div class="layered-surface rounded-[2.5rem] p-10 md:p-12 relative overflow-hidden">

            <div class="relative inline-flex mb-8">
                <div class="absolute inset-0 bg-blue-600 rounded-3xl rotate-12 opacity-10 animate-pulse-soft"></div>
                <div class="bg-white error-glow w-20 h-20 rounded-3xl flex items-center justify-center relative z-10 border border-slate-100">
                    <i class="fa-solid fa-shield-halved text-blue-600 text-3xl"></i>
                </div>
            </div>

            <div class="space-y-4">
                <div class="space-y-1">
                    <h1 class="text-7xl font-black tracking-tighter text-slate-900 italic">403</h1>
                    <div class="flex items-center justify-center gap-3">
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                        <h2 class="text-xs font-black uppercase tracking-[0.4em] text-blue-600">Restricted Area</h2>
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                    </div>
                </div>

                <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">
                    Maaf, sistem mendeteksi bahwa akun Anda tidak memiliki izin untuk melihat halaman ini.
                </p>
            </div>

            <div class="mt-10 space-y-3">
                <a href="{{ url('/') }}"
                    class="group relative inline-flex items-center justify-center w-full bg-slate-900 text-white px-8 py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-blue-600 hover:shadow-[0_12px_24px_rgba(37,99,235,0.2)] hover:-translate-y-1">
                    <span class="relative z-10 text-[11px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-home text-[10px]"></i> Kembali ke Beranda
                    </span>
                </a>

                <button onclick="window.history.back()"
                    class="inline-flex items-center justify-center w-full bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-slate-50 hover:text-slate-900">
                    Go Back
                </button>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    Pikir ini kesalahan? <a href="#" class="text-blue-600 hover:underline">Hubungi Admin</a>
                </p>
            </div>
        </div>

        <div class="mt-8 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 opacity-60 flex items-center justify-center gap-4">
            <span>© {{ date('Y') }} RumahKedua</span>
            <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
            <span>Security System v2.1</span>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
</body>

</html>
