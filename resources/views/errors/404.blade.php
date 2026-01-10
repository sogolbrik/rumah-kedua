<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>404 - Halaman Tidak Ditemukan | RumahKedua</title>

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

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(3deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        .ghost-glow {
            box-shadow: 0 0 40px -10px rgba(59, 130, 246, 0.2);
        }
    </style>
</head>

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full max-w-lg">
        <div class="absolute top-0 left-0 w-64 h-64 bg-blue-200/30 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-indigo-200/30 rounded-full blur-[100px]"></div>
    </div>

    <div class="w-full max-w-md relative z-10 text-center">

        <div class="layered-surface rounded-[2.5rem] p-10 md:p-12 relative overflow-hidden">

            <div class="relative inline-flex mb-8 floating">
                <div class="bg-white ghost-glow w-24 h-24 rounded-[2rem] flex items-center justify-center relative z-10 border border-slate-100 shadow-sm">
                    <i class="fa-solid fa-compass text-blue-600 text-4xl"></i>
                </div>
                <div class="absolute -top-2 -right-2 w-6 h-6 bg-blue-500 rounded-full border-4 border-white z-20"></div>
                <div class="absolute -bottom-1 -left-1 w-4 h-4 bg-slate-200 rounded-full border-2 border-white z-20"></div>
            </div>

            <div class="space-y-4">
                <div class="relative">
                    <h1 class="text-[120px] font-black tracking-tighter text-slate-900/5 leading-none absolute left-1/2 -translate-x-1/2 -top-10 select-none">
                        404
                    </h1>
                    <h2 class="text-2xl font-black text-slate-900 relative z-10">Lost in Space?</h2>
                </div>

                <p class="text-[13px] font-semibold text-slate-500 leading-relaxed px-4">
                    Maaf, halaman yang Anda tuju tidak ditemukan atau telah berpindah alamat. Mari kembali ke jalur yang benar.
                </p>
            </div>

            <div class="mt-10 space-y-3">
                <a href="{{ url('/') }}"
                    class="group relative inline-flex items-center justify-center w-full bg-slate-900 text-white px-8 py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-blue-600 hover:shadow-[0_12px_24px_rgba(37,99,235,0.2)] hover:-translate-y-1">
                    <span class="relative z-10 text-[11px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-home text-[10px]"></i> Back to Dashboard
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </a>

                <button onclick="window.history.back()"
                    class="inline-flex items-center justify-center w-full bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-slate-50 hover:text-slate-900">
                    <i class="fas fa-arrow-left text-[10px] mr-2"></i> Go Back
                </button>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100 flex justify-center gap-6">
                <a href="/#faq" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-blue-600 transition-colors">FAQ</a>
                <a href="/#kamar" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-blue-600 transition-colors">Daftar Kamar</a>
                <a href="/#lokasi" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest hover:text-blue-600 transition-colors">Lokasi</a>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-4 opacity-40">
            <span class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-500">Error Code: Page_Not_Found_404</span>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
</body>

</html>
