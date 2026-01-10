<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>419 - Sesi Kedaluwarsa | RumahKedua</title>

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

        .clock-spin {
            animation: spin-slow 8s linear infinite;
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .warning-glow {
            box-shadow: 0 0 40px -10px rgba(245, 158, 11, 0.3);
        }
    </style>
</head>

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-5%] left-[-5%] w-[40%] h-[40%] bg-amber-100/40 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-5%] right-[-5%] w-[40%] h-[40%] bg-blue-100/30 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 text-center">

        <div class="layered-surface rounded-[2.5rem] p-10 md:p-12 relative overflow-hidden">

            <div class="relative inline-flex mb-8">
                <div class="absolute inset-0 bg-amber-500 rounded-[2rem] rotate-12 opacity-10"></div>
                <div class="bg-white warning-glow w-24 h-24 rounded-[2rem] flex items-center justify-center relative z-10 border border-slate-100">
                    <div class="relative">
                        <i class="fa-solid fa-hourglass-half text-amber-500 text-4xl"></i>
                        <i class="fa-solid fa-rotate-right text-amber-200 text-sm absolute -top-1 -right-2 clock-spin"></i>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div class="relative">
                    <h1 class="text-7xl font-black tracking-tighter text-slate-900 italic">419</h1>
                    <div class="flex items-center justify-center gap-3">
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                        <h2 class="text-xs font-black uppercase tracking-[0.4em] text-amber-600">Session Expired</h2>
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                    </div>
                </div>

                <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">
                    Sesi keamanan Anda telah berakhir demi melindungi data Anda. Silakan muat ulang halaman untuk melanjutkan.
                </p>
            </div>

            <div class="mt-10 space-y-3">
                <button onclick="window.location.reload()"
                    class="group relative inline-flex items-center justify-center w-full bg-slate-900 text-white px-8 py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-amber-600 hover:shadow-[0_12px_24px_rgba(245,158,11,0.2)] hover:-translate-y-1">
                    <span class="relative z-10 text-[11px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-sync-alt text-[10px] group-hover:rotate-180 transition-transform duration-500"></i> Muat Ulang Halaman
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>

                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center w-full bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-slate-50 hover:text-slate-900">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100">
                <div class="flex items-center justify-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                    <i class="fas fa-shield-halved text-amber-500/50"></i>
                    <span>Sistem Keamanan Aktif</span>
                </div>
            </div>
        </div>

        <div class="mt-8 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 opacity-60">
            © {{ date('Y') }} RumahKedua — Secure Environment
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
</body>

</html>
