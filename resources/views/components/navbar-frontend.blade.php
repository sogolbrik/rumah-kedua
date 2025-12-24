<!-- 1. NAVBAR -->
<nav x-data="{ mobileOpen: false }"
    class="fixed top-4 left-1/2 -translate-x-1/2 z-50 w-[calc(100%-2rem)] max-w-5xl 
            bg-white/90 backdrop-blur-md rounded-4xl shadow-lg border border-white/80 
            transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('landing-page') }}" class="flex items-center gap-2.5 group" aria-label="Kembali ke beranda RumahKedua">
                <div class="w-9 h-9 bg-gradient-to-br from-blue-600 to-cyan-500 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                    <i class="fas fa-home text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-900 to-cyan-700">
                    {{ $pengaturan->nama_kos ?? 'RumahKedua' }}
                </span>
            </a>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center gap-6">
                @foreach ([['label' => 'Fasilitas', 'id' => 'fasilitas'], ['label' => 'Kamar', 'id' => 'kamar'], ['label' => 'Lokasi', 'id' => 'lokasi'], ['label' => 'Galeri', 'route' => 'galeri-kamar'], ['label' => 'Kontak', 'id' => 'kontak']] as $item)
                    @if (isset($item['route']))
                        <a href="{{ route($item['route']) }}" class="text-gray-700 hover:text-cyan-600 font-medium relative group transition-colors duration-200">
                            {{ $item['label'] }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cyan-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @else
                        <a href="{{ url('/#' . $item['id']) }}" class="text-gray-700 hover:text-cyan-600 font-medium relative group transition-colors duration-200">
                            {{ $item['label'] }}
                            <span class="absolute -bottom-1 left-0 w-0 h-0.5 bg-cyan-500 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @endif
                @endforeach
            </div>

            <!-- CTA Button Desktop -->
            <div class="hidden md:flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="relative overflow-hidden rounded-lg border-2 border-cyan-500 px-5 py-2 font-medium text-cyan-600 transition-all duration-300 hover:bg-cyan-50 hover:text-cyan-700">
                    Login
                </a>
                <a href="{{ route('booking') }}"
                    class="relative overflow-hidden rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-2 font-medium text-white shadow-md hover:shadow-lg transition-all duration-300 hover:from-cyan-600 hover:to-blue-700">
                    <span class="relative z-10 flex items-center gap-1.5">
                        <i class="fas fa-calendar-check text-xs"></i>
                        Booking Sekarang
                    </span>
                </a>
            </div>

            <!-- Mobile Menu Button -->
            <button @click="mobileOpen = !mobileOpen" class="md:hidden text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors" :aria-expanded="mobileOpen" aria-controls="mobile-menu"
                aria-label="Toggle navigation menu">
                <i :class="mobileOpen ? 'fas fa-times' : 'fas fa-bars'" class="text-2xl"></i>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4" id="mobile-menu"
            class="md:hidden pb-4 pt-3 space-y-2 bg-white/95 backdrop-blur-sm rounded-b-2xl border-t border-gray-100">

            @foreach ([['label' => 'Fasilitas', 'id' => 'fasilitas'], ['label' => 'Kamar', 'id' => 'kamar'], ['label' => 'Lokasi', 'id' => 'lokasi'], ['label' => 'Galeri', 'route' => 'galeri-kamar'], ['label' => 'Kontak', 'id' => 'kontak']] as $item)
                @if (isset($item['route']))
                    <a href="{{ route($item['route']) }}" @click="mobileOpen = false" class="block px-4 py-2.5 text-gray-700 hover:bg-cyan-50 rounded-xl transition-colors font-medium">
                        {{ $item['label'] }}
                    </a>
                @else
                    <a href="{{ url('/#' . $item['id']) }}" @click="mobileOpen = false" class="block px-4 py-2.5 text-gray-700 hover:bg-cyan-50 rounded-xl transition-colors font-medium">
                        {{ $item['label'] }}
                    </a>
                @endif
            @endforeach

            <div class="flex flex-col gap-2 px-4 pt-2">
                <a href="{{ route('login') }}" @click="mobileOpen = false" class="w-full">
                    <button class="w-full bg-white border-2 border-cyan-500 text-cyan-600 px-4 py-2.5 rounded-xl font-medium transition-colors hover:bg-cyan-50">
                        Login
                    </button>
                </a>
                <a href="{{ route('booking') }}" @click="mobileOpen = false" class="w-full">
                    <button class="w-full bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-4 py-2.5 rounded-xl font-medium shadow-sm hover:shadow transition-all">
                        Booking Sekarang
                    </button>
                </a>
            </div>
        </div>
    </div>
</nav>