<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RumahKedua - Temukan Kenyamanan Seperti di Rumah Sendiri</title>

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

    <!-- 1. NAVBAR (Sticky, Transparent → Solid on Scroll) -->
    <nav x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = window.scrollY > 50" :class="scrolled ? 'bg-white shadow-md' : 'bg-transparent'" class="fixed w-full top-0 z-50 transition-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">RumahKedua</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="#fasilitas" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Fasilitas</a>
                    <a href="#kamar" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Kamar</a>
                    <a href="#lokasi" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Lokasi</a>
                    <a href="#harga" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Harga</a>
                    <a href="#kontak" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Kontak</a>
                </div>

                <!-- CTA Button Desktop -->
                <button class="hidden md:inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors" onclick="location.href='https://wa.me/62812345678'">
                    Booking Sekarang
                </button>

                <!-- Mobile Menu Button -->
                <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileOpen" class="md:hidden pb-4 space-y-2 border-t border-gray-100">
                <a href="#fasilitas" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition-colors">Fasilitas</a>
                <a href="#kamar" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition-colors">Kamar</a>
                <a href="#lokasi" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition-colors">Lokasi</a>
                <a href="#harga" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition-colors">Harga</a>
                <a href="#kontak" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded transition-colors">Kontak</a>
                <button class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors mt-2" onclick="location.href='https://wa.me/62812345678'">
                    Booking Sekarang
                </button>
            </div>
        </div>
    </nav>

    <!-- 2. HERO SECTION -->
    <header class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="space-y-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Temukan Kenyamanan Seperti di Rumah Sendiri
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        RumahKedua menawarkan akomodasi modern dengan fasilitas lengkap, lokasi strategis, dan layanan
                        terbaik untuk kenyamanan menginap Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <button class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors" onclick="location.href='https://wa.me/62812345678'">
                            Booking via WhatsApp
                        </button>
                        <button class="border-2 border-blue-500 text-blue-500 hover:bg-blue-50 px-8 py-3 rounded-lg font-semibold transition-colors">
                            Lihat Galeri
                        </button>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative h-80 md:h-96 bg-gray-200 rounded-2xl overflow-hidden shadow-lg">
                    <img src="/placeholder.svg?height=400&width=500" alt="Kamar RumahKedua" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </header>

    <!-- 3. ABOUT / WHY CHOOSE US -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Memilih RumahKedua?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kami berkomitmen memberikan pengalaman menginap terbaik dengan standar kualitas tinggi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aman & Terpercaya</h3>
                    <p class="text-gray-600">CCTV 24 jam dan keamanan berlapis untuk kenyamanan Anda</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-map-marker-alt text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600">Dekat dengan kampus, mall, dan pusat bisnis</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-sparkles text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Bersih & Terawat</h3>
                    <p class="text-gray-600">Perawatan rutin dan kebersihan terjamin setiap hari</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-wifi text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Internet Cepat</h3>
                    <p class="text-gray-600">WiFi 100 Mbps tersedia di seluruh area kos</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. FASILITAS SECTION -->
    <section id="fasilitas" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fasilitas Lengkap
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Nikmati berbagai fasilitas modern untuk kenyamanan maksimal Anda
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- Fasilitas Item 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-fan text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">AC</p>
                </div>

                <!-- Fasilitas Item 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-wifi text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">WiFi 100 Mbps</p>
                </div>

                <!-- Fasilitas Item 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-utensils text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Dapur Bersama</p>
                </div>

                <!-- Fasilitas Item 4 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-car text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Parkir</p>
                </div>

                <!-- Fasilitas Item 5 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-camera text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">CCTV 24 Jam</p>
                </div>

                <!-- Fasilitas Item 6 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow text-center">
                    <i class="fas fa-washing-machine text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Laundry</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. KAMAR SECTION (ROOM SHOWCASE) -->
    <section id="kamar" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pilihan Kamar
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Berbagai tipe kamar tersedia sesuai dengan kebutuhan dan budget Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Room Card 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-gray-300 overflow-hidden">
                        <img src="/placeholder.svg?height=300&width=400" alt="Kamar Single" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar Single</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar nyaman untuk 1 orang dengan fasilitas lengkap</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>Kasur & Lemari</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 500K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Room Card 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow border-2 border-blue-500">
                    <div class="bg-blue-500 text-white text-center py-2 text-sm font-semibold">PALING POPULER</div>
                    <div class="h-48 bg-gray-300 overflow-hidden">
                        <img src="/placeholder.svg?height=300&width=400" alt="Kamar Double" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar Double</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar nyaman untuk 2 orang dengan tempat tidur double</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>Kasur Double & Lemari</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 700K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Room Card 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                    <div class="h-48 bg-gray-300 overflow-hidden">
                        <img src="/placeholder.svg?height=300&width=400" alt="Suite Deluxe" class="w-full h-full object-cover">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Suite Deluxe</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar premium untuk 2 orang dengan ruang kerja</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p><i class="fas fa-check text-blue-500 mr-2"></i>Area Kerja & Balkon</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 900K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. TESTIMONI SECTION -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Testimoni Penghuni
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dengarkan pengalaman nyata dari penghuni RumahKedua
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-semibold text-gray-900">Siti Nur Azizah</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Teknik</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "RumahKedua adalah pilihan terbaik! Kamarnya bersih, WiFi super cepat, dan tempatnya sangat strategis. Sangat recommended untuk yang cari kos berkualitas!"
                    </p>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                            <p class="text-sm text-gray-600">Pekerja Kantoran</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "Pelayanan yang luar biasa! Pemilik kos sangat responsif dan membantu. Fasilitas lengkap dan harganya sangat terjangkau untuk kualitas yang diberikan."
                    </p>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full">
                        <div>
                            <h4 class="font-semibold text-gray-900">Rina Wijaya</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Bisnis</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "Suasana yang nyaman dan aman. Pemilik kos sangat peduli terhadap kenyamanan penghuni. Saya merasa seperti di rumah sendiri!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. LOKASI SECTION -->
    <section id="lokasi" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Lokasi Info -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Lokasi Strategis
                    </h2>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Terletak di jantung kota dengan akses mudah ke berbagai tempat penting. Dekat dengan kampus, mall, rumah sakit, dan pusat bisnis.
                    </p>

                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-map-marker-alt text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Alamat</h4>
                                <p class="text-gray-600">Jl. Merdeka No. 123, Jakarta Selatan, 12345</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-phone text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                                <p class="text-gray-600">+62 812 3456 7890</p>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-clock text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 20:00<br>Sabtu - Minggu: 09:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <button class="mt-8 bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Lihat di Google Maps
                    </button>
                </div>

                <!-- Map Embed -->
                <div class="w-full h-96 bg-gray-300 rounded-xl overflow-hidden shadow-lg">
                    <iframe width="100%" height="100%" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521573490504!2d106.8193!3d-6.2297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f18fadc0a507%3A0x15a1f3e95d4a7a5a!2sJl%20Merdeka%2C%20Jakarta%2012345!5e0!3m2!1sen!2sid!4v1234567890">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CALL TO ACTION SECTION -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-blue-500">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                Siap Merasakan Kenyamanan?
            </h2>
            <p class="text-lg text-blue-100 mb-10 leading-relaxed">
                Jangan lewatkan kesempatan untuk menginap di tempat yang nyaman dan terpercaya. Hubungi kami sekarang untuk informasi lebih lanjut atau booking langsung.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-white hover:bg-gray-100 text-blue-500 px-8 py-4 rounded-lg font-semibold transition-colors" onclick="location.href='https://wa.me/62812345678'">
                    <i class="fab fa-whatsapp mr-2"></i>Booking via WhatsApp
                </button>
                <button class="border-2 border-white hover:bg-white/10 text-white px-8 py-4 rounded-lg font-semibold transition-colors">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Email
                </button>
            </div>
        </div>
    </section>

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
                        <li><a href="#fasilitas" class="hover:text-blue-400 transition-colors">Fasilitas</a></li>
                        <li><a href="#kamar" class="hover:text-blue-400 transition-colors">Pilihan Kamar</a></li>
                        <li><a href="#lokasi" class="hover:text-blue-400 transition-colors">Lokasi</a></li>
                        <li><a href="#" class="hover:text-blue-400 transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex gap-2"><i class="fas fa-phone w-4"></i> +62 812 3456 7890</li>
                        <li class="flex gap-2"><i class="fas fa-envelope w-4"></i> info@rumahkedua.com</li>
                        <li class="flex gap-2"><i class="fas fa-map-marker-alt w-4"></i> Jakarta Selatan</li>
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
</body>

</html>
