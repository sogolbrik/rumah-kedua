@extends('layouts.frontend-main')
@section('title', 'Bayar Tagihan Jatuh Tempo')

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

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-18" x-data="paymentApp({{ json_encode($transaksiPending) }}, {{ old('durasi') ? old('durasi') : 'null' }})" x-cloak>
        <div class="max-w-6xl mx-auto mb-2 py-0">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('dashboard-penghuni') }}" class="text-neutral-600 hover:text-primary transition-smooth">Dashboard</a>
                <span class="text-neutral-300">/</span>
                <span class="text-blue-600 font-medium">Bayar Tagihan</span>
            </nav>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-soft p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Bayar Tagihan Jatuh Tempo</h2>

                    <!-- State: Tidak Ada Tagihan Jatuh Tempo -->
                    @if (!$dataTransaksi && !$transaksiPending)
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-file-invoice-dollar text-4xl mb-3 text-gray-400"></i>
                            <p class="font-medium">{{ $message ?? 'Tidak ada tagihan jatuh tempo.' }}</p>
                        </div>
                    @else
                        <!-- State: Transaksi Siap Dibayar (Data ditampilkan langsung oleh Blade) -->
                        @if ($dataTransaksi)
                            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Kode Transaksi</span>
                                    <span class="font-mono font-medium text-indigo-700">{{ $dataTransaksi['kode'] }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Kamar</span>
                                    <span class="font-semibold">{{ $dataTransaksi['kamar_kode'] }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Periode</span>
                                    <span class="font-semibold">{{ $dataTransaksi['periode_mulai'] }} – {{ $dataTransaksi['periode_akhir'] }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Jatuh Tempo</span>
                                    <span class="font-semibold text-rose-600">{{ \Carbon\Carbon::parse($dataTransaksi['tanggal_jatuhtempo'])->format('d M Y') }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-2 mt-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-lg font-bold text-gray-900">Total Tagihan:</span>
                                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($dataTransaksi['total_bayar'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form untuk memilih durasi dan membuat transaksi -->
                        @if (!$transaksiPending)
                            <form method="POST" action="{{ route('penghuni.pembayaran.buat-transaksi') }}" @submit="submitting = true">
                                @csrf
                                <!-- Pilihan Durasi -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Durasi Pembayaran (Bulan)</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <button type="button" @click="durasi = 1; $el.form.durasi.value = 1"
                                            :class="{ 'bg-blue-600 text-white': durasi === 1, 'bg-gray-200 text-gray-700 hover:bg-gray-300': durasi !== 1 }"
                                            class="py-3 rounded-xl font-medium transition-colors">
                                            1 Bulan
                                        </button>
                                        <button type="button" @click="durasi = 3; $el.form.durasi.value = 3"
                                            :class="{ 'bg-blue-600 text-white': durasi === 3, 'bg-gray-200 text-gray-700 hover:bg-gray-300': durasi !== 3 }"
                                            class="py-3 rounded-xl font-medium transition-colors">
                                            3 Bulan
                                        </button>
                                        <button type="button" @click="durasi = 6; $el.form.durasi.value = 6"
                                            :class="{ 'bg-blue-600 text-white': durasi === 6, 'bg-gray-200 text-gray-700 hover:bg-gray-300': durasi !== 6 }"
                                            class="py-3 rounded-xl font-medium transition-colors">
                                            6 Bulan
                                        </button>
                                        <!-- Input tersembunyi untuk mengirim nilai durasi -->
                                        <input type="hidden" name="durasi" value="{{ old('durasi') }}" />
                                    </div>
                                    @error('durasi')
                                        <div class="mt-4 mb-2 bg-red-100 text-red-700 p-3 rounded-lg text-sm">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- User Data -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Data Penyewa</label>
                                    <div class="space-y-3">
                                        <div>
                                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                        </div>
                                        <div>
                                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                                class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="!durasi || submitting"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-soft hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Bayar Sekarang
                                </button>
                            </form>
                        @else
                            <!-- Jika ada transaksi pending, tampilkan tombol Lanjutkan Pembayaran -->
                            <div class="mb-6">
                                <div class="bg-blue-50 text-blue-800 p-3 rounded-lg text-sm">
                                    <i class="fa-solid fa-info-circle mr-2"></i>
                                    <span>Transaksi <strong>{{ $transaksiPending->kode }}</strong> sedang menunggu pembayaran.</span>
                                </div>
                            </div>

                            <!-- User Data -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data Penyewa</label>
                                <div class="space-y-3">
                                    <div>
                                        <input type="text" value="{{ auth()->user()->name }}" readonly
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                    </div>
                                    <div>
                                        <input type="email" value="{{ auth()->user()->email }}" readonly
                                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 text-gray-600 focus:outline-none">
                                    </div>
                                </div>
                            </div>

                            <button type="button" @click="lanjutkanPembayaran()" :disabled="submitting"
                                class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-soft hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed">
                                Lanjutkan Pembayaran
                            </button>
                        @endif
                    @endif

                    <!-- State: Loading -->
                    <div x-show="submitting" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600 mb-4"></div>
                        <p class="text-gray-600">Mempersiapkan pembayaran...</p>
                        <p class="text-sm text-gray-500 mt-1">Mohon jangan tutup halaman ini.</p>
                    </div>

                    <!-- State: Error -->
                    <div x-show="errorMessage" class="mt-4 mb-2 bg-red-100 text-red-700 p-3 rounded-lg text-sm" x-text="errorMessage"></div>

                    <!-- State: Success Message (from Laravel Session) -->
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" class="mt-4 mb-2 bg-green-100 text-green-700 p-3 rounded-lg text-sm">
                            <div class="flex justify-between items-center">
                                <span>{{ session('success') }}</span>
                                <button @click="show = false" class="text-green-800 hover:text-green-900">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <p class="text-center text-sm text-gray-500 mt-4">
                        Pembayaran akan diproses melalui Midtrans. Data Anda aman dan terenkripsi.
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

            <!-- Right Column - Room & Bill Details -->
            <div class="space-y-6">
                <div class="glass-card rounded-2xl shadow-soft p-6 border border-white/50">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Detail Tagihan</h3>
                        <span class="bg-rose-100 text-rose-800 text-sm font-medium px-3 py-1 rounded-full">Jatuh Tempo</span>
                    </div>

                    @if (auth()->user()->kamar)
                        <div class="rounded-xl overflow-hidden mb-4">
                            <img src="{{ Storage::url(auth()->user()->kamar->gambar) }}" alt="Kamar Anda" class="w-full h-48 object-cover">
                        </div>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                                <span class="text-gray-600">Kode Kamar</span>
                                <span class="font-semibold">{{ auth()->user()->kamar->kode_kamar }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                                <span class="text-gray-600">Tipe</span>
                                <span class="font-semibold">{{ auth()->user()->kamar->tipe }}</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-gray-200">
                                <span class="text-gray-600">Harga/Bulan</span>
                                <span class="text-lg font-bold text-blue-600">Rp {{ number_format(auth()->user()->kamar->harga, 0, ',', '.') }}</span>
                            </div>
                            @if (auth()->user()->kamar->detailKamar)
                                <div class="flex justify-between items-start">
                                    <span class="text-gray-600">Fasilitas</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach (auth()->user()->kamar->detailKamar->take(3) as $detail)
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $detail->fasilitas }}</span>
                                        @endforeach
                                        @if (auth()->user()->kamar->detailKamar->count() > 3)
                                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                                +{{ auth()->user()->kamar->detailKamar->count() - 3 }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-500 italic">Tidak ada kamar aktif.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        function paymentApp(initialTransaksiPending, initialDurasi = null) {
            return {
                submitting: false,
                transaksiPending: initialTransaksiPending, // Gunakan data dari Blade
                errorMessage: null,
                durasi: initialDurasi,

                pilihDurasi(d) {
                    this.durasi = d;
                    const hiddenInput = document.querySelector('input[name="durasi"]');
                    if (hiddenInput) hiddenInput.value = d;
                },

                async lanjutkanPembayaran() {
                    if (!this.transaksiPending) return;

                    this.submitting = true;
                    this.errorMessage = null;

                    try {
                        const response = await fetch('{{ route('penghuni.pembayaran.siapkan-pembayaran') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await response.json();

                        if (data.success && data.snap_token) {
                            this.openMidtrans(data.snap_token, data.transaksi_id);
                        } else {
                            this.errorMessage = data.message || 'Gagal menyiapkan pembayaran.';
                        }
                    } catch (error) {
                        console.error('Payment prep error:', error);
                        this.errorMessage = 'Terjadi kesalahan saat menyiapkan pembayaran.';
                    } finally {
                        this.submitting = false;
                    }
                },

                openMidtrans(token, transaksiId) {
                    snap.pay(token, {
                        onSuccess: (result) => {
                            // Verifikasi setelah sukses
                            window.location.href = "{{ route('penghuni.pembayaran') }}?verify_payment=1&status=success";
                        },
                        onPending: (result) => {
                            // Kembali ke halaman pembayaran untuk pantau status
                            window.location.href = "{{ route('penghuni.pembayaran') }}";
                        },
                        onError: (result) => {
                            window.location.href = "{{ route('dashboard-penghuni') }}";
                        },
                        onClose: () => {
                            window.location.href = "{{ route('penghuni.pembayaran') }}";
                        }
                    });
                },
            };
        }

        // Jalankan inisialisasi saat Alpine siap
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentApp', paymentApp);
        });
    </script>

    <script>
        // Tambahkan x-init untuk memanggil init
        document.addEventListener('DOMContentLoaded', () => {
            const root = document.querySelector('[x-cloak]');
            if (root && !root.hasAttribute('x-init')) {
                root.setAttribute('x-init', 'init()');
            }
        });
    </script>
@endsection
