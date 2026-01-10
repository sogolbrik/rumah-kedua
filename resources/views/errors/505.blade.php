<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>500 - Kesalahan Server | RumahKedua</title>

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

        @keyframes glitch {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-2px, 2px);
            }

            40% {
                transform: translate(-2px, -2px);
            }

            60% {
                transform: translate(2px, 2px);
            }

            80% {
                transform: translate(2px, -2px);
            }

            100% {
                transform: translate(0);
            }
        }

        .glitch-hover:hover {
            animation: glitch 0.3s linear infinite;
        }

        .error-glow-red {
            box-shadow: 0 0 40px -10px rgba(225, 29, 72, 0.2);
        }
    </style>
</head>

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[45%] h-[45%] bg-rose-100/40 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[45%] h-[45%] bg-slate-200/50 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md relative z-10 text-center">

        <div class="layered-surface rounded-[2.5rem] p-10 md:p-12 relative overflow-hidden">

            <div class="relative inline-flex mb-8">
                <div class="absolute inset-0 bg-rose-600 rounded-[2rem] rotate-12 opacity-10"></div>
                <div class="bg-white error-glow-red w-24 h-24 rounded-[2rem] flex items-center justify-center relative z-10 border border-slate-100">
                    <i class="fa-solid fa-server text-rose-600 text-4xl glitch-hover"></i>
                </div>
                <div class="absolute top-1 right-1 w-5 h-5 bg-rose-500 rounded-full border-4 border-white z-20 animate-pulse"></div>
            </div>

            <div class="space-y-4">
                <div class="relative">
                    <h1 class="text-7xl font-black tracking-tighter text-slate-900 italic">500</h1>
                    <div class="flex items-center justify-center gap-3">
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                        <h2 class="text-xs font-black uppercase tracking-[0.4em] text-rose-600">Server Interrupted</h2>
                        <span class="h-[1px] w-6 bg-slate-200"></span>
                    </div>
                </div>

                <p class="text-sm font-medium text-slate-500 leading-relaxed px-2">
                    Terjadi kendala teknis pada server kami. Tim teknisi telah diberitahu dan sedang bekerja memperbaikinya.
                </p>
            </div>

            <div class="mt-10 space-y-3">
                <button onclick="window.location.reload()"
                    class="group relative inline-flex items-center justify-center w-full bg-slate-900 text-white px-8 py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-rose-600 hover:shadow-[0_12px_24px_rgba(225,29,72,0.2)] hover:-translate-y-1">
                    <span class="relative z-10 text-[11px] font-black uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-redo-alt text-[10px]"></i> Coba Muat Ulang
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>

                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center w-full bg-white border border-slate-200 text-slate-600 px-8 py-4 rounded-2xl text-[11px] font-black uppercase tracking-widest transition-all hover:bg-slate-50 hover:text-slate-900">
                    Kembali ke Beranda
                </a>
            </div>

            <div class="mt-8 pt-8 border-t border-slate-100">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-50 border border-slate-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-400">Incident Reported</span>
                </div>
            </div>
        </div>

        <div class="mt-8 text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 opacity-60">
            © {{ date('Y') }} RumahKedua — Infrastructure Status
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
</body>

</html>
