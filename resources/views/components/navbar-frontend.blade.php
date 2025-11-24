<!-- 1. NAVBAR (Sticky, Transparent → Solid on Scroll) -->
<nav x-data="{ scrolled: false, mobileOpen: false }" @scroll.window="scrolled = window.scrollY > 50" :class="scrolled ? 'bg-white shadow-md' : 'bg-transparent'" class="fixed w-full top-0 z-50 transition-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ Route('landing-page') }}" class="cursor-default">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-home text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-bold text-gray-900">RumahKedua</span>
                </div>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/#fasilitas') }}" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Fasilitas</a>
                <a href="{{ url('/#kamar') }}" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Kamar</a>
                <a href="{{ url('/#lokasi') }}" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Lokasi</a>
                <a href="{{ Route('galeri-kamar') }}" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Galeri</a>
                <a href="{{ url('/#lokasi') }}" class="text-gray-700 hover:text-blue-500 font-medium transition-colors">Kontak</a>
            </div>

            <!-- CTA Button Desktop -->
            <a href="{{ Route('booking')  }}" class="cursor-default">
                <button class="hidden md:inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Booking Sekarang
                </button>
            </a>

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
