@extends('layouts.frontend-main')
@section('title', 'Detail Kamar - ' . $kamar->tipe)

@section('frontend-main')
    <style>
        :root {
            /* Elements Palette */
            --color-bg: #fffffe;
            --color-headline: #094067;
            --color-paragraph: #5f6c7b;
            --color-button: #3da9fc;
            --color-button-text: #fffffe;

            /* Illustration Palette */
            --color-stroke: #094067;
            --color-highlight: #3da9fc;
            --color-secondary: #90b4ce;
            --color-tertiary: #ef4565;

            /* Mapping to existing logic */
            --color-primary: var(--color-button);
            --color-neutral-50: var(--color-bg);
            --color-neutral-600: var(--color-paragraph);
            --color-neutral-900: var(--color-headline);
        }

        body {
            scroll-behavior: smooth;
            background-color: var(--color-bg);
            color: var(--color-paragraph);
        }

        .transition-smooth {
            transition: all 0.3s ease;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid var(--color-secondary);
            border-opacity: 0.3;
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--color-secondary), transparent);
        }

        h1,
        h2,
        h3,
        h4 {
            color: var(--color-headline);
        }

        .text-primary {
            color: var(--color-highlight) !important;
        }

        /* Override for Breadcrumb and active links */
        .text-blue-600 {
            color: var(--color-highlight) !important;
        }
    </style>

    <div class="min-h-screen py-15 px-4 sm:px-6 lg:px-8 mt-12">
        <div class="max-w-6xl mx-auto">
            <nav class="mb-8 flex items-center gap-2 text-sm">
                <a href="{{ Route('landing-page') }}" class="text-[#5f6c7b] hover:text-[#3da9fc] transition-smooth font-medium">Home</a>
                <span class="text-[#90b4ce]">/</span>
                <a href="{{ Route('booking') }}" class="text-[#5f6c7b] hover:text-[#3da9fc] transition-smooth font-medium">Kamar</a>
                <span class="text-[#90b4ce]">/</span>
                <span class="text-[#3da9fc] font-bold">{{ $kamar->tipe }}</span>
            </nav>

            <div class="mb-12" x-data="{ activeTab: 0, isZoomed: false }">
                <div class="relative rounded-2xl overflow-hidden shadow-lg mb-4 bg-[#90b4ce20] border-2 border-[#09406710] transition-smooth">
                    <img src="{{ Storage::url($kamar->gambar) }}" alt="{{ $kamar->tipe }}" class="w-full h-96 sm:h-[500px] object-cover cursor-zoom-in transition-smooth hover:scale-105"
                        @click="isZoomed = true">

                    <div x-cloak class="fixed inset-0 bg-[#094067]/95 z-50 flex items-center justify-center p-4 cursor-zoom-out" x-show="isZoomed" x-transition.opacity @click.self="isZoomed = false">
                        <img src="{{ Storage::url($kamar->gambar) }}" alt="{{ $kamar->tipe }}" class="max-w-4xl max-h-screen object-contain border-4 border-[#fffffe]">
                        <button @click="isZoomed = false" class="absolute top-4 right-4 text-[#fffffe] text-4xl font-light hover:text-[#ef4565] transition-smooth">
                            &times;
                        </button>
                    </div>

                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="px-4 py-2 bg-[#3da9fc] text-[#fffffe] rounded-full text-xs font-black tracking-widest uppercase shadow-md backdrop-blur-sm">
                            ✓ Tersedia
                        </span>
                    </div>
                </div>

                @if ($kamar->galeri && count($kamar->galeri) > 0)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-black uppercase tracking-tight flex items-center gap-2">
                                <i class="fa-solid fa-images text-[#3da9fc]"></i>
                                Galeri Kamar
                            </h3>
                            <div class="flex items-center gap-2">
                                <button type="button" id="prevBtn"
                                    class="w-8 h-8 rounded-full bg-[#fffffe] border border-[#90b4ce] text-[#094067] hover:bg-[#3da9fc] hover:text-[#fffffe] transition-all shadow-sm disabled:opacity-30"
                                    onclick="scrollGaleri(-1)">
                                    <i class="fa-solid fa-chevron-left text-xs"></i>
                                </button>
                                <button type="button" id="nextBtn"
                                    class="w-8 h-8 rounded-full bg-[#fffffe] border border-[#90b4ce] text-[#094067] hover:bg-[#3da9fc] hover:text-[#fffffe] transition-all shadow-sm disabled:opacity-30"
                                    onclick="scrollGaleri(1)">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>

                                <script>
                                    function scrollGaleri(direction) {
                                        const container = document.getElementById('galeriContainer');
                                        if (!container) return;

                                        const scrollAmount = 200;
                                        container.scrollBy({
                                            left: direction * scrollAmount,
                                            behavior: 'smooth'
                                        });
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="relative">
                            <div id="galeriContainer" class="flex overflow-x-auto snap-x snap-mandatory scrollbar-hide gap-4 pb-4">
                                @foreach ($kamar->galeri as $gambar)
                                    <div class="flex-shrink-0 w-48 snap-start">
                                        <div
                                            class="group aspect-square bg-[#90b4ce]/10 rounded-xl overflow-hidden border border-[#90b4ce]/40 shadow-sm transition-all hover:border-[#3da9fc] hover:shadow-md">
                                            <img src="{{ asset('storage/' . $gambar->foto) }}" alt="Foto {{ $loop->index + 1 }}"
                                                class="w-full h-full object-cover cursor-zoom-in transition-transform duration-500 group-hover:scale-110"
                                                onclick="openZoomModal('{{ asset('storage/' . $gambar->foto) }}')">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div id="zoomModal" class="fixed inset-0 z-[999] hidden flex-col items-center justify-center p-4 md:p-10" role="dialog" aria-modal="true">

                            <div class="fixed inset-0 bg-[#094067]/95 backdrop-blur-md" onclick="closeZoomModal()"></div>

                            <div class="relative z-[1000] max-w-5xl w-full h-full flex items-center justify-center">
                                <button onclick="closeZoomModal()" class="absolute top-10 right-0 md:-right-12 text-white hover:text-blue-400 transition-colors text-4xl">
                                    &times;
                                </button>
                                <img id="zoomedImage" src="" class="max-w-full max-h-full object-contain rounded-xl shadow-2xl">
                            </div>
                        </div>
                        <script>
                            function openZoomModal(imageSrc) {
                                const modal = document.getElementById('zoomModal');
                                const zoomedImg = document.getElementById('zoomedImage');

                                // Set sumber gambar
                                zoomedImg.src = imageSrc;

                                // Tampilkan modal
                                modal.classList.remove('hidden');
                                modal.classList.add('flex');

                                // Kunci scroll body
                                document.body.style.overflow = 'hidden';
                            }

                            function closeZoomModal() {
                                const modal = document.getElementById('zoomModal');

                                // Sembunyikan modal
                                modal.classList.add('hidden');
                                modal.classList.remove('flex');

                                // Kembalikan scroll body
                                document.body.style.overflow = 'auto';
                            }

                            // Menutup modal dengan tombol ESC
                            document.addEventListener('keydown', function(e) {
                                if (e.key === "Escape") {
                                    closeZoomModal();
                                }
                            });
                        </script>

                    </div>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <div class="mb-10">
                        <span class="inline-block px-3 py-1 bg-[#90b4ce20] text-[#3da9fc] rounded-full text-xs font-black uppercase tracking-widest mb-3">
                            {{ $kamar->tipe }}
                        </span>
                        <h1 class="text-4xl font-black mb-2 tracking-tight">{{ $kamar->kode_kamar }}</h1>
                        <p class="text-[#5f6c7b] font-medium">Kamar eksklusif dengan desain modern dan fasilitas lengkap</p>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-12">
                        <div class="glass-card rounded-2xl p-6 text-center border-b-4 border-b-[#3da9fc]">
                            <div class="text-2xl font-black text-[#3da9fc] mb-1">{{ $kamar->lebar }} m²</div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#90b4ce]">Luas Ruangan</div>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center border-b-4 border-b-[#3da9fc]">
                            <div class="text-2xl font-black text-[#3da9fc] mb-1">
                                Rp{{ $kamar->harga >= 1000000 ? number_format($kamar->harga / 1000000, 1, ',', '.') . 'jt' : number_format($kamar->harga / 1000, 0, ',', '.') . 'K' }}
                            </div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#90b4ce]">Per Bulan</div>
                        </div>
                        <div class="glass-card rounded-2xl p-6 text-center border-b-4 border-b-[#3da9fc]">
                            <div class="text-2xl font-black text-[#3da9fc] mb-1">✓</div>
                            <div class="text-[10px] font-black uppercase tracking-widest text-[#90b4ce]">Tersedia</div>
                        </div>
                    </div>

                    <section class="mb-12">
                        <h2 class="text-2xl font-black mb-4 uppercase tracking-tight">Tentang Kamar Ini</h2>
                        <p class="text-[#5f6c7b] leading-relaxed font-medium">
                            {{ $kamar->deskripsi }}
                        </p>
                    </section>

                    <div class="section-divider mb-12"></div>

                    <section class="mb-12">
                        <h2 class="text-2xl font-black mb-6 uppercase tracking-tight">Keunggulan Kamar</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-[#5f6c7b] leading-relaxed font-medium">Desain Modern & Elegan</h3>
                                    <p class="text-sm text-neutral-600">Dilengkapi dengan interior terkini dan aesthetic
                                        yang menawan</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-[#5f6c7b] leading-relaxed font-medium">Privasi Terjamin</h3>
                                    <p class="text-sm text-neutral-600">Lokasi strategis dengan akses mudah ke berbagai
                                        fasilitas utama</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-[#5f6c7b] leading-relaxed font-medium">Fasilitas Lengkap</h3>
                                    <p class="text-sm text-neutral-600">Semua kebutuhan Anda tersedia dengan standar premium
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="text-[#5f6c7b] leading-relaxed font-medium">Harga Kompetitif</h3>
                                    <p class="text-sm text-neutral-600">Kualitas terbaik dengan harga yang terjangkau dan
                                        fleksibel</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-black mb-6 uppercase tracking-tight">Spesifikasi Kamar</h2>
                        <div class="glass-card rounded-2xl p-8 space-y-4">
                            <div class="flex justify-between py-3 border-b border-[#90b4ce20]">
                                <span class="text-[#5f6c7b] font-bold uppercase text-xs tracking-widest">Tipe Kamar</span>
                                <span class="text-[#094067] font-black">{{ $kamar->tipe }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-[#90b4ce20]">
                                <span class="text-[#5f6c7b] font-bold uppercase text-xs tracking-widest">Kode Kamar</span>
                                <span class="text-[#094067] font-black">{{ $kamar->kode_kamar }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="text-[#5f6c7b] font-bold uppercase text-xs tracking-widest">Harga Per Bulan</span>
                                <span class="text-[#3da9fc] font-black text-xl">Rp{{ number_format($kamar->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-black mb-6 uppercase tracking-tight">Fasilitas Kamar</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($kamar->detailKamar as $item)
                                <div class="glass-card rounded-xl p-4 flex items-center gap-3 hover:border-[#3da9fc] transition-smooth group">
                                    <div class="w-10 h-10 rounded-lg bg-[#3da9fc10] flex items-center justify-center text-[#3da9fc] group-hover:bg-[#3da9fc] group-hover:text-[#fffffe] transition-all">
                                        <i class="fa-solid fa-check-circle"></i>
                                    </div>
                                    <span class="text-sm font-bold text-[#094067]">{{ $item->fasilitas }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <section class="mb-12">
                        <h2 class="text-2xl font-black mb-6 uppercase tracking-tight">Peraturan & Kebijakan Khusus</h2>
                        <div class="space-y-4">
                            @php
                                $kebijakan = [
                                    [
                                        'title' => 'Hewan Peliharaan',
                                        'description' => 'Hewan peliharaan tidak diperbolehkan di kamar ini untuk menjaga kebersihan dan kenyamanan tamu lainnya.',
                                    ],
                                    [
                                        'title' => 'Penggunaan Fasilitas',
                                        'description' => 'Semua tamu wajib menjaga kebersihan dan kelestarian fasilitas kamar. Kerusakan yang disengaja akan dikenakan biaya tambahan.',
                                    ],
                                    [
                                        'title' => 'Kebijakan Pembatalan',
                                        'description' => 'Pembatalan gratis hingga 48 jam sebelum check-in. Pembatalan di bawah 48 jam akan dikenakan biaya 50% dari total pemesanan.',
                                    ],
                                    [
                                        'title' => 'Kesunyian',
                                        'description' => 'Harap menjaga kesunyian kamar terutama setelah pukul 22:00 untuk menghormati tamu lain. Suara yang mengganggu akan ditegur.',
                                    ],
                                ];
                            @endphp
                            @foreach ($kebijakan as $item)
                                <div class="glass-card rounded-xl p-5 border-l-4 border-l-[#3da9fc]">
                                    <h3 class="font-black text-[#094067] uppercase text-sm tracking-widest mb-2">{{ $item['title'] }}</h3>
                                    <p class="text-sm text-[#5f6c7b] font-medium">{{ $item['description'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                </div>

                <div class="lg:col-span-1 sticky top-25 h-max">
                    <div class="glass-card rounded-[2rem] p-8 sticky top-8 border-2 border-[#09406710] shadow-2xl shadow-[#09406705]">
                        <div class="mb-8 pb-8 border-b border-[#90b4ce20]">
                            <p class="text-[10px] font-black text-[#90b4ce] uppercase tracking-[0.2em] mb-2">Total Harga</p>
                            <p class="text-4xl font-black text-[#3da9fc] mb-1">
                                Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-[#5f6c7b] font-medium">Sudah termasuk biaya maintenance</p>
                        </div>

                        <div class="mb-8">
                            @auth
                                @php $user = auth()->user(); @endphp
                                @if ($user->id_kamar || $user->role == 'admin')
                                    <button class="w-full bg-[#90b4ce] text-[#fffffe] font-black uppercase tracking-widest px-6 py-4 rounded-2xl cursor-not-allowed opacity-60">
                                        Pesan Sekarang
                                    </button>
                                    <p class="text-center mt-3 text-[#ef4565] text-[10px] font-bold uppercase tracking-widest">
                                        {{ $user->role == 'admin' ? 'Akses Admin Terdeteksi' : 'Anda Sudah Memiliki Kamar' }}
                                    </p>
                                @else
                                    <a href="{{ route('user.pembayaran.booking', $kamar->id) }}">
                                        <button
                                            class="w-full bg-[#3da9fc] text-[#fffffe] font-black uppercase tracking-widest px-6 py-4 rounded-2xl border-b-4 border-[#094067] hover:brightness-110 active:border-b-0 active:translate-y-1 transition-all shadow-xl shadow-[#3da9fc30]">
                                            Pesan Sekarang
                                        </button>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('user.pembayaran.booking', $kamar->id) }}">
                                    <button
                                        class="w-full bg-[#3da9fc] text-[#fffffe] font-black uppercase tracking-widest px-6 py-4 rounded-2xl border-b-4 border-[#094067] hover:brightness-110 active:border-b-0 active:translate-y-1 transition-all shadow-xl shadow-[#3da9fc30]">
                                        Pesan Sekarang
                                    </button>
                                </a>
                            @endauth
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-3 text-[#5f6c7b]">
                                <i class="fas fa-shield-alt text-[#3da9fc]"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Pembayaran Aman</span>
                            </div>
                            <div class="flex items-center gap-3 text-[#5f6c7b]">
                                <i class="fas fa-bolt text-[#3da9fc]"></i>
                                <span class="text-xs font-bold uppercase tracking-wider">Konfirmasi Instan</span>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-[#90b4ce20]">
                            <div class="bg-[#3da9fc05] rounded-xl p-4 border border-[#3da9fc10]">
                                <p class="text-[10px] text-[#5f6c7b] leading-relaxed font-bold uppercase tracking-wider">
                                    <span class="text-[#3da9fc]">Butuh bantuan?</span> CS kami siap melayani Anda 24/7 melalui WhatsApp.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
