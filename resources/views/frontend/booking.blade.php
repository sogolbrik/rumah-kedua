@extends('layouts.frontend-main')

@section('title', 'Pesan Kamar Sekarang')
@section('frontend-main')

    <style>
        :root {
            /* Palette Integration */
            --color-headline: #094067;
            --color-paragraph: #5f6c7b;
            --color-button: #3da9fc;
            --color-button-text: #fffffe;
            --color-bg: #fffffe;
            --color-secondary: #90b4ce;
            --color-tertiary: #ef4565;

            --bg-gradient: radial-gradient(circle at top right, #fffffe 0%, #90b4ce15 100%);
        }

        body {
            background-color: var(--color-bg);
            background-image: var(--bg-gradient);
            color: var(--color-paragraph);
            scroll-behavior: smooth;
        }

        /* Card Styling */
        .room-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(144, 180, 206, 0.2);
            background: #ffffff;
        }

        .room-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(9, 64, 103, 0.1), 0 10px 10px -5px rgba(9, 64, 103, 0.04);
            border-color: var(--color-secondary);
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
            background: rgba(9, 64, 103, 0.75);
            /* Stroke/Headline color with opacity */
            backdrop-filter: blur(6px);
            opacity: 0;
            transition: all 0.4s ease;
        }

        .room-card:hover .glass-overlay {
            opacity: 1;
        }

        /* Custom Range Slider */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: var(--color-button);
            cursor: pointer;
            box-shadow: 0 0 10px rgba(61, 169, 252, 0.3);
            border: 3px solid white;
        }

        input[type=range] {
            background: #d8eefe;
            /* Light tint of button color */
        }
    </style>

    <div class="min-h-screen pt-28 pb-12">

        @if ($showPendingAlert && $pendingTransaksi && $pendingTransaksi->kamar)
            <div class="w-full top-16 z-50">
                <div class="max-w-7xl mx-auto px-4 py-3">
                    <div class="flex items-start gap-4 bg-[#fffdf5] border border-[#fde68a] rounded-2xl px-5 py-4 shadow-sm">

                        <div class="flex-shrink-0 mt-1">
                            <div class="w-9 h-9 rounded-full bg-[#fde68a] flex items-center justify-center">
                                <i class="fas fa-clock text-[#b45309] text-sm"></i>
                            </div>
                        </div>

                        <div class="flex-1">
                            <p class="text-sm font-bold text-[#92400e]">
                                <i class="fas fa-exclamation-triangle mr-1"></i> Transaksi Belum Selesai
                            </p>
                            <p class="text-xs text-[#a16207] mt-1 leading-relaxed">
                                Anda memiliki transaksi pembayaran kos
                                <span class="font-bold">{{ $pendingTransaksi->kamar->kode_kamar }}</span>
                                yang belum diselesaikan.
                                <span class="font-medium">Segera selesaikan pembayaran</span>
                                sebelum masa berlaku habis untuk mengamankan kamar Anda.
                            </p>
                            <p class="text-[10px] text-[#92400e] mt-1 flex items-center">
                                <i class="far fa-clock mr-1"></i>
                                <span>Berlaku hingga:
                                    @php
                                        $expiredAt = isset($pendingTransaksi->midtrans_response['expired_at'])
                                            ? \Carbon\Carbon::parse($pendingTransaksi->midtrans_response['expired_at'])
                                            : now()->addDay();
                                    @endphp
                                    {{ $expiredAt->format('d M Y H:i') }} WIB
                                </span>
                            </p>
                        </div>

                        <div class="flex flex-col items-end mt-4">
                            <a href="{{ route('user.pembayaran.booking', $pendingTransaksi->kamar->id) }}"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-[#f59e0b] text-white text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-[#d97706] transition transform hover:scale-[1.02] active:scale-[0.98] shadow-md">
                                <span>Lanjutkan Pembayaran</span>
                                <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto px-4 mb-12 text-center">
            <span class="inline-block px-4 py-1.5 mb-4 text-[10px] font-black tracking-[0.2em] text-[#3da9fc] uppercase bg-[#3da9fc15] rounded-full">
                Available Rooms
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-[#094067] mb-4 tracking-tight">
                Temukan Kamar <span class="text-[#3da9fc] italic">Eksklusif</span>
            </h1>
            <p class="text-[#5f6c7b] max-w-2xl mx-auto text-lg font-medium">
                Pilih ruang ternyaman untuk produktivitas dan istirahat Anda dengan fasilitas premium standar hotel berbintang.
            </p>
        </div>

        <div class="max-w-7xl mx-auto px-4 mb-10">
            <div class="bg-white p-6 rounded-[2.5rem] shadow-xl shadow-[#09406708] border border-[#90b4ce20]">
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                    <div class="lg:col-span-1">
                        <label class="block text-[10px] font-black text-[#90b4ce] uppercase tracking-widest mb-2 ml-1">Pencarian</label>
                        <div class="relative group">
                            <input type="text" id="searchInput" placeholder="Kode atau Tipe..."
                                class="w-full pl-10 pr-4 py-3 bg-[#90b4ce10] border-none rounded-2xl focus:ring-2 focus:ring-[#3da9fc] transition-all text-sm font-semibold text-[#094067] placeholder:text-[#90b4ce]">
                            <svg class="w-4 h-4 absolute left-4 top-3.5 text-[#90b4ce]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 lg:col-span-2">
                        <div>
                            <label class="block text-[10px] font-black text-[#90b4ce] uppercase tracking-widest mb-2 ml-1">Tipe</label>
                            <select id="tipeFilter"
                                class="w-full py-3 px-4 bg-[#90b4ce10] border-none rounded-2xl focus:ring-2 focus:ring-[#3da9fc] text-sm font-bold text-[#094067] appearance-none cursor-pointer">
                                <option value="">Semua Tipe</option>
                                @foreach ($kamar->pluck('tipe')->unique() as $tipe)
                                    <option value="{{ $tipe }}">{{ $tipe }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-[#90b4ce] uppercase tracking-widest mb-2 ml-1">Ketersediaan</label>
                            <select id="statusFilter"
                                class="w-full py-3 px-4 bg-[#90b4ce10] border-none rounded-2xl focus:ring-2 focus:ring-[#3da9fc] text-sm font-bold text-[#094067] appearance-none cursor-pointer">
                                <option value="">Semua Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Terisi">Terisi</option>
                            </select>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="flex justify-between mb-2 px-1">
                            <label class="text-[10px] font-black text-[#90b4ce] uppercase tracking-widest">Harga Max</label>
                            <span class="text-[11px] font-black text-[#3da9fc]" id="priceValueDisplay">Rp {{ number_format($kamar->max('harga'), 0, ',', '.') }}</span>
                        </div>
                        <input type="range" id="priceFilter" min="0" max="{{ $kamar->max('harga') ?? 10000000 }}" step="100000" value="{{ $kamar->max('harga') ?? 10000000 }}"
                            class="w-full h-2 rounded-lg appearance-none cursor-pointer">
                        <button id="resetFilters"
                            class="mt-4 w-full py-2 text-[10px] font-black text-[#90b4ce] hover:text-[#ef4565] transition-colors flex items-center justify-center gap-2 uppercase tracking-widest">
                            <i class="fas fa-undo-alt"></i> RESET FILTER
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-8 border-b border-[#90b4ce20] pb-4">
                <h2 class="text-lg font-black text-[#094067] uppercase tracking-tight">Hasil Pencarian (<span id="resultsCount" class="text-[#3da9fc]">{{ $kamar->count() }}</span>)</h2>
            </div>

            <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($kamar as $item)
                    <div class="room-card group rounded-[2.5rem] overflow-hidden" data-tipe="{{ $item->tipe }}" data-status="{{ $item->status }}" data-harga="{{ $item->harga }}"
                        data-kode="{{ $item->kode_kamar }}" data-deskripsi="{{ $item->deskripsi }}">

                        <div class="relative aspect-[4/5] overflow-hidden img-container">
                            <img src="{{ Storage::url($item->gambar) ?? asset('assets/image/dummy/standard.jpg') }}" class="w-full h-full object-cover" alt="Kamar">

                            <div class="absolute top-6 left-6 right-6 flex justify-between items-start z-10">
                                <span
                                    class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest shadow-lg {{ $item->status == 'Tersedia' ? 'bg-[#3da9fc] text-[#fffffe]' : 'bg-[#ef4565] text-[#fffffe]' }}">
                                    {{ $item->status }}
                                </span>
                                <div class="bg-[#fffffe] shadow-lg px-3 py-1.5 rounded-xl text-[#094067] font-black text-sm">
                                    Rp {{ number_format($item->harga / 1000, 0) }}k<span class="text-[10px] text-[#5f6c7b] font-bold">/bln</span>
                                </div>
                            </div>

                            <div class="glass-overlay absolute inset-0 flex flex-col justify-end p-8 text-[#fffffe]">
                                <div class="transform translate-y-8 group-hover:translate-y-0 transition-all duration-500 ease-out">
                                    <h3 class="text-2xl font-black mb-2 uppercase tracking-tight">{{ $item->kode_kamar }}</h3>
                                    <p class="text-[#fffffe]/80 text-xs font-medium mb-6 line-clamp-3 leading-relaxed">{{ $item->deskripsi }}</p>

                                    <div class="grid grid-cols-2 gap-3 mb-6">
                                        <div class="flex items-center gap-3 bg-[#fffffe15] p-2.5 rounded-2xl border border-[#fffffe20]">
                                            <i class="fas fa-vector-square text-[#3da9fc]"></i>
                                            <span class="text-[11px] font-bold">{{ $item->lebar }} m²</span>
                                        </div>
                                        <div class="flex items-center gap-3 bg-[#fffffe15] p-2.5 rounded-2xl border border-[#fffffe20]">
                                            <i class="fas fa-tag text-[#3da9fc]"></i>
                                            <span class="text-[11px] font-bold">{{ $item->tipe }}</span>
                                        </div>
                                    </div>

                                    @if ($item->status == 'Tersedia')
                                        <a href="{{ Route('booking-detail', $item->id) }}"
                                            class="block w-full py-4 bg-[#3da9fc] text-[#fffffe] text-center font-black uppercase tracking-widest text-[11px] rounded-2xl hover:bg-[#fffffe] hover:text-[#3da9fc] transition-all shadow-xl shadow-[#00000020]">
                                            Booking Sekarang
                                        </a>
                                    @else
                                        <button
                                            class="block w-full py-4 bg-[#ef4565] text-[#fffffe] text-center font-black uppercase tracking-widest text-[11px] rounded-2xl opacity-80 cursor-not-allowed"
                                            disabled>
                                            Sudah Terisi
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="p-6 bg-white flex justify-between items-center group-hover:opacity-0 transition-opacity duration-300">
                            <div>
                                <h4 class="text-base font-black text-[#094067] uppercase">{{ $item->kode_kamar }}</h4>
                                <p class="text-xs text-[#90b4ce] font-bold uppercase tracking-widest">{{ $item->tipe }}</p>
                            </div>
                            <div class="text-right border-l border-[#90b4ce20] pl-4">
                                <p class="text-[9px] text-[#90b4ce] font-black uppercase tracking-widest">Dimension</p>
                                <p class="text-sm font-black text-[#5f6c7b]">{{ $item->lebar }} <span class="text-[10px]">m²</span></p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div class="inline-block p-8 rounded-full bg-[#90b4ce10] mb-6 text-[#90b4ce]">
                            <i class="fas fa-bed text-5xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-[#094067] uppercase mb-2">Kamar tidak ditemukan</h3>
                        <p class="text-[#5f6c7b] font-medium">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
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
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
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
