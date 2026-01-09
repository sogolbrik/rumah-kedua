@extends('layouts.frontend-main')
@section('title', 'Selesaikan Transaksi Anda')

@section('frontend-main')
    <style>
        :root {
            --color-primary: #2563eb;
            --color-primary-soft: #eff6ff;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(229, 231, 235, 0.5);
        }

        .duration-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .duration-card.active {
            border-color: var(--color-primary);
            background-color: var(--color-primary-soft);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen bg-gray-50/50 py-12 mt-16" x-data="paymentApp({{ (int) $kamar->harga }}, {{ old('durasi', 1) }})" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <nav class="flex items-center gap-2 text-sm text-gray-500 mb-4">
                    <a href="{{ Route('landing-page') }}" class="hover:text-blue-600 transition-colors">Home</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                    <a href="{{ Route('booking') }}" class="hover:text-blue-600 transition-colors">Kamar</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" />
                    </svg>
                    <span class="text-blue-600 font-medium">Pembayaran</span>
                </nav>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Selesaikan Pembayaran</h1>
                <p class="mt-2 text-gray-600">Satu langkah lagi untuk mengamankan kamar impian Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">

                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                        @if ($transaksiPending)
                            <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 mb-8">
                                <div class="flex items-start gap-4">
                                    <div class="p-2 bg-amber-100 rounded-lg">
                                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-amber-900">Transaksi Menunggu Pembayaran</h3>
                                        <p class="text-amber-700 text-sm mt-1">Anda memiliki transaksi yang belum selesai. Segera lakukan pembayaran sebelum masa berlaku habis.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between py-3 border-b border-gray-50">
                                    <span class="text-gray-600">Durasi Sewa</span>
                                    <span class="font-bold text-gray-900">{{ $transaksiPending->durasi }} Bulan</span>
                                </div>
                                <div class="flex justify-between items-center py-3">
                                    <span class="text-gray-900 font-medium text-lg">Total Tagihan</span>
                                    <span class="text-3xl font-black text-blue-600">Rp {{ number_format($transaksiPending->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button @click="lanjutkanPembayaran()" :disabled="isProcessing"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl transition-all shadow-lg shadow-blue-200 flex items-center justify-center gap-3">
                                <span x-show="!isProcessing">Bayar Sekarang</span>
                                <div x-show="isProcessing" class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                            </button>
                        @else
                            <form method="POST" action="{{ route('user.pembayaran.buat-transaksi') }}" @submit="submitting = true">
                                @csrf
                                <input type="hidden" name="id_kamar" value="{{ $kamar->id }}">

                                <div class="mb-10">
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Pilih Durasi Sewa</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach ([1, 3, 6] as $bulan)
                                            <button type="button" @click="pilihDurasi({{ $bulan }})"
                                                :class="durasi === {{ $bulan }} ? 'active ring-2 ring-blue-600 ring-offset-2' : 'border-gray-200 hover:border-blue-300'"
                                                class="duration-card border-2 rounded-2xl p-5 text-left bg-white relative overflow-hidden group">
                                                <div class="relative z-10">
                                                    <div class="text-sm font-medium" :class="durasi === {{ $bulan }} ? 'text-blue-600' : 'text-gray-500'">Paket {{ $bulan }} Bulan</div>
                                                    <div class="text-xl font-bold mt-1 text-gray-900">Rp {{ number_format($kamar->harga * $bulan, 0, ',', '.') }}</div>
                                                </div>
                                                <div x-show="durasi === {{ $bulan }}" class="absolute top-2 right-2">
                                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        @endforeach
                                        <input type="hidden" name="durasi" :value="durasi" />
                                    </div>
                                </div>

                                <div class="mb-10">
                                    <label class="block text-sm font-bold text-gray-700 uppercase tracking-wider mb-4">Informasi Penyewa</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="text-xs font-semibold text-gray-400 absolute left-4 top-2">Nama Lengkap</label>
                                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 pt-7 pb-2 text-gray-700 font-medium focus:outline-none">
                                        </div>
                                        <div class="relative">
                                            <label class="text-xs font-semibold text-gray-400 absolute left-4 top-2">Email</label>
                                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                                class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 pt-7 pb-2 text-gray-700 font-medium focus:outline-none">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="submitting"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-6 rounded-2xl transition-all shadow-lg shadow-blue-200 disabled:opacity-50 flex items-center justify-center gap-3 group">
                                    <span x-show="!submitting">Lanjutkan ke Pembayaran</span>
                                    <svg x-show="!submitting" class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                    <div x-show="submitting" class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent"></div>
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-gray-100">
                            <div class="w-10 h-10 bg-green-50 rounded-full flex items-center justify-center text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Pembayaran Terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 bg-white rounded-2xl border border-gray-100">
                            <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Konfirmasi Instan</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-28 space-y-6">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                            <div class="p-6 border-b border-gray-50">
                                <h3 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h3>
                            </div>

                            <div class="p-6">
                                <div class="flex gap-4 mb-6">
                                    <img src="{{ Storage::url($kamar->gambar) }}" class="w-24 h-24 rounded-2xl object-cover shadow-sm" alt="Kamar">
                                    <div>
                                        <span class="text-xs font-bold text-blue-600 uppercase tracking-tighter">{{ $kamar->tipe }}</span>
                                        <h4 class="font-bold text-gray-900 leading-tight mb-1">{{ $kamar->kode_kamar }}</h4>
                                        <p class="text-sm text-gray-500">Mojokerto, Jawa Timur</p>
                                    </div>
                                </div>

                                <div class="space-y-3 py-4 border-y border-dashed border-gray-200">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Harga per Bulan</span>
                                        <span class="font-semibold text-gray-900">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-500">Biaya Layanan</span>
                                        <span class="font-semibold text-green-600">Gratis</span>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <div class="flex justify-between items-end">
                                        <div>
                                            <p class="text-xs font-bold text-gray-400 uppercase">Total Estimasi</p>
                                            <p class="text-2xl font-black text-gray-900" x-text="formatRupiah(totalHarga)"></p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-bold text-blue-600" x-text="durasi + ' Bulan'"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6">
                                <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Fasilitas Utama</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($kamar->detailKamar->take(4) as $detail)
                                        <span class="bg-white border border-gray-200 text-gray-600 text-[10px] px-2 py-1 rounded-lg font-bold">{{ $detail->fasilitas }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div x-show="errorMessage" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2"
                            class="bg-red-50 border border-red-100 text-red-700 p-4 rounded-2xl text-sm flex gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span x-text="errorMessage"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        function paymentApp(harga, initialDurasi = 1) {
            return {
                harga: harga,
                durasi: initialDurasi,
                submitting: false,
                errorMessage: null,
                isProcessing: false,

                pilihDurasi(value) {
                    this.durasi = value;
                    this.errorMessage = null;
                },

                async lanjutkanPembayaran() {
                    if (this.isProcessing) return;

                    this.isProcessing = true;
                    this.errorMessage = null;

                    try {
                        const response = await fetch('{{ route('user.pembayaran.siapkan-pembayaran') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        const data = await response.json();

                        if (data.success && data.snap_token) {
                            this.bayarSekarang(data.snap_token);
                        } else {
                            this.errorMessage = data.message || 'Gagal menyiapkan pembayaran.';
                            this.isProcessing = false;
                        }
                    } catch (error) {
                        this.errorMessage = 'Terjadi kesalahan koneksi. Silakan coba lagi.';
                        this.isProcessing = false;
                    }
                },

                bayarSekarang(snapToken) {
                    if (typeof snap === 'undefined') {
                        this.errorMessage = 'Payment gateway error. Mohon refresh halaman.';
                        this.isProcessing = false;
                        return;
                    }

                    snap.pay(snapToken, {
                        onSuccess: (result) => {
                            window.location.href = "{{ route('user.pembayaran.verifikasi-data') }}";
                        },
                        onPending: (result) => {
                            window.location.href = "{{ route('user.pembayaran.booking', ['id' => $kamar->id]) }}?status=pending";
                        },
                        onError: (result) => {
                            this.errorMessage = 'Pembayaran gagal. Silakan coba lagi.';
                            this.isProcessing = false;
                        },
                        onClose: () => {
                            this.isProcessing = false;
                            this.submitting = false;
                        }
                    });
                },

                get totalHarga() {
                    return this.harga * this.durasi;
                },

                formatRupiah(amount) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(amount);
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentApp', paymentApp);
        });
    </script>
@endsection
