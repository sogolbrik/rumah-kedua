<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/image/favicon/logo.svg') }}" type="image/svg+xml">

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">

    {{-- Vite (Tailwind v4 + Alpine dari app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Style Global --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-900">
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />

    {{-- Mobile overlay --}}
    <div x-cloak x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" @click="sidebarOpen = false" aria-hidden="true"></div>

    <div class="min-h-screen lg:flex">
        {{-- Sidebar --}}
        <div class="lg:flex-shrink-0 lg:sticky lg:top-0 lg:self-start lg:h-screen">
            @include('components.admin-sidebar')
        </div>

        {{-- Kolom utama --}}
        <div class="flex-1 flex flex-col lg:min-w-0">
            {{-- Top bar --}}
            <header class="sticky top-0 z-30 bg-white/70 backdrop-blur-xl border-b border-slate-200/50 h-20 transition-all">
                <div class="flex items-center justify-between h-full px-4 md:px-8">

                    <div class="flex items-center gap-4">
                        <button type="button"
                            class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-600 hover:text-blue-600 hover:border-blue-200 hover:shadow-sm lg:hidden transition-all active:scale-95"
                            @click="sidebarOpen = true" aria-label="Buka navigasi">
                            <i class="fa-solid fa-bars-staggered text-lg"></i>
                        </button>

                        <div class="hidden sm:block">
                            <h1 class="text-xl font-black text-slate-900 tracking-tight">
                                @yield('title', 'Admin Panel')
                            </h1>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 md:gap-4">

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="relative flex h-11 w-11 items-center justify-center rounded-2xl bg-white border border-slate-200 text-slate-500 transition-all hover:bg-slate-50 hover:text-blue-600 hover:border-blue-100 group"
                                aria-label="Notifikasi">
                                <i class="fa-regular fa-bell text-lg group-hover:rotate-12 transition-transform"></i>

                                @if ($penghuniCount > 0)
                                    <span class="absolute top-2.5 right-2.5 flex h-2.5 w-2.5">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-600 border-2 border-white"></span>
                                    </span>
                                @endif
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" x-cloak
                                class="absolute right-0 mt-4 w-80 overflow-hidden rounded-[2rem] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-200/60 z-50">

                                <div class="bg-slate-50/50 px-6 py-5 border-b border-slate-100">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-xs font-black text-slate-900 uppercase tracking-widest">Notifikasi</h3>
                                        <span class="bg-blue-600 text-[9px] font-black text-white px-2 py-0.5 rounded-full uppercase italic">Terbaru</span>
                                    </div>
                                </div>

                                <div class="max-h-[350px] overflow-y-auto p-2">
                                    @if ($penghuniCount > 0)
                                        <a href="{{ url('laporan/#penghuniMenunggak') }}" class="group flex items-start gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-all">
                                            <div class="h-10 w-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                                                <i class="fa-solid fa-receipt text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">Pembayaran Menunggak</p>
                                                <p class="text-xs text-slate-500 mt-1">{{ $penghuniCount }} orang belum membayar.</p>
                                            </div>
                                        </a>
                                    @else
                                        <div class="py-10 text-center">
                                            <i class="fa-solid fa-circle-check text-slate-200 text-3xl mb-3"></i>
                                            <p class="text-xs font-bold text-slate-400 italic">Belum ada kabar baru</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="h-8 w-px bg-slate-200 mx-1 hidden sm:block"></div>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                class="flex items-center gap-3 pl-1 pr-3 py-1 rounded-2xl bg-white border border-slate-200 hover:border-blue-200 hover:shadow-sm transition-all group">
                                <div class="relative">
                                    @if (auth()->check() && auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="h-9 w-9 rounded-xl object-cover ring-2 ring-slate-50">
                                    @else
                                        <div
                                            class="h-9 w-9 rounded-xl bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center text-slate-500 group-hover:from-blue-600 group-hover:to-indigo-600 group-hover:text-white transition-all">
                                            <i class="fa-solid fa-user text-xs"></i>
                                        </div>
                                    @endif
                                    <span class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 bg-emerald-500 border-2 border-white rounded-full"></span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <p class="text-xs font-black text-slate-900 leading-none truncate w-24">
                                        {{ auth()->user()->name ?? 'Admin' }}
                                    </p>
                                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter mt-1">
                                        {{ auth()->user()->role ?? 'Superadmin' }}
                                    </p>
                                </div>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-300 group-hover:text-blue-500 transition-colors"></i>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4" x-cloak
                                class="absolute right-0 mt-4 w-56 overflow-hidden rounded-[1.5rem] bg-white shadow-[0_20px_50px_rgba(0,0,0,0.15)] border border-slate-200/60 z-50 p-2">

                                <a href="{{ route('profil-admin.index') }}"
                                    class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    <i class="fa-solid fa-id-badge text-slate-400 group-hover:text-blue-500"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('pengaturan-admin.index') }}"
                                    class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold text-slate-600 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    <i class="fa-solid fa-gears text-slate-400 group-hover:text-blue-500"></i>
                                    Pengaturan
                                </a>

                                <div class="my-2 border-t border-slate-100"></div>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-sm font-bold text-red-500 hover:bg-red-50 transition-all">
                                        <i class="fa-solid fa-power-off"></i>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 p-4 md:p-6">
                @yield('admin-main')
            </main>

            <footer class="border-t border-slate-200 bg-white">
                <div class="px-4 py-4 text-sm text-slate-500">
                    ©2025 RumahKedua. All rights reserved.
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
