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
            <header class="sticky top-0 z-20 bg-white/80 backdrop-blur border-b border-slate-200">
                <div class="flex items-center gap-3 px-4 py-3">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500 lg:hidden"
                        @click="sidebarOpen = true" aria-label="Buka navigasi">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <div class="flex-1 flex items-center gap-3">
                        <h1 class="text-lg md:text-xl font-semibold text-slate-900 text-balance">@yield('title', 'Admin Panel')</h1>
                        <div class="relative hidden md:block w-full max-w-md ml-auto">
                            <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="search" placeholder="Cari apa saja..."
                                class="w-full rounded-lg border border-slate-200 pl-9 pr-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white" aria-label="Pencarian" />
                        </div>
                        <div class="ml-auto md:ml-0 flex items-center gap-3">
                            <button class="relative p-2 rounded-md hover:bg-slate-100 text-slate-600" aria-label="Notifikasi">
                                <i class="fa-regular fa-bell text-lg"></i>
                                <span class="absolute -top-1 -right-1 h-2.5 w-2.5 rounded-full bg-blue-600"></span>
                            </button>
                            <div class="h-9 w-9 rounded-full bg-blue-100 flex items-center justify-center ring-1 ring-blue-200">
                                <i class="fa-solid fa-user text-blue-600"></i>
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
</body>

</html>
