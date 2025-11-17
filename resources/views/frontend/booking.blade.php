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
    </style>

    <div class="min-h-screen bg-gradient-to-b from-neutral-50 to-white">
        <!-- Hero Section -->
        <section class="relative pt-20 pb-16 px-4 md:px-6 lg:px-8 overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="text-center space-y-6 mb-12">
                    <div class="inline-block">
                        <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">Temukan Kamar Impian Anda</span>
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-neutral-900 leading-tight">
                        Pesan Kamar<span class="text-blue-600"> Premium</span>
                    </h1>
                    <p class="text-lg md:text-xl text-neutral-600 max-w-2xl mx-auto leading-relaxed">
                        Nikmati pengalaman menginap yang tak terlupakan dengan koleksi kamar eksklusif kami. Setiap kamar dirancang dengan sempurna untuk kenyamanan Anda.
                    </p>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="top-0 z-40 bg-white border-b border-neutral-200 shadow-sm transition-all">
            <div class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6">
                <div class="space-y-4">
                    <!-- Search Bar -->
                    <div class="relative">
                        <input type="text" id="searchInput" placeholder="Cari berdasarkan kode kamar atau tipe..."
                            class="w-full px-4 py-3 pl-12 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition">
                        <svg class="absolute left-4 top-3.5 w-5 h-5 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>

                    <!-- Filter Controls -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Tipe Kamar Filter -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Tipe Kamar</label>
                            <select id="tipeFilter" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                                <option value="">Semua Tipe</option>
                                @foreach ($kamar->pluck('tipe')->unique() as $tipe)
                                    <option value="{{ $tipe }}">{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">Status Ketersediaan</label>
                            <select id="statusFilter" class="w-full px-4 py-2 border border-neutral-300 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none transition">
                                <option value="">Semua Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Terisi">Terisi</option>
                            </select>
                        </div>

                        <!-- Price Range Filter -->
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-2">
                                Harga Maksimal: <span class="text-blue-600 font-semibold">Rp <span id="priceValue">{{ number_format($kamar->max('harga') ?? 10000000, 0, ',', '.') }}</span></span>
                            </label>
                            <input type="range" id="priceFilter" min="0" max="{{ $kamar->max('harga') ?? 10000000 }}" step="100000" value="{{ $kamar->max('harga') ?? 10000000 }}"
                                class="w-full accent-blue-600">
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <div class="flex justify-end">
                        <button id="resetFilters" class="px-4 py-2 text-sm font-medium text-neutral-600 bg-neutral-100 rounded-lg hover:bg-neutral-200 transition-bg">
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

                <!-- Grid Kamar dengan Layout Variatif -->
                <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-max">
                    @forelse($kamar as $index => $item)
                        <div class="room-card group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 transform hover:scale-105"
                            data-tipe="{{ $item->tipe }}" data-status="{{ $item->status }}" data-harga="{{ $item->harga }}" data-kode="{{ $item->kode_kamar }}" data-deskripsi="{{ $item->deskripsi }}"
                            :class="[
                                ($index % 5 === 0) ?
                                'lg:col-span-2 lg:row-span-2' : '',
                                ($index % 5 === 1) ? 'lg:col-span-1 lg:row-span-2' : ''
                            ]">
                            <!-- Image Container -->
                            <div class="relative h-64 md:h-72 lg:h-96 overflow-hidden bg-neutral-200">
                                <img src="{{ Storage::url($item->gambar) ?? asset('assets/image/dummy/standard.jpg') }}" alt="{{ $item->kode_kamar }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">

                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-0 group-hover:opacity-70 transition-opacity duration-300"></div>

                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4 z-10">
                                    <span
                                        class="{{ $item->status === 'Tersedia' ? 'bg-green-500' : 'bg-red-500' }} inline-block px-3 py-1 rounded-full text-white text-xs font-bold uppercase tracking-wider shadow-lg">
                                        {{ $item->status === 'Tersedia' ? '✓ Tersedia' : '✕ Terisi' }}
                                    </span>
                                </div>

                                <!-- Ribbon Type -->
                                <div class="absolute top-4 left-4 z-10">
                                    <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-lg shadow-lg">
                                        {{ $item->tipe }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 space-y-4">
                                <!-- Header Info -->
                                <div class="space-y-2">
                                    <h3 class="text-xl font-bold text-neutral-900">{{ $item->kode_kamar }}</h3>
                                    <p class="text-sm text-neutral-600">{{ $item->tipe }}</p>
                                </div>

                                <!-- Specs Grid -->
                                <div class="grid grid-cols-2 gap-3 py-3 border-y border-neutral-200">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                            </path>
                                        </svg>
                                        <div class="text-sm">
                                            <p class="text-neutral-600">Lebar</p>
                                            <p class="font-semibold text-neutral-900">{{ $item->lebar }} m²</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg>
                                        <div class="text-sm">
                                            <p class="text-neutral-600">Harga/Bulan</p>
                                            <p class="font-semibold text-blue-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description -->
                                <p class="text-sm text-neutral-600 line-clamp-2">{{ $item->deskripsi }}</p>

                                <!-- Fasilitas Preview -->
                                @if ($item->detailKamar && $item->detailKamar->count() > 0)
                                    <div class="pt-2">
                                        <p class="text-xs text-neutral-500 mb-1">Fasilitas:</p>
                                        <div class="flex flex-wrap gap-1">
                                            @foreach ($item->detailKamar->take(3) as $detail)
                                                <span class="inline-block px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded-md">{{ $detail->fasilitas }}</span>
                                            @endforeach
                                            @if ($item->detailKamar->count() > 3)
                                                <span class="inline-block px-2 py-1 bg-neutral-100 text-neutral-600 text-xs rounded-md">
                                                    +{{ $item->detailKamar->count() - 3 }} lagi
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Button -->
                                <a href="/booking/{{ $item->kode_kamar }}"
                                    class="{{ $item->status === 'Terisi' ? 'opacity-50 cursor-not-allowed' : '' }} block w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-all duration-300 text-center uppercase text-sm tracking-wider">
                                    <span class="flex items-center justify-center gap-2">
                                        Lihat Detail
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                                        </svg>
                                    </span>
                                </a>
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
