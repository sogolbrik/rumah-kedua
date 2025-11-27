<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - @yield('title', 'Temukan Kenyamanan Seperti di Rumah Sendiri')</title>

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
            --color-accent: #0891b2;
        }

        body {
            scroll-behavior: smooth;
        }

        .transition-bg {
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    @include('components.navbar-frontend')

    @yield('frontend-main')

    <!-- 9. FOOTER -->
    <footer class="bg-gray-900 text-gray-300 py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <!-- About -->
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-home text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-bold text-white">RumahKedua</span>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Temukan kenyamanan seperti di rumah sendiri dengan layanan terbaik dan fasilitas lengkap.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Link Cepat</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li><a href="{{ url('/#fasilitas') }}" class="hover:text-blue-400 transition-colors">Fasilitas</a></li>
                        <li><a href="{{ url('/#kamar') }}" class="hover:text-blue-400 transition-colors">Pilihan Kamar</a></li>
                        <li><a href="{{ url('/#lokasi') }}" class="hover:text-blue-400 transition-colors">Lokasi</a></li>
                        <li><a href="{{ url('/#faq') }}" class="hover:text-blue-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex gap-2"><i class="fas fa-phone w-4"></i> +62 878 7032 7957</li>
                        <li class="flex gap-2"><i class="fas fa-envelope w-4"></i> rumahkedua@gmail.com</li>
                        <li class="flex gap-2"><i class="fas fa-map-marker-alt w-4"></i> Mojokerto Selatan</li>
                    </ul>
                </div>

                <!-- Sosial Media -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Ikuti Kami</h4>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-whatsapp text-white"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-blue-500 rounded-full flex items-center justify-center transition-colors">
                            <i class="fab fa-youtube text-white"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="border-t border-gray-800 pt-8 text-center text-gray-400">
                <p>&copy; 2025 RumahKedua. Semua hak cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="{{ asset('assets/vendor/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/sweetalert/sweetalert.min.js') }}"></script>

    {{-- Success --}}
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
