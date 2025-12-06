<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: false }" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title')</title>

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
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-slate-200 h-16">
                <div class="flex items-center gap-3 px-4 py-3">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 lg:hidden"
                        @click="sidebarOpen = true" aria-label="Buka navigasi">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <div class="flex-1 flex items-center gap-3">
                        <h1 class="text-lg md:text-xl font-semibold text-slate-900 text-balance">@yield('title', 'Admin Panel')</h1>
                        <div class="ml-auto flex items-center gap-3">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="relative p-2 rounded-md hover:bg-slate-100 text-slate-600" aria-label="Notifikasi">
                                    <i class="fa-regular fa-bell text-lg"></i>
                                    @if ($penghuniCount > 0)
                                        <span class="absolute -top-1 -right-1 h-2.5 w-2.5 rounded-full bg-blue-600"></span>
                                    @endif
                                </button>
                                <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-3 w-72 bg-white rounded-xl shadow-2xl border border-slate-200/80 py-3 z-30">
                                    <div class="px-5 py-2 text-base font-semibold text-slate-800 tracking-tight">Notifikasi</div>
                                    @if ($penghuni ?? 0)
                                        <div class="px-5 py-2.5 text-sm text-slate-700">
                                            <span class="font-bold text-blue-600">{{ $penghuniCount }}</span> penghuni menunggak
                                        </div>
                                        <a href="{{ url('laporan/#penghuniMenunggak') }}" class="flex items-center justify-between px-5 py-2.5 text-sm text-blue-600 rounded-lg mx-2 transition">
                                            <span class="font-medium">Ayo lihat <i class="fa-solid fa-arrow-right text-xs ml-2"></i></span>
                                        </a>
                                    @else
                                        <div class="px-5 py-2.5 text-sm text-slate-500">Tidak ada notifikasi</div>
                                    @endif
                                </div>
                            </div>

                            {{-- Dropdown menu pengguna --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2 rounded-lg p-1.5 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                                    aria-label="Menu pengguna">
                                    @if (auth()->check() && auth()->user()->avatar)
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="h-9 w-9 rounded-full object-cover ring-1 ring-blue-200">
                                    @else
                                        <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center ring-1 ring-blue-200">
                                            <i class="fa-solid fa-user text-blue-600"></i>
                                        </div>
                                    @endif
                                    <i class="fa-solid fa-chevron-down text-xs text-slate-500"></i>
                                </button>

                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-2" @click.outside="open = false" x-cloak
                                    class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-200/80 py-2 z-30">
                                    <div class="px-4 py-2">
                                        <p class="text-sm font-semibold text-slate-800 tracking-tight">
                                            {{ auth()->user()->name ?? 'Admin Kos' }}
                                        </p>
                                        <p class="text-xs text-slate-500 capitalize">
                                            {{ auth()->user()->role ?? 'admin' }}
                                        </p>
                                    </div>
                                    <div class="border-t border-slate-200 my-2"></div>
                                    <a href="{{ route('profil-admin.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-lg mx-2 transition">
                                        <i class="fa-solid fa-user text-slate-500"></i>
                                        <span>Profil</span>
                                    </a>
                                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 rounded-lg mx-2 transition">
                                        <i class="fa-solid fa-gear text-slate-500"></i>
                                        <span>Pengaturan</span>
                                    </a>
                                    <div class="border-t border-slate-200 my-2"></div>
                                    <form method="POST" action="{{ route('logout') }}" class="mx-2">
                                        @csrf
                                        <button type="submit" class="flex items-center gap-3 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 rounded-lg transition">
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                            <span>Keluar</span>
                                        </button>
                                    </form>
                                </div>
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

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                position: "top-end",
                toast: true,
                timer: 3000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif

    {{-- Error --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                timer: 3000,
                position: "top-end",
                toast: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif

    {{-- Info --}}
    @if (session('info'))
        <script>
            Swal.fire({
                icon: 'info',
                title: '{{ session('info') }}',
                position: "top-end",
                toast: true,
                timer: 4000,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-xl'
                }
            });
        </script>
    @endif
</body>

</html>
