@extends('layouts.frontend-main')

@section('title', 'Pesan Kamar Sekarang')
@section('frontend-main')

    <style>
        :root {
            --color-primary: #2563eb;
            --color-primary-dark: #1e40af;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #eff6ff 100%);
        }

        body {
            background: var(--bg-gradient);
            scroll-behavior: smooth;
        }

        /* Card Styling */
        .room-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        .room-card:hover {
            transform: translateY(-8px);
        }

        /* Image Zoom Effect */
        .img-container img {
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .room-card:hover .img-container img {
            transform: scale(1.1);
        }

        /* Overlay Glassmorphism */
        .glass-overlay {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            opacity: 0;
            transition: all 0.4s ease;
        }

        .room-card:hover .glass-overlay {
            opacity: 1;
        }

        /* Floating Badge */
        .status-badge {
            backdrop-filter: blur(8px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Custom Range Slider */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: var(--color-primary);
            cursor: pointer;
            box-shadow: 0 0 10px rgba(37, 99, 235, 0.3);
            border: 3px solid white;
        }
    </style>

    <div class="min-h-screen pt-28 pb-12">
        <div class="max-w-7xl mx-auto px-4 mb-12 text-center">
            <span class="inline-block px-4 py-1.5 mb-4 text-xs font-bold tracking-widest text-blue-600 uppercase bg-blue-100 rounded-full">
                Available Rooms
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">
                Temukan Kamar <span class="text-blue-600 italic">Eksklusif</span>
            </h1>
            <p class="text-slate-600 max-w-2xl mx-auto text-lg">
                Pilih ruang ternyaman untuk produktivitas dan istirahat Anda dengan fasilitas premium standar hotel berbintang.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 mb-10">
            <div class="bg-white/80 backdrop-blur-md p-6 rounded-3xl shadow-xl border border-white/50">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div class="lg:col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
                        <div class="relative">
                            <input type="text" id="searchInput" placeholder="Kode atau Tipe..."
                                class="w-full pl-10 pr-4 py-3 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 transition-all text-sm font-medium">
                            <svg class="w-5 h-5 absolute left-3 top-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 lg:col-span-2">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe</label>
                            <select id="tipeFilter" class="w-full py-3 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 text-sm font-medium appearance-none">
                                <option value="">Semua Tipe</option>
                                @foreach ($kamar->pluck('tipe')->unique() as $tipe)
                                    <option value="{{ $tipe }}">{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ketersediaan</label>
                            <select id="statusFilter" class="w-full py-3 bg-slate-100 border-none rounded-2xl focus:ring-2 focus:ring-blue-500 text-sm font-medium appearance-none">
                                <option value="">Semua Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Terisi">Terisi</option>
                            </select>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="flex justify-between mb-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Harga Max</label>
                            <span class="text-xs font-bold text-blue-600" id="priceValueDisplay">Rp {{ number_format($kamar->max('harga'), 0, ',', '.') }}</span>
                        </div>
                        <input type="range" id="priceFilter" min="0" max="{{ $kamar->max('harga') ?? 10000000 }}" step="100000" value="{{ $kamar->max('harga') ?? 10000000 }}"
                            class="w-full h-2 bg-slate-200 rounded-lg appearance-none cursor-pointer">
                        <button id="resetFilters" class="mt-4 w-full py-2 text-xs font-bold text-slate-400 hover:text-red-500 transition-colors flex items-center justify-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            RESET FILTER
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-bold text-slate-800">Hasil Pencarian (<span id="resultsCount">{{ $kamar->count() }}</span>)</h2>
            </div>

            <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($kamar as $item)
                    <div class="room-card group bg-white rounded-[2rem] overflow-hidden shadow-sm" data-tipe="{{ $item->tipe }}" data-status="{{ $item->status }}" data-harga="{{ $item->harga }}"
                        data-kode="{{ $item->kode_kamar }}" data-deskripsi="{{ $item->deskripsi }}">

                        <div class="relative aspect-[4/5] overflow-hidden img-container">
                            <img src="{{ Storage::url($item->gambar) ?? asset('assets/image/dummy/standard.jpg') }}" class="w-full h-full object-cover" alt="Kamar">

                            <div class="absolute top-5 left-5 right-5 flex justify-between items-start">
                                <span
                                    class="status-badge px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest {{ $item->status == 'Tersedia' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                    {{ $item->status }}
                                </span>
                                <div class="bg-white/90 backdrop-blur shadow-sm px-3 py-1 rounded-xl text-slate-900 font-bold text-sm">
                                    Rp {{ number_format($item->harga / 1000, 0) }}k<span class="text-[10px] text-slate-500 font-normal">/bln</span>
                                </div>
                            </div>

                            <div class="glass-overlay absolute inset-0 flex flex-col justify-end p-8 text-white">
                                <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h3 class="text-2xl font-bold mb-1">{{ $item->kode_kamar }}</h3>
                                    <p class="text-white/80 text-sm mb-6 line-clamp-2">{{ $item->deskripsi }}</p>

                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <span class="text-xs font-semibold">{{ $item->lebar }} m²</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path d="M5 13l4 4L19 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                            <span class="text-xs font-semibold">{{ $item->tipe }}</span>
                                        </div>
                                    </div>

                                    @if ($item->status == 'Tersedia')
                                        <a href="{{ Route('booking-detail', $item->id) }}"
                                            class="block w-full py-4 bg-white text-blue-600 text-center font-bold rounded-2xl hover:bg-blue-50 transition-colors">
                                            Booking Sekarang
                                        </a>
                                    @else
                                        <button class="block w-full py-4 bg-rose-500 text-white text-center font-bold rounded-2xl cursor-not-allowed" disabled>
                                            Tidak Tersedia
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-white flex justify-between items-center group-hover:opacity-0 transition-opacity">
                            <div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $item->kode_kamar }}</h4>
                                <p class="text-sm text-slate-500 font-medium">{{ $item->tipe }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Luas</p>
                                <p class="text-sm font-bold text-slate-700">{{ $item->lebar }} m²</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-6 rounded-full bg-slate-100 mb-4 text-slate-300">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800">Kamar tidak ditemukan</h3>
                        <p class="text-slate-500">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const tipeFilter = document.getElementById('tipeFilter');
            const statusFilter = document.getElementById('statusFilter');
            const priceFilter = document.getElementById('priceFilter');
            const priceValueDisplay = document.getElementById('priceValueDisplay');
            const resetFilters = document.getElementById('resetFilters');
            const resultsCount = document.getElementById('resultsCount');
            const roomCards = document.querySelectorAll('.room-card');

            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            function filterRooms() {
                const searchTerm = searchInput.value.toLowerCase();
                const selectedTipe = tipeFilter.value;
                const selectedStatus = statusFilter.value;
                const maxPrice = parseInt(priceFilter.value);

                let visibleCount = 0;

                roomCards.forEach(card => {
                    const tipe = card.dataset.tipe;
                    const status = card.dataset.status;
                    const harga = parseInt(card.dataset.harga);
                    const kode = card.dataset.kode.toLowerCase();
                    const deskripsi = (card.dataset.deskripsi || "").toLowerCase();

                    const matchSearch = kode.includes(searchTerm) || tipe.toLowerCase().includes(searchTerm) || deskripsi.includes(searchTerm);
                    const matchTipe = !selectedTipe || tipe === selectedTipe;
                    const matchStatus = !selectedStatus || status === selectedStatus;
                    const matchPrice = harga <= maxPrice;

                    if (matchSearch && matchTipe && matchStatus && matchPrice) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                resultsCount.textContent = visibleCount;
                priceValueDisplay.textContent = `Rp ${formatNumber(maxPrice)}`;
            }

            searchInput.addEventListener('input', filterRooms);
            tipeFilter.addEventListener('change', filterRooms);
            statusFilter.addEventListener('change', filterRooms);
            priceFilter.addEventListener('input', filterRooms);

            resetFilters.addEventListener('click', function() {
                searchInput.value = '';
                tipeFilter.value = '';
                statusFilter.value = '';
                priceFilter.value = priceFilter.max;
                filterRooms();
            });
        });
    </script>

@endsection
