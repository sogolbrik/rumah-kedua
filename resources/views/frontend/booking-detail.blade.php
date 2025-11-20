@extends('layouts.frontend-main')
@section('title', 'Detail Kamar - ' . $kamar->tipe)

@section('frontend-main')
    <style>
        :root {
            --color-primary: #2563eb;
            --color-primary-light: #3b82f6;
            --color-primary-dark: #1e40af;
            --color-accent: #0891b2;
            --color-neutral-50: #f9fafb;
            --color-neutral-100: #f3f4f6;
            --color-neutral-200: #e5e7eb;
            --color-neutral-600: #4b5563;
            --color-neutral-900: #111827;
            --color-success: #10b981;
        }

        body {
            scroll-behavior: smooth;
            background-color: var(--color-neutral-50);
        }

        .transition-smooth {
            transition: all 0.3s ease;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(37, 99, 235, 0.2), transparent);
        }
    </style>

    <!-- Main Container -->
    <div class="min-h-screen py-15 px-4 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Breadcrumb Navigation -->
            <nav class="mb-8 flex items-center gap-2 text-sm">
                <a href="{{ Route('landing-page') }}" class="text-neutral-600 hover:text-primary transition-smooth">Home</a>
                <span class="text-neutral-300">/</span>
                <a href="{{ Route('booking') }}" class="text-neutral-600 hover:text-primary transition-smooth">Kamar</a>
                <span class="text-neutral-300">/</span>
                <span class="text-primary font-semibold">{{ $kamar->tipe }}</span>
            </nav>

            <!-- Hero Section: Image Gallery -->
            <div class="mb-12" x-data="{ activeTab: 0, isZoomed: false }">
                <!-- Main Image with Zoom -->
                <div class="relative rounded-2xl overflow-hidden shadow-lg mb-4 bg-neutral-200 transition-smooth" @click="isZoomed = true">
                    <img :src="isZoomed ? '{{ Storage::url($kamar->gambar) }}' : '{{ Storage::url($kamar->gambar) }}'" alt="{{ $kamar->tipe }}"
                        class="w-full h-96 sm:h-[500px] object-cover cursor-zoom-in transition-smooth hover:scale-105" x-show="!isZoomed">

                    <!-- Zoom Modal -->
                    <div class="fixed inset-0 bg-black/95 z-50 flex items-center justify-center p-4 cursor-zoom-out" @click="isZoomed = false" x-show="isZoomed" x-transition.opacity>
                        <img src="{{ Storage::url($kamar->gambar) }}" alt="{{ $kamar->tipe }}" class="max-w-4xl max-h-screen object-contain">
                        <button class="absolute top-4 right-4 text-white text-4xl font-light hover:opacity-70 transition-smooth">&times;</button>
                    </div>

                    <!-- Badge Status -->
                    <div class="absolute top-4 left-4 flex items-center gap-2">
                        <span class="px-4 py-2 bg-success/90 text-white rounded-full text-xs font-semibold backdrop-blur-sm">
                            ✓ Tersedia
                        </span>
                    </div>
                </div>

                <!-- Thumbnail Gallery -->
                @if ($kamar->galeri && count($kamar->galeri) > 0)
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                        @foreach ($kamar->galeri as $index => $gambar)
                            <button @click="activeTab = {{ $index }}" class="relative rounded-lg overflow-hidden border-2 transition-smooth group"
                                :class="activeTab === {{ $index }} ? 'border-primary' :
                                    'border-neutral-200 hover:border-primary'">
                                <img src="{{ $gambar }}" alt="Gallery" class="w-full h-20 object-cover group-hover:scale-110 transition-smooth">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Content -->
                <div class="lg:col-span-2">
                    <!-- Room Header -->
                    <div class="mb-10">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <span class="inline-block px-3 py-1 bg-primary/10 text-primary rounded-full text-xs font-semibold mb-3">
                                    {{ $kamar->tipe }}
                                </span>
                                <h1 class="text-4xl font-bold text-neutral-900 mb-2">
                                    {{ $kamar->kode_kamar }}
                                </h1>
                                <p class="text-neutral-600">Kamar eksklusif dengan desain modern dan fasilitas lengkap</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Info Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-12">
                        <div class="glass-card rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-primary mb-1">{{ $kamar->lebar }} m²</div>
                            <div class="text-xs text-neutral-600">Luas Ruangan</div>
                        </div>
                        <div class="glass-card rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-primary mb-1">
                                Rp{{ $kamar->harga >= 1000000 ? number_format($kamar->harga / 1000000, 1, ',', '.') . 'jt' : number_format($kamar->harga / 1000, 0, ',', '.') . 'K' }}
                            </div>
                            <div class="text-xs text-neutral-600">Per Bulan</div>
                        </div>
                        <div class="glass-card rounded-xl p-4 text-center">
                            <div class="text-2xl font-bold text-primary mb-1">✓</div>
                            <div class="text-xs text-neutral-600">Tersedia</div>
                        </div>
                    </div>

                    <!-- Added new comprehensive sections -->
                    <!-- Deskripsi Kamar -->
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-4">Tentang Kamar Ini</h2>
                        <p class="text-neutral-600 leading-relaxed">
                            {{ $kamar->deskripsi }}
                        </p>
                    </section>

                    <div class="section-divider mb-12"></div>

                    <!-- Keunggulan Section -->
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6">Keunggulan Kamar</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="flex items-start gap-3">
                                <svg class="w-6 h-6 text-primary flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                <div>
                                    <h3 class="font-semibold text-neutral-900">Desain Modern & Elegan</h3>
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
                                    <h3 class="font-semibold text-neutral-900">Privasi Terjamin</h3>
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
                                    <h3 class="font-semibold text-neutral-900">Fasilitas Lengkap</h3>
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
                                    <h3 class="font-semibold text-neutral-900">Harga Kompetitif</h3>
                                    <p class="text-sm text-neutral-600">Kualitas terbaik dengan harga yang terjangkau dan
                                        fleksibel</p>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="section-divider mb-12"></div>

                    <!-- Spesifikasi Kamar Section -->
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6">Spesifikasi Kamar</h2>
                        <div class="glass-card rounded-xl p-6 space-y-4">
                            <div class="flex justify-between py-3 border-b border-neutral-200">
                                <span class="text-neutral-600 font-medium">Tipe Kamar</span>
                                <span class="text-neutral-900 font-semibold">{{ $kamar->tipe }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-neutral-200">
                                <span class="text-neutral-600 font-medium">Kode Kamar</span>
                                <span class="text-neutral-900 font-semibold">{{ $kamar->kode_kamar }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-neutral-200">
                                <span class="text-neutral-600 font-medium">Luas Ruangan</span>
                                <span class="text-neutral-900 font-semibold">{{ $kamar->lebar }} m²</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-neutral-200">
                                <span class="text-neutral-600 font-medium">Harga Per Bulan</span>
                                <span class="text-primary font-bold text-lg">Rp{{ number_format($kamar->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="text-neutral-600 font-medium">Status</span>
                                <span class="px-3 py-1 bg-success/10 text-success rounded-full text-xs font-semibold">Tersedia</span>
                            </div>
                        </div>
                    </section>

                    <div class="section-divider mb-12"></div>

                    <!-- Seluruh Fasilitas Kamar Section -->
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6">Seluruh Fasilitas Kamar</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach ($kamar->detailKamar as $item)
                                <div class="glass-card rounded-lg p-4 flex items-center gap-3 hover:shadow-md transition-smooth">
                                    <div class="flex-shrink-0">
                                        @switch($item->fasilitas)
                                            @case('Kasur & Bantal')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9v12h18V9a3 3 0 00-3-3H6a3 3 0 00-3 3zm9 3H6m12 0h-6m-6 4h12" />
                                                </svg>
                                            @break

                                            @case('Lemari')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 6h16v8a2 2 0 01-2 2H6a2 2 0 01-2-2v-8z" />
                                                </svg>
                                            @break

                                            @case('Meja dan Kursi')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9h18v2H3V9zm2 4h2v6H5v-6zm12 0h2v6h-2v-6zM7 9v6m10-6v6" />
                                                </svg>
                                            @break

                                            @case('K. Mandi Dalam')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18h14V3H5zm2 2h10v2H7V5zm0 4h10v8H7V9z" />
                                                </svg>
                                            @break

                                            @case('Kaca')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v8m-4-4h8" />
                                                </svg>
                                            @break

                                            @case('TV')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            @break

                                            @case('Dapur Pribadi')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18M5 6v12M19 6v12" />
                                                </svg>
                                            @break

                                            @case('WI-FI')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M5.636 9.636a9 9 0 0112.728 0" />
                                                </svg>
                                            @break

                                            @case('Tempat Sampah')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            @break

                                            @case('Listrik')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                            @break

                                            @case('Jendela dan Tirai')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 22V12h6v10" />
                                                </svg>
                                            @break

                                            @case('Stopkontak')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 18v-3m0 0v-3m0 3H9m3 0h3M6 12h12a2 2 0 002-2V8a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                                                </svg>
                                            @break

                                            @case('Rak Sepatu')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M3 12h18M3 18h18M5 6v12M19 6v12" />
                                                </svg>
                                            @break

                                            @case('AC')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 3v2m0 14v2M3 12h2m14 0h2M5.64 5.64l1.42 1.42m9.9 9.9l1.42 1.42M5.64 18.36l1.42-1.42m9.9-9.9l1.42-1.42" />
                                                </svg>
                                            @break

                                            @case('Kipas Angin')
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 3v2m0 14v2M3 12h2m14 0h2M5.64 5.64l1.42 1.42m9.9 9.9l1.42 1.42M5.64 18.36l1.42-1.42m9.9-9.9l1.42-1.42" />
                                                </svg>
                                            @break

                                            @default
                                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                        @endswitch
                                    </div>
                                    <span class="text-sm font-medium text-neutral-900">{{ $item->fasilitas }}</span>
                                </div>
                            @endforeach
                        </div>
                    </section>

                    <div class="section-divider mb-12"></div>

                    <!-- Peraturan Khusus Section -->
                    <section class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6">Peraturan & Kebijakan Khusus</h2>
                        <div class="space-y-4">
                            <div class="glass-card rounded-lg p-4 border-l-4 border-primary">
                                <h3 class="font-semibold text-neutral-900 mb-2">Jam Check-In & Check-Out</h3>
                                <p class="text-sm text-neutral-600">Check-in mulai pukul 14:00 dan check-out maksimal pukul
                                    12:00. Early check-in atau late check-out dapat diatur sesuai ketersediaan.</p>
                            </div>
                            <div class="glass-card rounded-lg p-4 border-l-4 border-accent">
                                <h3 class="font-semibold text-neutral-900 mb-2">Hewan Peliharaan</h3>
                                <p class="text-sm text-neutral-600">Hewan peliharaan tidak diperbolehkan di kamar ini untuk
                                    menjaga kebersihan dan kenyamanan tamu lainnya.</p>
                            </div>
                            <div class="glass-card rounded-lg p-4 border-l-4 border-primary">
                                <h3 class="font-semibold text-neutral-900 mb-2">Penggunaan Fasilitas</h3>
                                <p class="text-sm text-neutral-600">Semua tamu wajib menjaga kebersihan dan kelestarian
                                    fasilitas kamar. Kerusakan yang disengaja akan dikenakan biaya tambahan.</p>
                            </div>
                            <div class="glass-card rounded-lg p-4 border-l-4 border-accent">
                                <h3 class="font-semibold text-neutral-900 mb-2">Kebijakan Pembatalan</h3>
                                <p class="text-sm text-neutral-600">Pembatalan gratis hingga 48 jam sebelum check-in.
                                    Pembatalan di bawah 48 jam akan dikenakan biaya 50% dari total pemesanan.</p>
                            </div>
                            <div class="glass-card rounded-lg p-4 border-l-4 border-primary">
                                <h3 class="font-semibold text-neutral-900 mb-2">Kesunyian</h3>
                                <p class="text-sm text-neutral-600">Harap menjaga kesunyian kamar terutama setelah pukul
                                    22:00 untuk menghormati tamu lain. Suara yang mengganggu akan ditegur.</p>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Sidebar Info -->
                <div class="lg:col-span-1 sticky top-20 h-max">
                    <div class="glass-card rounded-2xl p-8 sticky top-8">
                        <!-- Price Card -->
                        <div class="mb-8 pb-8 border-b border-neutral-200">
                            <p class="text-sm text-neutral-600 mb-2 font-medium">HARGA PER BULAN</p>
                            <p class="text-4xl font-bold text-primary mb-1">
                                Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-neutral-500">Termasuk pajak</p>
                        </div>

                        <div class="mb-8 pb-8 border-b border-neutral-200">
                            @if (auth()->check())
                                <a href="{{ route('pembayaran', $kamar->id) }}">
                                    <button
                                        class="cursor-pointer w-full flex items-center justify-center gap-2 
                                    bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg
                                    border-blue-600 border-b-[4px]
                                    transition-all
                                    hover:brightness-110 hover:-translate-y-[2px] hover:border-b-[6px]
                                    active:border-b-[2px] active:brightness-90 active:translate-y-[2px] shadow-md">

                                        <!-- Icon Key -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        Pesan Sekarang
                                    </button>
                                </a>
                            @else
                                <a href="{{ Route('login') }}">
                                    <button
                                        class="cursor-pointer w-full flex items-center justify-center gap-2 
                                bg-blue-500 text-white font-semibold px-6 py-3 rounded-lg
                                border-blue-600 border-b-[4px]
                                transition-all
                                hover:brightness-110 hover:-translate-y-[2px] hover:border-b-[6px]
                                active:border-b-[2px] active:brightness-90 active:translate-y-[2px] shadow-md">

                                        <!-- Icon Key -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        Pesan Sekarang
                                    </button>
                                </a>
                            @endif
                        </div>

                        <!-- Quick Facts -->
                        <div class="space-y-4">
                            <div>
                                <p class="text-xs text-neutral-500 uppercase font-semibold mb-1">Luas Kamar</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $kamar->lebar }} m²</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500 uppercase font-semibold mb-1">Tipe Kamar</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $kamar->tipe }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-neutral-500 uppercase font-semibold mb-1">Nomor Kamar</p>
                                <p class="text-lg font-semibold text-neutral-900">{{ $kamar->kode_kamar }}</p>
                            </div>
                        </div>

                        <!-- Info Box -->
                        <div class="mt-8 pt-8 border-t border-neutral-200">
                            <div class="bg-primary/5 rounded-lg p-4">
                                <p class="text-xs text-neutral-600 leading-relaxed">
                                    <span class="font-semibold text-primary">Informasi Penting:</span> Untuk pertanyaan
                                    lebih lanjut atau kebutuhan khusus, silakan hubungi tim customer service kami yang
                                    siap membantu 24/7.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
