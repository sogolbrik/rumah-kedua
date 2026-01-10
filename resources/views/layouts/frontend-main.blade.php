<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title', 'Temukan Kenyamanan Seperti di Rumah Sendiri')</title>

    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('assets/image/favicon/logo.svg') }}" type="image/svg+xml">

    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/sweetalert/sweetalert.min.css') }}">

    {{-- Vite (Tailwind v4 + Alpine dari app.js) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-primary: #3b82f6;
            --color-primary-dark: #1e40af;
            --color-neutral-light: #f9fafb;
            --color-neutral-dark: #1f2937;
            --color-neutral-50: #f9fafb;
            --color-accent: #0891b2;
        }

        body {
            scroll-behavior: smooth;
            background-color: var(--color-neutral-50);
        }

        .transition-bg {
            transition: background-color 0.3s ease;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-white text-gray-900">
    <x-alert-loader :success="session('success') ?? ''" :error="session('error') ?? ''" :info="session('info') ?? ''" />

    @include('components.navbar-frontend')

    @yield('frontend-main')

    <!-- 9. FOOTER -->
    {{-- FOOTER: High-End Corporate Style --}}
    <footer class="relative bg-slate-950 pt-24 pb-12 overflow-hidden">
        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>

        <div class="absolute bottom-0 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-16 mb-20">

                <div class="md:col-span-4 space-y-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-900/20">
                            <i class="fas fa-home text-white text-lg"></i>
                        </div>
                        <span class="text-2xl font-black text-white tracking-tighter italic">Rumah<span class="text-blue-500">Kedua</span></span>
                    </div>
                    <p class="text-slate-400 leading-relaxed text-lg max-w-sm">
                        {{ $pengaturan->deskripsi_kos ?? 'Merevolusi cara Anda tinggal dengan menggabungkan estetika modern dan kenyamanan total dalam satu hunian eksklusif.' }}
                    </p>
                    <div class="flex gap-4">
                        @foreach ([['icon' => 'fa-instagram', 'link' => '#'], ['icon' => 'fa-facebook-f', 'link' => '#'], ['icon' => 'fa-whatsapp', 'link' => '#'], ['icon' => 'fa-linkedin-in', 'link' => '#']] as $social)
                            <a href="{{ $social['link'] }}"
                                class="w-11 h-11 bg-slate-900 border border-slate-800 rounded-xl flex items-center justify-center text-slate-400 hover:text-white hover:border-blue-500 hover:bg-blue-600/10 transition-all group">
                                <i class="fab {{ $social['icon'] }} group-hover:scale-110 transition-transform"></i>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Eksplorasi</h4>
                    <ul class="space-y-4">
                        @foreach ([
                            'Fasilitas'     => '#fasilitas',
                            'Pilihan Kamar' => '#kamar',
                            'Lokasi'        => '#lokasi',
                            'FAQ'           => '#faq',
                        ] as $title => $url)
                            <li>
                                <a href="{{ url($url) }}" class="group flex items-center text-slate-400 hover:text-cyan-400 transition-colors">
                                    <span class="h-px w-0 bg-cyan-400 mr-0 group-hover:w-4 group-hover:mr-3 transition-all duration-300"></span>
                                    {{ $title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="md:col-span-2">
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Informasi</h4>
                    <ul class="space-y-4 text-slate-400">
                        <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Karir</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4 space-y-8">
                    <h4 class="text-white font-bold mb-8 uppercase tracking-widest text-xs">Kantor Pemasaran</h4>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-2xl flex-shrink-0 flex items-center justify-center text-blue-500">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="text-slate-400">
                                <p class="text-white font-semibold mb-1">Alamat</p>
                                <p class="text-sm leading-relaxed">{{ $pengaturan->alamat_kos ?? 'Jl. Raya Elit No. 123, Mojokerto Selatan, Jawa Timur' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-slate-900 border border-slate-800 rounded-2xl flex-shrink-0 flex items-center justify-center text-emerald-500">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="text-slate-400">
                                <p class="text-white font-semibold mb-1">Hubungi Kami</p>
                                <p class="text-sm">+{{ $pengaturan->no_telepon ?? '6287870327957' }}</p>
                                <p class="text-sm">{{ $pengaturan->email_kos ?? 'official@rumahkedua.id' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-12 border-t border-slate-900 flex flex-col md:flex-row justify-between items-center gap-6">
                <p class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} <span class="text-slate-300 font-bold tracking-tight">RumahKedua</span>. Built for Modern Living.
                </p>
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-slate-500 text-xs font-mono uppercase tracking-widest">System Operational</span>
                    </div>
                    <p class="text-slate-600 text-xs italic">Crafted by GlgDev as Sogolbrik</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>
</body>

</html>
