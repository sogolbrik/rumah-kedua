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

<body class="bg-[#f1f5f9] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">

    <div class="absolute top-[-5%] right-[-5%] w-[35%] h-[35%] bg-blue-200/40 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-[-5%] left-[-5%] w-[35%] h-[35%] bg-indigo-200/30 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="w-full max-w-[520px] relative z-10 animate-up">

        <div class="layered-surface rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">

            <div class="text-center mb-8">
                <div class="inline-flex relative mb-4">
                    <div class="absolute inset-0 bg-blue-600 rounded-[1rem] rotate-6 opacity-20"></div>
                    <div class="bg-slate-900 text-white w-12 h-12 rounded-[1rem] flex items-center justify-center relative z-10 shadow-lg">
                        <i class="fas fa-user-plus text-lg"></i>
                    </div>
                </div>
                <h1 class="text-xl font-black tracking-tight text-slate-900 uppercase">
                    Join <span class="text-blue-600">RumahKedua</span>
                </h1>
                <p class="text-[10px] font-bold uppercase tracking-[0.3em] text-slate-400 mt-2">Create Your Member Account</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Full Name</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group">
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full py-3 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400" placeholder="Jhon Doe" required>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Phone Number</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group">
                            <input type="tel" name="telepon" value="{{ old('telepon') }}"
                                class="w-full py-3 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400" placeholder="6281..." required>
                        </div>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Email Address</label>
                    <div class="input-inset flex items-center px-4 rounded-xl group">
                        <input type="email" name="email" value="{{ old('email') }}" class="w-full py-3 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400"
                            placeholder="name@example.com" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Password</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group">
                            <input type="password" name="password" class="w-full py-3 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400"
                                placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 ml-1">Confirm</label>
                        <div class="input-inset flex items-center px-4 rounded-xl group">
                            <input type="password" name="password_confirmation" class="w-full py-3 bg-transparent text-sm font-semibold text-slate-700 outline-none placeholder:text-slate-400"
                                placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-100 rounded-xl p-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-[10px] font-bold text-red-500 flex items-center gap-2">
                                <i class="fas fa-circle-exclamation"></i> {{ $error }}
                            </p>
                        @endforeach
                    </div>
                @endif

                <div class="px-1 py-2">
                    <label class="flex items-start gap-3 cursor-pointer group">
                        <div class="relative flex items-center mt-0.5">
                            <input type="checkbox" name="terms" id="terms" class="peer hidden" required>
                            <div class="w-5 h-5 rounded-md border-2 border-slate-200 peer-checked:bg-blue-600 peer-checked:border-blue-600 transition-all flex items-center justify-center">
                                <i class="fas fa-check text-[10px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <span class="text-[11px] leading-relaxed font-bold text-slate-500 group-hover:text-slate-700 transition-colors">
                            Saya menyetujui <a href="#" class="text-blue-600 underline">Syarat Ketentuan</a> dan <a href="#" class="text-blue-600 underline">Kebijakan Privasi</a>.
                        </span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full group relative bg-slate-900 text-white font-black uppercase tracking-widest text-[11px] py-4 rounded-2xl overflow-hidden transition-all duration-300 hover:bg-blue-600 hover:shadow-[0_20px_40px_-10px_rgba(37,99,235,0.4)] hover:-translate-y-1">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Daftar Sekarang <i class="fas fa-paper-plane text-[10px] group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    </span>
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-200/60 text-center space-y-4">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-slate-900 transition-colors ml-1">Login Disini</a>
                </p>

                <a href="/" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-slate-900 transition-all">
                    <i class="fas fa-chevron-left"></i> Kembali Ke Beranda
                </a>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-center gap-6 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
            <div class="flex items-center gap-2">
                <i class="fas fa-shield-halved text-slate-500"></i>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500">Enterprise Security</span>
            </div>
            <div class="w-[1px] h-3 bg-slate-300"></div>
            <div class="flex items-center gap-2">
                <i class="fas fa-user-shield text-slate-500"></i>
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-500">Privacy First</span>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />
</body>

</html>
