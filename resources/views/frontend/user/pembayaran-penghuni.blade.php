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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-18" x-data="paymentApp()" x-cloak>
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

                    <!-- State: Menunggu Data Transaksi -->
                    <div x-show="!transaksi && !submitting">
                        <div class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-file-invoice-dollar text-4xl mb-3 text-gray-400"></i>
                            <p class="font-medium">Mengambil data tagihan Anda...</p>
                            <p class="text-sm mt-1">Mohon tunggu sebentar.</p>
                        </div>
                    </div>

                    <!-- State: Loading -->
                    <div x-show="submitting" class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-600 mb-4"></div>
                        <p class="text-gray-600">Mempersiapkan pembayaran...</p>
                        <p class="text-sm text-gray-500 mt-1">Mohon jangan tutup halaman ini.</p>
                    </div>

                    <!-- State: Error -->
                    <div x-show="errorMessage" class="mt-4 bg-red-100 text-red-700 p-3 rounded-lg text-sm" x-text="errorMessage"></div>

                    <!-- State: Transaksi Siap Dibayar -->
                    <div x-show="transaksi">
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Kode Transaksi</span>
                                <span class="font-mono font-medium text-indigo-700" x-text="transaksi.kode"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Kamar</span>
                                <span class="font-semibold" x-text="transaksi.kamar_kode"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Periode</span>
                                <span class="font-semibold" x-text="transaksi.periode"></span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Jatuh Tempo</span>
                                <span class="font-semibold text-rose-600" x-text="transaksi.tanggal_jatuhtempo"></span>
                            </div>
                            <div class="border-t border-gray-200 pt-2 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total Tagihan:</span>
                                    <span class="text-2xl font-bold text-blue-600" x-text="'Rp ' + transaksi.total_bayar.toLocaleString('id-ID')"></span>
                                </div>
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

                        <button type="button" @click="bayarSekarang()"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-200 shadow-soft hover:shadow-lg transform hover:-translate-y-0.5">
                            Bayar Sekarang
                        </button>
                    </div>

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
        function paymentApp() {
            return {
                submitting: false,
                transaksi: null,
                errorMessage: null,

                async init() {
                    this.submitting = true;
                    try {
                        const response = await fetch('{{ route('penghuni.pembayaran.data') }}', {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            credentials: 'include'
                        });

                        const data = await response.json();

                        if (data.success && data.transaksi) {
                            this.transaksi = {
                                ...data.transaksi,
                                total_bayar: parseInt(data.transaksi.total_bayar),
                                tanggal_jatuhtempo: new Date(data.transaksi.tanggal_jatuhtempo).toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long',
                                    year: 'numeric'
                                }),
                                periode: data.transaksi.periode_mulai + ' – ' + data.transaksi.periode_akhir
                            };
                        } else {
                            this.errorMessage = data.message || 'Tidak ada tagihan jatuh tempo.';
                        }
                    } catch (error) {
                        console.error('Fetch error:', error);
                        this.errorMessage = 'Gagal memuat data tagihan. Coba segarkan halaman.';
                    } finally {
                        this.submitting = false;
                    }
                },

                bayarSekarang() {
                    if (!this.transaksi?.snap_token) {
                        this.preparePayment();
                        return;
                    }

                    this.openMidtrans();
                },

                async preparePayment() {
                    this.submitting = true;
                    try {
                        const response = await fetch('{{ route('penghuni.pembayaran.bayar') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            credentials: 'include'
                        });

                        const data = await response.json();

                        if (data.success && data.snap_token) {
                            this.transaksi.snap_token = data.snap_token;
                            this.openMidtrans();
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

                openMidtrans() {
                    snap.pay(this.transaksi.snap_token, {
                        onSuccess: (result) => {
                            this.showNotification('success', 'Pembayaran berhasil! Mengalihkan...');
                            setTimeout(() => window.location.href = "{{ route('pembayaran.invoice', ['id' => ':id']) }}".replace(':id', this.transaksi.id), 3000);
                        },
                        onPending: (result) => {
                            this.showNotification('info', 'Menunggu konfirmasi pembayaran...');
                            setTimeout(() => window.location.href = "{{ route('dashboard-penghuni') }}", 3000);
                        },
                        onError: (result) => {
                            this.showNotification('error', 'Pembayaran gagal: ' + (result.status_message || 'Coba lagi.'));
                        },
                        onClose: () => {
                            this.showNotification('warning', 'Pembayaran dibatalkan.');
                        }
                    });
                },

                showNotification(type, message) {
                    const notification = document.createElement('div');
                    notification.className = `fixed top-4 right-4 z-50 rounded-xl p-4 text-white shadow-lg transform transition-all duration-300 ${type === 'success' ? 'bg-emerald-500' :
                        type === 'error' ? 'bg-rose-500' :
                        type === 'warning' ? 'bg-amber-500' : 'bg-blue-500'}`;
                    const icon = type === 'success' ? 'fa-check-circle' :
                        type === 'error' ? 'fa-exclamation-circle' :
                        type === 'warning' ? 'fa-exclamation-triangle' : 'fa-info-circle';
                    notification.innerHTML = `<div class="flex items-center gap-3"><i class="fa-solid ${icon} text-lg"></i><span class="font-medium">${message}</span></div>`;
                    document.body.appendChild(notification);
                    setTimeout(() => notification.remove(), 5000);
                }
            };
        }

        // Jalankan inisialisasi saat Alpine siap
        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentApp', paymentApp);
        });

        // Jalankan init setelah komponen dimuat
        document.addEventListener('alpine:initialized', () => {
            // Tidak perlu karena init dipanggil otomatis di x-init jika ditambahkan
        });
    </script>

    {{-- Tambahkan x-init untuk memanggil init --}}
    <script>
        // Modifikasi: tambahkan x-init di root element via Alpine
        // Tapi karena kita tidak bisa edit x-data langsung di blade, kita tambahkan event listener
        document.addEventListener('DOMContentLoaded', () => {
            // Alpine akan otomatis menjalankan jika kita tambahkan x-init
            // Jadi kita inject x-init ke root element
            const root = document.querySelector('[x-cloak]');
            if (root && !root.hasAttribute('x-init')) {
                root.setAttribute('x-init', 'init()');
            }
        });
    </script>
@endsection
