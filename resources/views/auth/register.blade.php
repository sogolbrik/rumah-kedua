<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - Create Account</title>

    <link rel="icon" href="{{ asset('assets/image/favicon/logo.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fffffe;
        }

        .layered-surface {
            background: rgba(255, 255, 254, 0.8);
            backdrop-filter: blur(24px);
            border: 1px solid rgba(144, 180, 206, 0.2);
            box-shadow:
                0 4px 6px -1px rgba(9, 64, 103, 0.03),
                0 30px 60px -12px rgba(9, 64, 103, 0.12),
                inset 0 0 20px rgba(255, 255, 254, 0.5);
        }

        .input-inset {
            background: rgba(144, 180, 206, 0.05);
            border: 1px solid rgba(144, 180, 206, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-inset:focus-within {
            background: #fff;
            border-color: #3da9fc;
            box-shadow: 0 0 0 4px rgba(61, 169, 252, 0.1);
        }

        /* Error state */
        .input-error {
            border-color: #ef4565 !important;
            background: rgba(239, 69, 101, 0.03) !important;
        }

        .input-error:focus-within {
            border-color: #ef4565 !important;
            box-shadow: 0 0 0 4px rgba(239, 69, 101, 0.15) !important;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-up {
            animation: slideUp 0.6s ease-out forwards;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 relative [&::-webkit-scrollbar]:hidden"></body>

    <div class="absolute top-[-5%] right-[-5%] w-[40%] h-[40%] bg-[#90b4ce]/20 rounded-full blur-[110px] pointer-events-none"></div>
    <div class="absolute bottom-[-5%] left-[-5%] w-[40%] h-[40%] bg-[#3da9fc]/10 rounded-full blur-[110px] pointer-events-none"></div>

    <div class="w-full max-w-[520px] relative z-10 animate-up">
        <div class="layered-surface rounded-[3rem] p-8 md:p-10 relative overflow-hidden">
            <div class="text-center mb-8">
                <div class="inline-flex relative mb-4">
                    <div class="absolute inset-0 bg-[#3da9fc] rounded-[1rem] rotate-6 opacity-20"></div>
                    <div class="bg-[#094067] text-[#fffffe] w-12 h-12 rounded-[1rem] flex items-center justify-center relative z-10 shadow-lg shadow-[#094067]/20">
                        <i class="fas fa-user-plus text-lg"></i>
                    </div>
                </div>
                <h1 class="text-xl font-black tracking-tight text-[#094067] uppercase">
                    Join <span class="text-[#3da9fc]">RumahKedua</span>
                </h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#90b4ce] mt-2">Create Your Member Account</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4" novalidate>
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Full Name</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group {{ $errors->has('name') ? 'input-error' : '' }}">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full py-3 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]" placeholder="Jhon Doe">
                        </div>
                        @error('name')
                            <p class="text-[10px] text-[#ef4565] font-bold mt-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[8px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Phone Number</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group {{ $errors->has('telepon') ? 'input-error' : '' }}">
                            <input type="tel" name="telepon" value="{{ old('telepon') }}"
                                class="w-full py-3 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]" placeholder="6281...">
                        </div>
                        @error('telepon')
                            <p class="text-[10px] text-[#ef4565] font-bold mt-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[8px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Email Address</label>
                    <div class="input-inset flex items-center px-4 rounded-xl group {{ $errors->has('email') ? 'input-error' : '' }}">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full py-3 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]" placeholder="name@example.com">
                    </div>
                    @error('email')
                        <p class="text-[10px] text-[#ef4565] font-bold mt-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[8px]"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Password</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group {{ $errors->has('password') ? 'input-error' : '' }}">
                            <input type="password" name="password" class="w-full py-3 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-[10px] text-[#ef4565] font-bold mt-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[8px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-[#5f6c7b] ml-1">Confirm</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group {{ $errors->has('password_confirmation') ? 'input-error' : '' }}">
                            <input type="password" name="password_confirmation" class="w-full py-3 bg-transparent text-sm font-semibold text-[#094067] outline-none placeholder:text-[#90b4ce]"
                                placeholder="••••••••">
                        </div>
                        @error('password_confirmation')
                            <p class="text-[10px] text-[#ef4565] font-bold mt-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle text-[8px]"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="px-1 py-2">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="relative flex items-center mt-0.5">
                            <input type="checkbox" name="terms" id="terms" class="peer hidden">
                            <div class="w-5 h-5 rounded-md border-2 border-[#90b4ce]/30 peer-checked:bg-[#3da9fc] peer-checked:border-[#3da9fc] transition-all flex items-center justify-center">
                                <i class="fas fa-check text-[10px] text-[#fffffe] opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <span class="text-[11px] leading-relaxed font-bold text-[#5f6c7b] group-hover:text-[#094067] transition-colors">
                            Saya menyetujui <a href="#" class="text-[#3da9fc] underline">Syarat Ketentuan</a> dan <a href="#" class="text-[#3da9fc] underline">Kebijakan Privasi</a>.
                        </span>
                    </label>
                    @error('terms')
                        <p class="text-[10px] text-[#ef4565] font-bold mt-2 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle text-[8px]"></i> Anda harus menyetujui syarat dan ketentuan.
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full group relative bg-[#3da9fc] text-[#fffffe] font-black uppercase tracking-widest text-[11px] py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-[0_20px_40px_-10px_rgba(61,169,252,0.4)] hover:-translate-y-1">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Daftar Sekarang <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-[#90b4ce]/20 text-center space-y-4">
                <p class="text-[11px] font-bold text-[#90b4ce] uppercase tracking-widest">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-[#3da9fc] hover:text-[#094067] transition-colors ml-1">Login Disini</a>
                </p>
                <a href="/" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-[#90b4ce] hover:text-[#094067] transition-all">
                    <i class="fas fa-chevron-left text-[8px]"></i> Kembali Ke Beranda
                </a>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-6 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <i class="fas fa-shield-halved text-[#90b4ce]"></i>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-[#5f6c7b]">Enterprise Security</span>
            </div>
            <div class="w-[1px] h-3 bg-[#90b4ce]/30"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-user-shield text-[#90b4ce]"></i>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-[#5f6c7b]">Privacy First</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />
</body>

</html>
