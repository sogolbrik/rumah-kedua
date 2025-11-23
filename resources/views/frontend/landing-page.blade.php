@extends('layouts.frontend-main')

@section('title', 'Temukan Kenyamanan Seperti di Rumah Sendiri')
@section('frontend-main')
    <!-- 2. HERO SECTION -->
    <header class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 to-white">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="space-y-6 animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                        Temukan Kenyamanan Seperti di Rumah Sendiri
                    </h1>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        RumahKedua menawarkan akomodasi modern dengan fasilitas lengkap, lokasi strategis, dan layanan
                        terbaik untuk kenyamanan menginap Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ Route('booking') }}">
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 hover:shadow-lg">
                                Booking
                            </button>
                        </a>
                        <a href="{{ Route('galeri-kamar') }}">
                            <button class="border-2 border-blue-500 text-blue-500 hover:bg-blue-50 px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                                Lihat Galeri
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative h-80 md:h-96 bg-gray-200 rounded-2xl overflow-hidden shadow-lg animate-fade-in-right transform transition-transform duration-300">
                    <img src="{{ asset('assets/image/landing-page/undraw_login_weas.svg') }}" alt="Kamar RumahKedua" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </header>

    <!-- 3. ABOUT / WHY CHOOSE US -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Mengapa Memilih RumahKedua?
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Kami berkomitmen memberikan pengalaman menginap terbaik dengan standar kualitas tinggi
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Feature 1 -->
                <div class="text-center animate-slide-up transform transition-all duration-300 p-4 rounded-xl" style="animation-delay: 0.1s">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 transform hover:rotate-12 transition-transform">
                        <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aman & Terpercaya</h3>
                    <p class="text-gray-600">CCTV 24 jam dan keamanan berlapis untuk kenyamanan Anda</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center animate-slide-up transform transition-all duration-300 p-4 rounded-xl" style="animation-delay: 0.2s">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 transform hover:rotate-12 transition-transform">
                        <i class="fas fa-map-marker-alt text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Lokasi Strategis</h3>
                    <p class="text-gray-600">Dekat dengan kampus, mall, dan pusat bisnis</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center animate-slide-up transform transition-all duration-300 p-4 rounded-xl" style="animation-delay: 0.3s">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 transform hover:rotate-12 transition-transform">
                        <i class="fas fa-broom text-blue-500 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Bersih & Terawat</h3>
                    <p class="text-gray-600">Perawatan rutin dan kebersihan terjamin setiap hari</p>
                </div>

                <!-- Feature 4 -->
                <div class="text-center animate-slide-up transform transition-all duration-300 p-4 rounded-xl" style="animation-delay: 0.4s">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 transform hover:rotate-12 transition-transform">
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
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fasilitas Lengkap
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Nikmati berbagai fasilitas modern untuk kenyamanan maksimal Anda
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <!-- Fasilitas Item 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.1s">
                    <i class="fas fa-bath text-blue-500 text-3xl mb-3 transform hover:rotate-180 transition-transform duration-500"></i>
                    <p class="font-semibold text-gray-900 text-sm">K. Mandi Dalam</p>
                </div>

                <!-- Fasilitas Item 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.2s">
                    <i class="fas fa-wifi text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">WiFi 100 Mbps</p>
                </div>

                <!-- Fasilitas Item 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.3s">
                    <i class="fas fa-utensils text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Dapur Bersama</p>
                </div>

                <!-- Fasilitas Item 4 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.4s">
                    <i class="fas fa-car text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Parkir</p>
                </div>

                <!-- Fasilitas Item 5 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.5s">
                    <i class="fas fa-camera text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">CCTV 24 Jam</p>
                </div>

                <!-- Fasilitas Item 6 -->
                <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-lg transition-all transform hover:scale-100 hover:-translate-y-2 text-center animate-slide-up" style="animation-delay: 0.6s">
                    <i class="fas fa-tshirt text-blue-500 text-3xl mb-3"></i>
                    <p class="font-semibold text-gray-900 text-sm">Laundry</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. KAMAR SECTION (ROOM SHOWCASE) -->
    <section id="kamar" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pilihan Kamar
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Berbagai tipe kamar tersedia sesuai dengan kebutuhan dan budget Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Room Card 1 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.1s">
                    <div class="h-48 bg-gray-300 overflow-hidden group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Kamar Single" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar Single</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar nyaman untuk 1 orang dengan fasilitas lengkap</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>Kasur & Lemari</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 500K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-110 text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Room Card 2 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 border-2 border-blue-500 animate-slide-up"
                    style="animation-delay: 0.2s">
                    <div class="bg-blue-500 text-white text-center py-2 text-sm font-semibold animate-pulse">PALING POPULER</div>
                    <div class="h-48 bg-gray-300 overflow-hidden group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Kamar Double" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Kamar Double</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar nyaman untuk 2 orang dengan tempat tidur double</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>Kasur Double & Lemari</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 700K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-110 text-sm">
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Room Card 3 -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.3s">
                    <div class="h-48 bg-gray-300 overflow-hidden group">
                        <img src="/placeholder.svg?height=300&width=400" alt="Suite Deluxe" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                    </div>
                    <div class="p-6">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">Suite Deluxe</h3>
                        <p class="text-gray-600 text-sm mb-4">Kamar premium untuk 2 orang dengan ruang kerja</p>
                        <div class="space-y-2 mb-6 text-sm text-gray-700">
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>AC & Kamar Mandi Dalam</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>WiFi 100 Mbps</p>
                            <p class="transform hover:translate-x-2 transition-transform"><i class="fas fa-check text-blue-500 mr-2"></i>Area Kerja & Balkon</p>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-2xl font-bold text-blue-500">Rp 900K/bln</span>
                            <button class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-all transform hover:scale-110 text-sm">
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
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Testimoni Penghuni
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Dengarkan pengalaman nyata dari penghuni RumahKedua
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Testimoni 1 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.1s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full transform hover:scale-110 transition-transform">
                        <div>
                            <h4 class="font-semibold text-gray-900">Siti Nur Azizah</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Teknik</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "RumahKedua adalah pilihan terbaik! Kamarnya bersih, WiFi super cepat, dan tempatnya sangat strategis. Sangat recommended untuk yang cari kos berkualitas!"
                    </p>
                </div>

                <!-- Testimoni 2 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full transform hover:scale-110 transition-transform">
                        <div>
                            <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                            <p class="text-sm text-gray-600">Pekerja Kantoran</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "Pelayanan yang luar biasa! Pemilik kos sangat responsif dan membantu. Fasilitas lengkap dan harganya sangat terjangkau untuk kualitas yang diberikan."
                    </p>
                </div>

                <!-- Testimoni 3 -->
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform hover:scale-100 hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="/placeholder.svg?height=50&width=50" alt="Avatar" class="w-12 h-12 rounded-full transform hover:scale-110 transition-transform">
                        <div>
                            <h4 class="font-semibold text-gray-900">Rina Wijaya</h4>
                            <p class="text-sm text-gray-600">Mahasiswa Bisnis</p>
                        </div>
                    </div>
                    <div class="flex gap-1 mb-4">
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                        <i class="fas fa-star text-yellow-400 hover:scale-125 transition-transform"></i>
                    </div>
                    <p class="text-gray-600 leading-relaxed">
                        "Suasana yang nyaman dan aman. Pemilik kos sangat peduli terhadap kenyamanan penghuni. Saya merasa seperti di rumah sendiri!"
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Temukan jawaban untuk pertanyaan umum tentang RumahKedua
                </p>
            </div>

            <!-- Section FAQ -->
            <div class="space-y-4">
                <!-- FAQ Item 1 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up" style="animation-delay: 0.1s">
                    <button class="faq-button w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-900 text-lg">Apakah tersedia tempat parkir?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="p-6 pt-0 text-gray-600">
                            Ya, kami menyediakan area parkir yang luas dan aman untuk motor dan mobil. Parkir tersedia 24 jam dengan sistem keamanan CCTV.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up" style="animation-delay: 0.2s">
                    <button class="faq-button w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-900 text-lg">Apakah ada minimum kontrak sewa?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="p-6 pt-0 text-gray-600">
                            Minimum kontrak sewa adalah 3 bulan. Kami juga menawarkan paket sewa 6 bulan dan 12 bulan dengan harga lebih hemat.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up" style="animation-delay: 0.3s">
                    <button class="faq-button w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-900 text-lg">Apakah boleh menerima tamu?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="p-6 pt-0 text-gray-600">
                            Tamu diperbolehkan berkunjung pada jam 08:00 - 21:00 dengan melapor ke resepsionis. Untuk keamanan, tamu wajib meninggalkan identitas.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 4 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up" style="animation-delay: 0.4s">
                    <button class="faq-button w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-900 text-lg">Fasilitas apa saja yang sudah termasuk dalam harga?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="p-6 pt-0 text-gray-600">
                            Harga sudah termasuk listrik, air, WiFi, keamanan 24 jam, kebersihan, dan akses ke semua fasilitas umum seperti dapur bersama dan area parkir.
                        </div>
                    </div>
                </div>

                <!-- FAQ Item 5 -->
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 animate-slide-up" style="animation-delay: 0.5s">
                    <button class="faq-button w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors" onclick="toggleFAQ(this)">
                        <span class="font-semibold text-gray-900 text-lg">Bagaimana cara melakukan booking?</span>
                        <i class="fas fa-chevron-down text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div class="faq-content max-h-0 overflow-hidden transition-all duration-300">
                        <div class="p-6 pt-0 text-gray-600">
                            Anda dapat melakukan booking melalui WhatsApp atau datang langsung ke lokasi untuk melihat kamar. Proses booking mudah dan cepat, cukup transfer DP dan kamar langsung dapat
                            ditempati.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. LOKASI SECTION -->
    <section id="lokasi" class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Lokasi Info -->
                <div class="animate-fade-in-left">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6">
                        Lokasi Strategis
                    </h2>
                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        Terletak di jantung kota dengan akses mudah ke berbagai tempat penting. Dekat dengan kampus, mall, rumah sakit, dan pusat bisnis.
                    </p>

                    <div class="space-y-6">
                        <div class="flex gap-4 transform transition-transform">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 transform hover:rotate-12 transition-transform">
                                <i class="fas fa-map-marker-alt text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Alamat</h4>
                                <p class="text-gray-600">Jl. Merdeka No. 123, Jakarta Selatan, 12345</p>
                            </div>
                        </div>

                        <div class="flex gap-4 transform transition-transform">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 transform hover:rotate-12 transition-transform">
                                <i class="fas fa-phone text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                                <p class="text-gray-600">+62 812 3456 7890</p>
                            </div>
                        </div>

                        <div class="flex gap-4 transform transition-transform">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 transform hover:rotate-12 transition-transform">
                                <i class="fas fa-clock text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Jam Operasional</h4>
                                <p class="text-gray-600">Senin - Jumat: 08:00 - 20:00<br>Sabtu - Minggu: 09:00 - 18:00</p>
                            </div>
                        </div>
                    </div>

                    <button class="mt-8 bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 hover:shadow-lg">
                        Lihat di Google Maps
                    </button>
                </div>

                <!-- Map Embed -->
                <div class="w-full h-96 bg-gray-300 rounded-xl overflow-hidden shadow-lg animate-fade-in-right transform hover:scale-100 transition-transform duration-300">
                    <iframe width="100%" height="100%" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.521573490504!2d106.8193!3d-6.2297!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f18fadc0a507%3A0x15a1f3e95d4a7a5a!2sJl%20Merdeka%2C%20Jakarta%2012345!5e0!3m2!1sen!2sid!4v1234567890">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CALL TO ACTION SECTION -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-blue-500">
        <div class="max-w-4xl mx-auto text-center animate-fade-in">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                Siap Merasakan Kenyamanan?
            </h2>
            <p class="text-lg text-blue-100 mb-10 leading-relaxed">
                Jangan lewatkan kesempatan untuk menginap di tempat yang nyaman dan terpercaya. Hubungi kami sekarang untuk informasi lebih lanjut atau booking langsung.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button class="bg-white hover:bg-gray-100 text-blue-500 px-8 py-4 rounded-lg font-semibold transition-all transform hover:scale-110 hover:shadow-2xl"
                    onclick="location.href='https://wa.me/+6287870327957'">
                    <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                </button>
                <button class="border-2 border-white hover:bg-white/10 text-white px-8 py-4 rounded-lg font-semibold transition-all transform hover:scale-110">
                    <i class="fas fa-envelope mr-2"></i>Hubungi Email
                </button>
            </div>
        </div>
    </section>

    <!-- Custom CSS Animations -->
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
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

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-fade-in-right {
            animation: fadeInRight 0.8s ease-out;
        }

        .animate-fade-in-left {
            animation: fadeInLeft 0.8s ease-out;
        }

        .animate-fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out backwards;
        }

        /* Scroll Animation */
        .scroll-animate {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .scroll-animate.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

    <!-- JavaScript for FAQ Toggle and Scroll Animations -->
    <script>
        function toggleFAQ(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');

            // Toggle current FAQ
            if (content.classList.contains('max-h-0')) {
                // Close all other FAQs
                document.querySelectorAll('.faq-content').forEach(item => {
                    if (item !== content) {
                        item.classList.add('max-h-0');
                        item.classList.remove('max-h-96');
                        item.previousElementSibling.querySelector('i').classList.remove('rotate-180');
                    }
                });

                // Open current FAQ
                content.classList.remove('max-h-0');
                content.classList.add('max-h-96');
                icon.classList.add('rotate-180');
            } else {
                // Close current FAQ
                content.classList.add('max-h-0');
                content.classList.remove('max-h-96');
                icon.classList.remove('rotate-180');
            }
        }

        // Scroll Animation Observer
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        // Observe all sections on load
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('section').forEach(section => {
                section.classList.add('scroll-animate');
                observer.observe(section);
            });
        });
    </script>
@endsection
