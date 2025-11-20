@extends('layouts.frontend-main')

@section('title', 'Pesan Kamar Sekarang')
@section('frontend-main')

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

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Animasi untuk Default State Info (Bottom) */
        .default-info {
            transform: translateY(0);
            opacity: 1;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1),
                opacity 0.5s ease;
        }

        .group:hover .default-info {
            transform: translateY(20px);
            opacity: 0;
        }

        /* Animasi untuk Hover State Content */
        .hover-content {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s,
                transform 0.7s cubic-bezier(0.4, 0, 0.2, 1) 0.1s;
        }

        .group:hover .hover-content {
            opacity: 1;
            transform: translateY(0);
        }

        /* Animasi untuk setiap info item dengan stagger effect */
        .info-item {
            opacity: 0;
            transform: translateX(-20px);
            transition: opacity 0.5s ease, transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .info-item {
            opacity: 1;
            transform: translateX(0);
        }

        .group:hover .info-item:nth-child(1) {
            transition-delay: 0.15s;
        }

        .group:hover .info-item:nth-child(2) {
            transition-delay: 0.2s;
        }

        .group:hover .info-item:nth-child(3) {
            transition-delay: 0.25s;
        }

        .group:hover .info-item:nth-child(4) {
            transition-delay: 0.3s;
        }

        /* Animasi untuk button */
        .hover-button {
            opacity: 0;
            transform: translateY(20px) scale(0.95);
            transition: opacity 0.5s ease 0.35s,
                transform 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.35s;
        }

        .group:hover .hover-button {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        /* Animasi untuk blur overlay - Extra Smooth */
        .blur-overlay {
            opacity: 0;
            backdrop-filter: blur(0px);
            transition: opacity 0.7s cubic-bezier(0.4, 0, 0.2, 1),
                backdrop-filter 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .blur-overlay {
            opacity: 1;
            backdrop-filter: blur(8px);
        }

        /* Animasi untuk image zoom */
        .group:hover .room-image {
            transform: scale(1.05);
        }

        /* Animasi untuk favorite button */
        .favorite-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .group:hover .favorite-btn {
            transform: scale(1.1);
        }
    </style>

    <div class="min-h-screen bg-gradient-to-b from-neutral-50 to-white">
        <!-- Hero Section -->
        <section class="relative pt-20 pb-16 px-4 md:px-6 lg:px-8 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center space-y-6 mb-12">
                    <div class="inline-block">
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Temukan Kamar
                            Impian Anda</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-neutral-900 leading-tight">
                        Pesan Kamar<span class="text-blue-600"> Premium</span>
                    </h1>
                    <p class="text-lg md:text-xl text-neutral-600 max-w-2xl mx-auto leading-relaxed">
                        Nikmati pengalaman menginap yang tak terlupakan dengan koleksi kamar eksklusif kami. Setiap kamar
                        dirancang dengan sempurna untuk kenyamanan Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="top-0 z-40 bg-gradient-to-br from-white via-blue-50/30 to-white backdrop-blur-xl border-b border-neutral-200/50 shadow-lg transition-all">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-8">
                <div class="space-y-6">
                    <!-- Search Bar with Icon Animation -->
                    <div class="relative group">
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan kode kamar atau tipe..."
                            class="w-full px-6 py-4 pl-14 bg-white/80 backdrop-blur-sm border-2 border-neutral-200 rounded-2xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-300 shadow-sm hover:shadow-md font-medium text-neutral-700 placeholder:text-neutral-400">
                        <div class="absolute left-5 top-1/2 -translate-y-1/2 transition-transform duration-300 group-focus-within:scale-110 group-focus-within:rotate-12">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Filter Controls with Modern Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <!-- Tipe Kamar Filter -->
                        <div class="group">
                            <label class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z">
                                    </path>
                                </svg>
                                Tipe Kamar
                            </label>
                            <div class="relative">
                                <select id="tipeFilter"
                                    class="w-full px-5 py-3.5 bg-white/80 backdrop-blur-sm border-2 border-neutral-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-300 shadow-sm hover:shadow-md font-medium text-neutral-700 appearance-none cursor-pointer">
                                    <option value="">Semua Tipe</option>
                                    @foreach ($kamar->pluck('tipe')->unique() as $tipe)
                                        <option value="{{ $tipe }}">{{ $tipe }}</option>
                                    @endforeach
                                </select>
                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-blue-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="group">
                            <label class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Status Ketersediaan
                            </label>
                            <div class="relative">
                                <select id="statusFilter"
                                    class="w-full px-5 py-3.5 bg-white/80 backdrop-blur-sm border-2 border-neutral-200 rounded-xl focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all duration-300 shadow-sm hover:shadow-md font-medium text-neutral-700 appearance-none cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="Tersedia">Tersedia</option>
                                    <option value="Terisi">Terisi</option>
                                </select>
                                <svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-green-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="group">
                            <label class="text-sm font-semibold text-neutral-700 mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                Harga Maksimal
                            </label>
                            <div class="px-5 py-3.5 bg-white/80 backdrop-blur-sm border-2 border-neutral-200 rounded-xl shadow-sm hover:shadow-md transition-all duration-300">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs font-medium text-neutral-500">Rp 0</span>
                                    <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">
                                        Rp <span id="priceValue">{{ number_format($kamar->max('harga') ?? 10000000, 0, ',', '.') }}</span>
                                    </span>
                                    <span class="text-xs font-medium text-neutral-500">Rp
                                        {{ number_format($kamar->max('harga') ?? 10000000, 0, ',', '.') }}</span>
                                </div>
                                <input type="range" id="priceFilter" min="0" max="{{ $kamar->max('harga') ?? 10000000 }}" step="100000" value="{{ $kamar->max('harga') ?? 10000000 }}"
                                    class="w-full h-2 bg-gradient-to-r from-blue-200 to-blue-400 rounded-full appearance-none cursor-pointer accent-blue-600 
                                    [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-5 [&::-webkit-slider-thumb]:h-5 
                                    [&::-webkit-slider-thumb]:rounded-full [&::-webkit-slider-thumb]:bg-blue-600 [&::-webkit-slider-thumb]:shadow-lg 
                                    [&::-webkit-slider-thumb]:hover:bg-blue-700 [&::-webkit-slider-thumb]:transition-all [&::-webkit-slider-thumb]:hover:scale-110">
                            </div>
                        </div>
                    </div>

                    <!-- Reset Button with Icon -->
                    <div class="flex justify-end">
                        <button id="resetFilters"
                            class="group px-6 py-3 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-500 rounded-xl hover:from-blue-700 hover:to-blue-600 transition-all duration-300 shadow-md hover:shadow-xl transform hover:scale-105 active:scale-95 flex items-center gap-2">
                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                            Reset Filter
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Content -->
        <section class="py-12 px-4 md:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <!-- Results Count -->
                <div class="mb-8">
                    <p class="text-neutral-600">
                        Menampilkan <span class="font-semibold text-neutral-900" id="resultsCount">{{ $kamar->count() }}</span> dari
                        <span class="font-semibold text-neutral-900">{{ $kamar->count() }}</span> kamar
                    </p>
                </div>

                <!-- Grid Kamar dengan Layout Modern -->
                <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($kamar as $index => $item)
                        <div class="room-card group relative bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-500" data-tipe="{{ $item->tipe }}"
                            data-status="{{ $item->status }}" data-harga="{{ $item->harga }}" data-kode="{{ $item->kode_kamar }}" data-deskripsi="{{ $item->deskripsi }}">

                            <!-- Image Container -->
                            <div class="relative h-[500px] overflow-hidden">
                                <img src="{{ Storage::url($item->gambar) ?? asset('assets/image/dummy/standard.jpg') }}" alt="{{ $item->kode_kamar }}"
                                    class="room-image w-full h-full object-cover transition-transform duration-700 ease-out">

                                <!-- Favorite Icon -->
                                {{-- <button class="favorite-btn absolute top-4 right-4 z-20 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center hover:bg-white/90">
                                    <svg class="w-5 h-5 text-white group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                                        </path>
                                    </svg>
                                </button> --}}

                                <!-- Default State - Info at Bottom -->
                                <div class="default-info absolute bottom-0 left-0 right-0 p-6 bg-gradient-to-t from-black/60 to-transparent">
                                    <h3 class="text-2xl font-bold text-white mb-1">{{ $item->kode_kamar }}</h3>
                                    <p class="text-sm text-white/90 mb-3">{{ $item->tipe }}</p>
                                    <div class="flex items-center gap-4 text-sm text-white/90">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                                </path>
                                            </svg>
                                            <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            @if ($item->status == 'Tersedia')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="9" stroke-width="2">
                                                    </circle>
                                                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <circle cx="12" cy="12" r="9" stroke-width="2">
                                                    </circle>
                                                    <line x1="8" y1="8" x2="16" y2="16" stroke-width="2" stroke-linecap="round"></line>
                                                </svg>
                                            @endif
                                            <span>{{ $item->status }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hover State with Smooth Animations -->
                                <div class="hover-content absolute inset-0 pointer-events-none group-hover:pointer-events-auto">
                                    <!-- Blur Overlay -->
                                    <div class="blur-overlay absolute inset-0 backdrop-blur-sm bg-black/40"></div>

                                    <!-- Content -->
                                    <div class="relative h-full flex flex-col justify-between p-6 text-white">
                                        <!-- Top Info -->
                                        <div class="hover-content">
                                            <h3 class="text-3xl font-bold mb-2">{{ $item->kode_kamar }}</h3>
                                            <p class="text-lg text-white/90 mb-4">{{ $item->tipe }}</p>
                                        </div>

                                        <!-- Middle Info with Stagger Animation -->
                                        <div class="space-y-3">
                                            <!-- Lebar -->
                                            <div class="info-item flex items-center gap-3">
                                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-white/70">Luas Kamar</p>
                                                    <p class="text-base font-semibold">{{ $item->lebar }} m²</p>
                                                </div>
                                            </div>

                                            <!-- Harga -->
                                            <div class="info-item flex items-center gap-3">
                                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-white/70">Harga per Bulan</p>
                                                    <p class="text-base font-semibold">Rp
                                                        {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                </div>
                                            </div>

                                            <!-- Status -->
                                            <div class="info-item flex items-center gap-3">
                                                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <div>
                                                    <p class="text-xs text-white/70">Status</p>
                                                    <p class="text-base font-semibold">{{ $item->status }}</p>
                                                </div>
                                            </div>

                                            <!-- Fasilitas -->
                                            @if ($item->detailKamar && $item->detailKamar->count() > 0)
                                                <div class="info-item flex items-start gap-3">
                                                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <div>
                                                        <p class="text-xs text-white/70 mb-1">Fasilitas</p>
                                                        <div class="flex flex-wrap gap-1.5">
                                                            @foreach ($item->detailKamar->take(3) as $detail)
                                                                <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs rounded-md">
                                                                    {{ $detail->fasilitas }}
                                                                </span>
                                                            @endforeach
                                                            @if ($item->detailKamar->count() > 3)
                                                                <span class="inline-block px-2 py-1 bg-white/20 backdrop-blur-sm text-white text-xs rounded-md">
                                                                    +{{ $item->detailKamar->count() - 3 }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Bottom Button -->
                                        <div class="hover-button mt-6">
                                            <a href="{{ Route('booking-detail', $item->id) }}"
                                                class="{{ $item->status === 'Terisi' ? 'opacity-50 cursor-not-allowed' : 'hover:bg-white hover:text-neutral-900' }} block w-full py-3.5 px-4 bg-white/10 backdrop-blur-sm border-2 border-white text-white font-semibold rounded-2xl transition-all duration-300 text-center">
                                                Lihat Detail
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="col-span-full flex flex-col items-center justify-center py-20 px-4">
                            <svg class="w-20 h-20 text-neutral-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                </path>
                            </svg>
                            <h3 class="text-2xl font-bold text-neutral-900 mb-2">Tidak Ada Kamar Tersedia</h3>
                            <p class="text-neutral-600 text-center max-w-md mb-6">
                                Saat ini tidak ada kamar yang tersedia. Silakan hubungi kami untuk informasi lebih lanjut.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tipeFilter = document.getElementById('tipeFilter');
            const statusFilter = document.getElementById('statusFilter');
            const priceFilter = document.getElementById('priceFilter');
            const priceValue = document.getElementById('priceValue');
            const resetFilters = document.getElementById('resetFilters');
            const resultsCount = document.getElementById('resultsCount');
            const roomCards = document.querySelectorAll('.room-card');

            // Format number to Indonesian currency format
            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            // Update price value display
            priceFilter.addEventListener('input', function() {
                priceValue.textContent = formatNumber(this.value);
                filterRooms();
            });

            // Filter rooms function
            function filterRooms() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedTipe = tipeFilter.value;
                const selectedStatus = statusFilter.value;
                const maxPrice = parseInt(priceFilter.value);

                let visibleCount = 0;

                roomCards.forEach(card => {
                    const tipe = card.getAttribute('data-tipe');
                    const status = card.getAttribute('data-status');
                    const harga = parseInt(card.getAttribute('data-harga'));
                    const kode = card.getAttribute('data-kode').toLowerCase();
                    const deskripsi = card.getAttribute('data-deskripsi').toLowerCase();

                    const matchSearch = kode.includes(searchTerm) ||
                        tipe.toLowerCase().includes(searchTerm) ||
                        deskripsi.includes(searchTerm);
                    const matchTipe = !selectedTipe || tipe === selectedTipe;
                    const matchStatus = !selectedStatus || status === selectedStatus;
                    const matchPrice = harga <= maxPrice;

                    if (matchSearch && matchTipe && matchStatus && matchPrice) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                resultsCount.textContent = visibleCount;
            }

            // Event listeners for filters
            searchInput.addEventListener('input', filterRooms);
            tipeFilter.addEventListener('change', filterRooms);
            statusFilter.addEventListener('change', filterRooms);

            // Reset filters
            resetFilters.addEventListener('click', function() {
                searchInput.value = '';
                tipeFilter.value = '';
                statusFilter.value = '';
                priceFilter.value = priceFilter.getAttribute('max');
                priceValue.textContent = formatNumber(priceFilter.value);
                filterRooms();
            });
        });
    </script>

@endsection
