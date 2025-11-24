@extends('layouts.frontend-main')
@section('title', 'Selesaikan Transaksi Anda')

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

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .shadow-soft {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-18" x-data="{ duration: 1, harga: 1500000 }">
        <div class="max-w-6xl mx-auto mb-2 py-0">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ Route('landing-page') }}" class="text-neutral-600 hover:text-primary transition-smooth">Home</a>
                <span class="text-neutral-300">/</span>
                <a href="{{ Route('booking') }}" class="text-neutral-600 hover:text-primary transition-smooth">Kamar</a>
                <span class="text-neutral-300">/</span>
                <span class="text-blue-600 font-medium">Pembayaran Kos</span>
            </nav>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Payment Form -->
            <div class="space-y-6">
                <!-- Payment Card -->
                <div class="bg-white rounded-2xl shadow-soft p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Form Pembayaran</h2>

                    <div x-data="{ duration: 1, harga: {{ (int) $kamar->harga }} }">

                        <!-- Duration Selection -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Durasi Pembayaran</label>
                            <div class="grid grid-cols-3 gap-3">
                                <button @click="duration = 1" :class="duration === 1 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:border-blue-600'"
                                    class="border-2 rounded-xl py-4 px-4 text-center transition-all duration-200 font-medium">
                                    <div class="text-lg font-semibold">1 Bulan</div>
                                    <div class="text-sm opacity-80" x-text="'Rp ' + (harga * 1).toLocaleString('id-ID')"></div>
                                </button>
                                <button @click="duration = 3" :class="duration === 3 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:border-blue-600'"
                                    class="border-2 rounded-xl py-4 px-4 text-center transition-all duration-200 font-medium">
                                    <div class="text-lg font-semibold">3 Bulan</div>
                                    <div class="text-sm opacity-80" x-text="'Rp ' + (harga * 3).toLocaleString('id-ID')"></div>
                                </button>
                                <button @click="duration = 6" :class="duration === 6 ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:border-blue-600'"
                                    class="border-2 rounded-xl py-4 px-4 text-center transition-all duration-200 font-medium">
                                    <div class="text-lg font-semibold">6 Bulan</div>
                                    <div class="text-sm opacity-80" x-text="'Rp ' + (harga * 6).toLocaleString('id-ID')"></div>
                                </button>
                            </div>
                        </div>

                        <!-- Price Calculation -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Harga per bulan:</span>
                                <span class="font-semibold" x-text="'Rp ' + harga.toLocaleString('id-ID')"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Durasi:</span>
                                <span class="font-semibold" x-text="duration + ' Bulan'"></span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Pembayaran:</span>
                                    <span class="text-2xl font-bold text-blue-600" x-text="'Rp ' + (harga * duration).toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- User Data -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Data Penyewa</label>
                        <div class="space-y-3">
                            <div>
                                <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                <p class="text-xs text-gray-500 mt-1">Nama Penyewa</p>
                            </div>
                            <div>
                                <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                <p class="text-xs text-gray-500 mt-1">Email aktif untuk konfirmasi</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-soft hover:shadow-lg transform hover:-translate-y-0.5">
                        Lanjutkan ke Pembayaran
                    </button>

                    <p class="text-center text-sm text-gray-500 mt-4">
                        Dengan melanjutkan, Anda menyetujui Syarat & Ketentuan yang berlaku
                    </p>
                </div>

                <!-- Security Info -->
                <div class="bg-white rounded-2xl shadow-soft p-6">
                    <div class="flex items-center justify-center space-x-6 text-gray-600">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                            <span class="text-sm">Pembayaran Aman</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                            <span class="text-sm">Data Terlindungi</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Room Details -->
            <div class="space-y-6">
                <!-- Room Card -->
                <div class="glass-card rounded-2xl shadow-soft p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Detail Kamar</h3>
                        <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded-full">Tersedia</span>
                    </div>

                    <!-- Room Image -->
                    <div class="rounded-xl overflow-hidden mb-4">
                        <img src="{{ Storage::url($kamar->gambar) }}" alt="Kamar Kos" class="w-full h-48 object-cover">
                    </div>

                    <!-- Room Info -->
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-gray-600">Tipe Kamar</span>
                            <span class="font-semibold">{{ $kamar->tipe }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-gray-600">Kode Kamar</span>
                            <span class="font-semibold">{{ $kamar->kode_kamar }}</span>
                        </div>
                        <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                            <span class="text-gray-600">Harga per Bulan</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                        </div>
                        @if ($kamar->detailKamar)
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Fasilitas</span>
                                <div class="flex space-x-2">
                                    @foreach ($kamar->detailKamar->take(3) as $detail)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $detail->fasilitas }}</span>
                                    @endforeach
                                    @if ($kamar->detailKamar->count() > 3)
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            +{{ $kamar->detailKamar->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
