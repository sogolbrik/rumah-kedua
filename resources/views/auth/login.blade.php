<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - Login</title>

    <link rel="icon" href="{{ asset('assets/image/favicon/logo.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">
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
                0 20px 40px -10px rgba(0, 0, 0, 0.08),
                inset 0 0 20px rgba(255, 255, 255, 0.5);
        }

        .input-inset {
            background: rgba(248, 250, 252, 0.8);
            border: 1px solid rgba(226, 232, 240, 0.8);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-inset:focus-within {
            background: #fff;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1), inset 0 2px 4px rgba(0, 0, 0, 0.01);
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-200/40 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-200/30 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[440px] relative z-10">

        <div class="layered-surface rounded-[2.5rem] p-10 md:p-12 relative overflow-hidden">

            <div class="text-center mb-10">
                <div class="inline-flex relative mb-6">
                    <div class="absolute inset-0 bg-blue-600 rounded-[1.2rem] rotate-6 opacity-20"></div>
                    <div class="bg-slate-900 text-white w-14 h-14 rounded-[1.2rem] flex items-center justify-center relative z-10 shadow-lg">
                        <i class="fas fa-home text-xl"></i>
                    </div>
                </div>
                <h1 class="text-2xl font-black tracking-tight text-slate-900 uppercase">
                    Rumah<span class="text-blue-600">Kedua</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="h-[1px] w-4 bg-slate-300"></span>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400">Secure Access</p>
                    <span class="h-[1px] w-4 bg-slate-300"></span>
                </div>
            </div>

            <form method="POST" action="{{ route('authentication') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-widest text-slate-500 ml-1">Account Email</label>
                    <div class="input-inset flex items-center px-4 rounded-2xl group">
                        <i class="fas fa-envelope text-slate-400 text-xs mr-3 transition-colors group-focus-within:text-blue-600"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full py-4 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400" placeholder="mail@rumahkedua.com" required>
                    </div>
                    @error('email')
                        <p class="text-[10px] font-bold text-red-500 mt-1 ml-1 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <div class="flex justify-between items-center px-1">
                        <label for="password" class="text-[11px] font-black uppercase tracking-widest text-slate-500">Security Key</label>
                    </div>
                    <div class="input-inset flex items-center px-4 rounded-2xl group">
                        <i class="fas fa-lock text-slate-400 text-xs mr-3 transition-colors group-focus-within:text-blue-600"></i>
                        <input type="password" name="password" id="password" class="w-full py-4 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400"
                            placeholder="••••••••" required>
                    </div>
                </div>

                <div class="flex items-center justify-between px-1 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="peer hidden">
                            <div class="w-5 h-5 rounded-md border-2 border-slate-200 peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all flex items-center justify-center">
                                <i class="fas fa-check text-[10px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-slate-500 group-hover:text-slate-700 transition-colors">Keep me signed in</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full group relative bg-slate-900 text-white font-black uppercase tracking-widest text-[11px] py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-blue-600 hover:shadow-[0_20px_40px_-10px_rgba(37,99,235,0.4)] hover:-translate-y-1 active:translate-y-0">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Masuk Ke Akun <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-slate-200/60 text-center space-y-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Belum Bergabung?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:text-slate-900 transition-colors ml-1">Buat Akun</a>
                </p>

                <a href="/" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-900 transition-all">
                    <i class="fas fa-chevron-left"></i> Kembali Ke Beranda
                </a>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-slate-500">End-to-end Encrypted</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />
</body>

</html>
