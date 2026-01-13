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
            /* Background: #fffffe */
            background-color: #fffffe;
        }

        .layered-surface {
            /* Glassmorphism menggunakan warna Main (#fffffe) */
            background: rgba(255, 255, 254, 0.8);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(144, 180, 206, 0.2);
            /* Menggunakan Secondary (#90b4ce) */
            box-shadow:
                0 4px 6px -1px rgba(9, 64, 103, 0.03),
                0 30px 60px -12px rgba(9, 64, 103, 0.12),
                inset 0 0 20px rgba(255, 255, 254, 0.5);
        }

        .input-inset {
            /* Paragraph color background soft */
            background: rgba(144, 180, 206, 0.05);
            border: 1px solid rgba(144, 180, 206, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-inset:focus-within {
            background: #fff;
            /* Focus: Highlight (#3da9fc) */
            border-color: #3da9fc;
            box-shadow: 0 0 0 4px rgba(61, 169, 252, 0.1);
        }

        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 relative [&::-webkit-scrollbar]:hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[45%] h-[45%] bg-[#90b4ce]/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[45%] h-[45%] bg-[#3da9fc]/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-[440px] relative z-10">

        <div class="layered-surface rounded-[3rem] p-10 md:p-12 relative overflow-hidden">

            <div class="text-center mb-10">
                <div class="inline-flex relative mb-6">
                    <div class="absolute inset-0 bg-[#3da9fc] rounded-[1.2rem] rotate-6 opacity-20"></div>
                    <div class="bg-[#094067] text-[#fffffe] w-14 h-14 rounded-[1.2rem] flex items-center justify-center relative z-10 shadow-lg shadow-[#094067]/20">
                        <i class="fas fa-home text-xl"></i>
                    </div>
                </div>
                <h1 class="text-2xl font-black tracking-tight text-[#094067] uppercase">
                    Rumah<span class="text-[#3da9fc]">Kedua</span>
                </h1>
                <div class="flex items-center justify-center gap-2 mt-2">
                    <span class="h-[1px] w-4 bg-[#90b4ce]/40"></span>
                    <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#90b4ce]">Secure Access</p>
                    <span class="h-[1px] w-4 bg-[#90b4ce]/40"></span>
                </div>
            </div>

            <form method="POST" action="{{ route('authentication') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-[11px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Account Email</label>
                    <div class="input-inset flex items-center px-4 rounded-2xl group">
                        <i class="fas fa-envelope text-[#90b4ce] text-xs mr-3 transition-colors group-focus-within:text-[#3da9fc]"></i>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="w-full py-4 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]" placeholder="mail@rumahkedua.com">
                    </div>
                    @error('email')
                        <p class="text-[10px] font-bold text-[#ef4565] mt-1 ml-1 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-[11px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Security Key</label>
                    <div class="input-inset flex items-center px-4 rounded-2xl group">
                        <i class="fas fa-lock text-[#90b4ce] text-xs mr-3 transition-colors group-focus-within:text-[#3da9fc]"></i>
                        <input type="password" name="password" id="password" class="w-full py-4 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]"
                            placeholder="••••••••">
                    </div>
                    @error('password')
                        <p class="text-[10px] font-bold text-[#ef4565] mt-1 ml-1 flex items-center gap-1">
                            <i class="fas fa-circle-exclamation"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between px-1 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <div class="relative flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="peer hidden">
                            <div class="w-5 h-5 rounded-md border-2 border-[#90b4ce]/30 peer-checked:bg-[#3da9fc] peer-checked:border-[#3da9fc] transition-all flex items-center justify-center">
                                <i class="fas fa-check text-[10px] text-[#fffffe] opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <span class="text-xs font-bold text-[#5f6c7b] group-hover:text-[#094067] transition-colors">Keep me signed in</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full group relative bg-[#3da9fc] text-[#fffffe] font-black uppercase tracking-widest text-[11px] py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-[0_20px_40px_-10px_rgba(61,169,252,0.4)] hover:-translate-y-1 active:translate-y-0">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Masuk Ke Akun <i class="fas fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>
            </form>

            <div class="mt-10 pt-8 border-t border-[#90b4ce]/20 text-center space-y-4">
                <p class="text-[11px] font-bold text-[#90b4ce] uppercase tracking-widest">
                    Belum Bergabung?
                    <a href="{{ route('register') }}" class="text-[#3da9fc] hover:text-[#094067] transition-colors ml-1">Buat Akun</a>
                </p>

                <a href="/" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#90b4ce] hover:text-[#094067] transition-all">
                    <i class="fas fa-chevron-left text-[8px]"></i> Kembali Ke Beranda
                </a>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-4 opacity-70 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-[#3da9fc] animate-pulse"></div>
                <span class="text-[10px] font-black uppercase tracking-widest text-[#90b4ce]">End-to-end Encrypted</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />
</body>

</html>
