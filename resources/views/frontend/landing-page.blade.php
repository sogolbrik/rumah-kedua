@extends('layouts.frontend-main')

@section('title', 'Temukan Kenyamanan Seperti di Rumah Sendiri')
@section('frontend-main')
    <!-- 2. HERO SECTION -->
    <header class="pt-32 pb-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-blue-50 via-cyan-50 to-white relative overflow-hidden">
        <!-- Decorative blobs -->
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-300/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-blue-300/20 rounded-full blur-3xl"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Hero Content -->
                <div class="space-y-6 animate-fade-in-up">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight tracking-tight">
                        Temukan Kenyamanan <br class="hidden md:block"> Seperti di Rumah Sendiri
                    </h1>
                    <p class="text-lg text-gray-700 leading-relaxed max-w-lg">
                        RumahKedua menawarkan akomodasi modern dengan fasilitas lengkap, lokasi strategis, dan layanan terbaik untuk kenyamanan menginap Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('booking') }}">
                            <button
                                class="bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 text-white px-8 py-3.5 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform">
                                <i class="fas fa-calendar-check mr-2"></i> Booking Sekarang
                            </button>
                        </a>
                        <a href="{{ route('galeri-kamar') }}">
                            <button class="border-2 border-cyan-500 text-cyan-600 hover:bg-cyan-50 px-8 py-3.5 rounded-xl font-semibold shadow-sm hover:shadow-md transition-all transform">
                                <i class="fas fa-images mr-2"></i> Lihat Galeri
                            </button>
                        </a>
                    </div>
                </div>
                <!-- Hero Image -->
                <div class="relative h-80 md:h-96 rounded-2xl overflow-hidden animate-fade-in-right transform transition-transform duration-500">
                    <img src="{{ asset('assets/image/landing-page/hero.svg') }}" alt="Kamar RumahKedua" class="w-full h-full object-cover shadow-xl">
                </div>
            </div>
        </div>
    </header>

    <!-- 3. WHY CHOOSE US -->
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ([['icon' => 'fa-shield-alt', 'title' => 'Aman & Terpercaya', 'desc' => 'CCTV 24 jam dan keamanan berlapis untuk kenyamanan Anda'], ['icon' => 'fa-map-marker-alt', 'title' => 'Lokasi Strategis', 'desc' => 'Dekat dengan kampus, mall, dan pusat bisnis'], ['icon' => 'fa-broom', 'title' => 'Bersih & Terawat', 'desc' => 'Perawatan rutin dan kebersihan terjamin setiap hari'], ['icon' => 'fa-wifi', 'title' => 'Internet Cepat', 'desc' => 'WiFi 100 Mbps tersedia di seluruh area kos']] as $index => $feature)
                    <div class="bg-gradient-to-b from-white to-slate-50 p-6 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1 border border-slate-100 animate-slide-up"
                        style="animation-delay: {{ 0.1 + $index * 0.1 }}s">
                        <div class="w-14 h-14 bg-cyan-100 rounded-xl flex items-center justify-center mx-auto mb-4 text-cyan-600">
                            <i class="fas {{ $feature['icon'] }} text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2 text-center">{{ $feature['title'] }}</h3>
                        <p class="text-gray-600 text-center">{{ $feature['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 4. FASILITAS SECTION -->
    <section id="fasilitas" class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-br from-slate-50 to-cyan-50/20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16 animate-fade-in">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Fasilitas Lengkap
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Nikmati berbagai fasilitas modern untuk kenyamanan maksimal Anda
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach ([['icon' => 'fa-bath', 'label' => 'K. Mandi Dalam'], ['icon' => 'fa-wifi', 'label' => 'WiFi 100 Mbps'], ['icon' => 'fa-utensils', 'label' => 'Dapur Bersama'], ['icon' => 'fa-car', 'label' => 'Parkir'], ['icon' => 'fa-camera', 'label' => 'CCTV 24 Jam'], ['icon' => 'fa-tshirt', 'label' => 'Laundry']] as $index => $fas)
                    <div class="bg-white p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 text-center animate-slide-up" style="animation-delay: {{ 0.1 + $index * 0.1 }}s">
                        <div class="w-12 h-12 bg-cyan-50 rounded-full flex items-center justify-center mx-auto mb-3 text-cyan-600">
                            <i class="fas {{ $fas['icon'] }} text-2xl"></i>
                        </div>
                        <p class="font-semibold text-gray-900 text-sm">{{ $fas['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 5. KAMAR SECTION -->
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
                <!-- Standard -->
                @if ($standard)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.1s">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ Storage::url($standard->gambar) }}" alt="Kamar {{ $standard->tipe }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $standard->tipe }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $standard->deskripsi }}</p>
                            <div class="space-y-1.5 mb-5 text-sm">
                                @foreach ($standard->detailKamar->take(3) as $detail)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                        <span class="text-gray-700">{{ $detail->fasilitas }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-cyan-600">Rp {{ number_format($standard->harga, 0, ',', '.') }}/bln</span>
                                @if ($standard->status == 'Tersedia')
                                    <a href="{{ route('booking-detail', $standard->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-800 px-4 py-2 rounded-lg text-sm transition-colors">Detail</a>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm">Terisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Medium (PALING POPULER) -->
                @if ($medium)
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-slide-up relative border-2 border-cyan-400"
                        style="animation-delay: 0.2s">
                        <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-cyan-500 to-emerald-500 text-white text-center py-1.5 text-xs font-bold z-10">
                            PALING POPULER
                        </div>
                        <div class="h-48 overflow-hidden mt-6">
                            <img src="{{ Storage::url($medium->gambar) }}" alt="Kamar {{ $medium->tipe }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $medium->tipe }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $medium->deskripsi }}</p>
                            <div class="space-y-1.5 mb-5 text-sm">
                                @foreach ($medium->detailKamar->take(3) as $detail)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                        <span class="text-gray-700">{{ $detail->fasilitas }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-cyan-600">Rp {{ number_format($medium->harga, 0, ',', '.') }}/bln</span>
                                @if ($medium->status == 'Tersedia')
                                    <a href="{{ route('booking-detail', $medium->id) }}"
                                        class="bg-gradient-to-r from-cyan-500 to-emerald-500 hover:from-cyan-600 hover:to-emerald-600 text-white px-4 py-2 rounded-lg text-sm transition-all shadow-md">Detail</a>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm">Terisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Exclusive -->
                @if ($exclusive)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 animate-slide-up" style="animation-delay: 0.3s">
                        <div class="h-48 overflow-hidden">
                            <img src="{{ Storage::url($exclusive->gambar) }}" alt="Kamar {{ $exclusive->tipe }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $exclusive->tipe }}</h3>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $exclusive->deskripsi }}</p>
                            <div class="space-y-1.5 mb-5 text-sm">
                                @foreach ($exclusive->detailKamar->take(3) as $detail)
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-check-circle text-emerald-500 text-xs"></i>
                                        <span class="text-gray-700">{{ $detail->fasilitas }}</span>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-cyan-600">Rp {{ number_format($exclusive->harga, 0, ',', '.') }}/bln</span>
                                @if ($exclusive->status == 'Tersedia')
                                    <a href="{{ route('booking-detail', $exclusive->id) }}"
                                        class="bg-slate-100 hover:bg-slate-200 text-slate-800 px-4 py-2 rounded-lg text-sm transition-colors">Detail</a>
                                @else
                                    <span class="bg-gray-100 text-gray-500 px-4 py-2 rounded-lg text-sm">Terisi</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
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
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform animate-slide-up" style="animation-delay: 0.1s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('assets/image/avatar/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full transform transition-transform">
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
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform animate-slide-up" style="animation-delay: 0.2s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('assets/image/avatar/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full transform transition-transform">
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
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-2xl transition-all transform animate-slide-up" style="animation-delay: 0.3s">
                    <div class="flex items-center gap-4 mb-4">
                        <img src="{{ asset('assets/image/avatar/default-avatar.png') }}" alt="Avatar" class="w-12 h-12 rounded-full transform transition-transform">
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

            <div x-data="{ activeIndex: null }" class="space-y-4">
                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" style="animation-delay: 0.1s">
                    <button @click="activeIndex = activeIndex === 0 ? null : 0" class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900 text-lg">Apakah tersedia tempat parkir?</span>
                        <i :class="activeIndex === 0 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div x-show="activeIndex === 0" x-transition class="p-6 pt-0 text-gray-600">
                        Ya, kami menyediakan area parkir yang luas dan aman untuk motor dan mobil. Parkir tersedia 24 jam dengan sistem keamanan CCTV.
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" style="animation-delay: 0.2s">
                    <button @click="activeIndex = activeIndex === 1 ? null : 1" class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900 text-lg">Apakah ada minimum kontrak sewa?</span>
                        <i :class="activeIndex === 1 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div x-show="activeIndex === 1" x-transition class="p-6 pt-0 text-gray-600">
                        Minimum kontrak sewa adalah 1 bulan. Kami juga menawarkan paket sewa 3 bulan dan 6 bulan dengan harga lebih hemat.
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" style="animation-delay: 0.3s">
                    <button @click="activeIndex = activeIndex === 2 ? null : 2" class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900 text-lg">Apakah boleh menerima tamu?</span>
                        <i :class="activeIndex === 2 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div x-show="activeIndex === 2" x-transition class="p-6 pt-0 text-gray-600">
                        Tamu diperbolehkan berkunjung pada jam 08:00 - 21:00 dengan melapor ke resepsionis. Untuk keamanan, tamu wajib meninggalkan identitas.
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" style="animation-delay: 0.4s">
                    <button @click="activeIndex = activeIndex === 3 ? null : 3" class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900 text-lg">Fasilitas apa saja yang sudah termasuk dalam harga?</span>
                        <i :class="activeIndex === 3 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div x-show="activeIndex === 3" x-transition class="p-6 pt-0 text-gray-600">
                        Harga sudah termasuk listrik, air, WiFi, keamanan 24 jam, kebersihan, dan akses ke semua fasilitas umum seperti dapur bersama dan area parkir.
                    </div>
                </div>

                <div class="bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300" style="animation-delay: 0.5s">
                    <button @click="activeIndex = activeIndex === 4 ? null : 4" class="w-full text-left p-6 flex justify-between items-center hover:bg-gray-50 transition-colors">
                        <span class="font-semibold text-gray-900 text-lg">Bagaimana cara melakukan booking?</span>
                        <i :class="activeIndex === 4 ? 'fas fa-chevron-up' : 'fas fa-chevron-down'" class="text-blue-500 transition-transform duration-300"></i>
                    </button>
                    <div x-show="activeIndex === 4" x-transition class="p-6 pt-0 text-gray-600">
                        Anda dapat melakukan booking langsung dengan klik tombol "Booking Sekarang" di pojok kanan atas atau datang langsung ke lokasi untuk melihat kamar. Proses booking mudah dan cepat,
                        cukup transfer kamar langsung dapat ditempati.
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
                                <p class="text-gray-600">{{ $pengaturan->alamat_kos ?? 'Jl. Raya Kutorejo No. 45, Kutorejo, Mojokerto, Jawa Timur 61383' }}</p>
                            </div>
                        </div>

                        <div class="flex gap-4 transform transition-transform">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 transform hover:rotate-12 transition-transform">
                                <i class="fas fa-phone text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Telepon</h4>
                                <p class="text-gray-600">+{{ $pengaturan->no_telepon ?? '6281234567890' }}</p>
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

                    <a href="https://maps.app.goo.gl/xxgSZjaCEQDPgodY9" target="_blank" rel="noopener noreferrer">
                        <button class="mt-8 bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 hover:shadow-lg">
                            Lihat di Google Maps
                        </button>
                    </a>
                </div>

                <!-- Map Embed -->
                <div class="w-full h-96 bg-gray-300 rounded-xl overflow-hidden shadow-lg animate-fade-in-right transform hover:scale-100 transition-transform duration-300">
                    <iframe width="100%" height="100%" style="border: 0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" src="{{ $mapUrl }}">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. CALL TO ACTION -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-cyan-600 to-blue-600" id="kontak">
        <div class="max-w-4xl mx-auto text-center animate-fade-in">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                Siap Merasakan Kenyamanan?
            </h2>
            <p class="text-lg text-cyan-100 mb-10 leading-relaxed max-w-2xl mx-auto">
                Jangan lewatkan kesempatan untuk menginap di tempat yang nyaman dan terpercaya. Hubungi kami sekarang!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/{{ str_replace([' ', '+'], '', $pengaturan->no_telepon ?? '6287870327957') }}" target="_blank"
                    class="bg-white hover:bg-gray-100 text-cyan-600 px-8 py-4 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all transform hover:scale-105">
                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                </a>
                <a href="mailto:{{ $pengaturan->email_kos ?? 'rumahkedua@gmail.com' }}"
                    class="border-2 border-white hover:bg-white/20 text-white px-8 py-4 rounded-xl font-semibold transition-all transform hover:scale-105">
                    <i class="fas fa-envelope mr-2"></i> Kirim Email
                </a>
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

    <!-- JavaScript for Scroll Animations -->
    <script>
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
