@extends('layouts.frontend-main')
@section('title', 'Selesaikan Transaksi Anda')

@section('frontend-main')
    <style>
        :root {
            /* Elements Palette */
            --bg-color: #fffffe;
            --headline-color: #094067;
            --paragraph-color: #5f6c7b;
            --button-color: #3da9fc;
            --button-text-color: #fffffe;

            /* Illustration Palette */
            --stroke-color: #094067;
            --highlight-color: #3da9fc;
            --secondary-color: #90b4ce;
            --tertiary-color: #ef4565;
        }

        body {
            background-color: var(--bg-color);
            color: var(--paragraph-color);
            scroll-behavior: smooth;
        }

        .glass-card {
            background: #ffffff;
            border: 1px solid rgba(144, 180, 206, 0.3);
            box-shadow: 0 4px 20px rgba(9, 64, 103, 0.05);
        }

        .duration-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #eef2f6;
        }

        .duration-card.active {
            border-color: var(--button-color);
            background-color: rgba(61, 169, 252, 0.05);
            transform: translateY(-2px);
        }

        .text-headline {
            color: var(--headline-color);
        }

        .text-paragraph {
            color: var(--paragraph-color);
        }

        .bg-primary-custom {
            background-color: var(--button-color);
        }

        .border-secondary-custom {
            border-color: var(--secondary-color);
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    <div class="min-h-screen py-12 mt-16" x-data="paymentApp({{ (int) $kamar->harga }}, {{ old('durasi', 1) }})" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <nav class="flex items-center gap-2 text-sm mb-4">
                    <a href="{{ Route('landing-page') }}" class="hover:text-[--highlight-color] transition-colors" style="color: var(--paragraph-color)">Home</a>
                    <svg class="w-4 h-4" style="color: var(--secondary-color)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2" />
                    </svg>
                    <a href="{{ Route('booking') }}" class="hover:text-[--highlight-color] transition-colors" style="color: var(--paragraph-color)">Kamar</a>
                    <svg class="w-4 h-4" style="color: var(--secondary-color)" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7" stroke-width="2" />
                    </svg>
                    <span style="color: var(--highlight-color)" class="font-bold uppercase tracking-wider text-xs">Pembayaran</span>
                </nav>
                <h1 class="text-3xl font-black tracking-tight" style="color: var(--headline-color)">Selesaikan Pembayaran</h1>
                <p class="mt-2" style="color: var(--paragraph-color)">Satu langkah lagi untuk mengamankan kamar impian Anda.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">

                    <div class="glass-card rounded-3xl p-8">
                        @if ($transaksiPending)
                            <div class="rounded-2xl p-6 mb-8" style="background-color: rgba(144, 180, 206, 0.1); border: 1px solid var(--secondary-color)">
                                <div class="flex items-start gap-4">
                                    <div class="p-2 rounded-lg" style="background-color: var(--secondary-color); color: var(--bg-color)">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold" style="color: var(--headline-color)">Transaksi Menunggu Pembayaran</h3>
                                        <p class="text-sm mt-1" style="color: var(--paragraph-color)">Anda memiliki transaksi yang belum selesai. Segera lakukan pembayaran sebelum masa berlaku habis.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex justify-between py-3 border-b border-dashed" style="border-color: var(--secondary-color)">
                                    <span style="color: var(--paragraph-color)" class="font-medium uppercase text-xs tracking-widest">Durasi Sewa</span>
                                    <span class="font-black" style="color: var(--headline-color)">{{ $transaksiPending->durasi }} Bulan</span>
                                </div>
                                <div class="flex justify-between items-center py-3">
                                    <span class="font-bold text-lg" style="color: var(--headline-color)">Total Tagihan</span>
                                    <span class="text-3xl font-black" style="color: var(--highlight-color)">Rp {{ number_format($transaksiPending->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button @click="lanjutkanPembayaran()" :disabled="isProcessing"
                                class="w-full text-white font-black uppercase tracking-widest py-4 px-6 rounded-2xl transition-all shadow-xl active:translate-y-1"
                                style="background-color: var(--button-color); border-bottom: 4px solid var(--stroke-color)">
                                <span x-show="!isProcessing">Bayar Sekarang</span>
                                <div x-show="isProcessing" class="animate-spin rounded-full h-5 w-5 border-2 border-white border-t-transparent mx-auto"></div>
                            </button>
                        @else
                            <form method="POST" action="{{ route('user.pembayaran.buat-transaksi') }}" @submit="submitting = true">
                                @csrf
                                <input type="hidden" name="id_kamar" value="{{ $kamar->id }}">

                                <div class="mb-10">
                                    <label class="block text-xs font-black uppercase tracking-[0.2em] mb-4" style="color: var(--secondary-color)">Pilih Durasi Sewa</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        @foreach ([1, 3, 6] as $bulan)
                                            <button type="button" @click="pilihDurasi({{ $bulan }})" :class="durasi === {{ $bulan }} ? 'active' : ''"
                                                class="duration-card rounded-2xl p-5 text-left bg-white relative overflow-hidden group">
                                                <div class="relative z-10">
                                                    <div class="text-xs font-bold uppercase tracking-wider mb-1" :class="durasi === {{ $bulan }} ? 'text-[--highlight-color]' : 'text-gray-400'">
                                                        Paket {{ $bulan }} Bulan</div>
                                                    <div class="text-xl font-black" style="color: var(--headline-color)">Rp {{ number_format($kamar->harga * $bulan, 0, ',', '.') }}</div>
                                                </div>
                                                <div x-show="durasi === {{ $bulan }}" class="absolute top-2 right-2">
                                                    <svg class="w-6 h-6" style="color: var(--highlight-color)" fill="currentColor" viewBox="0 0 20 20">
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
                                    <label class="block text-xs font-black uppercase tracking-[0.2em] mb-4" style="color: var(--secondary-color)">Informasi Penyewa</label>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="text-[10px] font-black uppercase absolute left-4 top-2" style="color: var(--secondary-color)">Nama Lengkap</label>
                                            <input type="text" value="{{ auth()->user()->name }}" readonly
                                                class="w-full bg-[#f8f9fa] border border-[#eef2f6] rounded-xl px-4 pt-7 pb-2 font-bold focus:outline-none" style="color: var(--headline-color)">
                                        </div>
                                        <div class="relative">
                                            <label class="text-[10px] font-black uppercase absolute left-4 top-2" style="color: var(--secondary-color)">Email</label>
                                            <input type="email" value="{{ auth()->user()->email }}" readonly
                                                class="w-full bg-[#f8f9fa] border border-[#eef2f6] rounded-xl px-4 pt-7 pb-2 font-bold focus:outline-none" style="color: var(--headline-color)">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" :disabled="submitting"
                                    class="w-full text-white font-black uppercase tracking-widest py-4 px-6 rounded-2xl transition-all shadow-xl active:translate-y-1 group flex items-center justify-center gap-3"
                                    style="background-color: var(--button-color); border-bottom: 4px solid var(--stroke-color)">
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
                        <div class="flex items-center gap-3 p-4 glass-card rounded-2xl">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(61, 169, 252, 0.1); color: var(--highlight-color)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-wider" style="color: var(--headline-color)">Pembayaran Terenkripsi</span>
                        </div>
                        <div class="flex items-center gap-3 p-4 glass-card rounded-2xl">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: rgba(144, 180, 206, 0.1); color: var(--secondary-color)">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <span class="text-xs font-black uppercase tracking-wider" style="color: var(--headline-color)">Konfirmasi Instan</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="sticky top-28 space-y-6">
                        <div class="glass-card rounded-[2rem] overflow-hidden border-2" style="border-color: rgba(144, 180, 206, 0.2)">
                            <div class="p-6 border-b" style="border-color: rgba(144, 180, 206, 0.2)">
                                <h3 class="text-lg font-black uppercase tracking-tighter" style="color: var(--headline-color)">Ringkasan Pesanan</h3>
                            </div>

                            <div class="p-6">
                                <div class="flex gap-4 mb-6">
                                    <img src="{{ Storage::url($kamar->gambar) }}" class="w-20 h-20 rounded-2xl object-cover border-2" style="border-color: var(--secondary-color)" alt="Kamar">
                                    <div>
                                        <span class="text-[10px] font-black uppercase tracking-widest" style="color: var(--highlight-color)">{{ $kamar->tipe }}</span>
                                        <h4 class="font-black leading-tight text-lg" style="color: var(--headline-color)">{{ $kamar->kode_kamar }}</h4>
                                        <p class="text-xs font-medium" style="color: var(--paragraph-color)">Mojokerto, Jawa Timur</p>
                                    </div>
                                </div>

                                <div class="space-y-3 py-4 border-y border-dashed" style="border-color: var(--secondary-color)">
                                    <div class="flex justify-between text-sm">
                                        <span style="color: var(--paragraph-color)">Harga per Bulan</span>
                                        <span class="font-bold" style="color: var(--headline-color)">Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span style="color: var(--paragraph-color)">Biaya Layanan</span>
                                        <span class="font-black uppercase text-[10px] tracking-widest" style="color: var(--highlight-color)">Gratis</span>
                                    </div>
                                </div>

                                <div class="pt-6">
                                    <p class="text-[10px] font-black uppercase tracking-[0.2em] mb-1" style="color: var(--secondary-color)">Total Estimasi</p>
                                    <div class="flex justify-between items-end">
                                        <p class="text-3xl font-black" style="color: var(--headline-color)" x-text="formatRupiah(totalHarga)"></p>
                                        <p class="text-sm font-black" style="color: var(--highlight-color)" x-text="durasi + ' Bln'"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6" style="background-color: rgba(144, 180, 206, 0.05)">
                                <h4 class="text-[10px] font-black uppercase tracking-[0.2em] mb-3" style="color: var(--secondary-color)">Fasilitas Utama</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($kamar->detailKamar->take(4) as $detail)
                                        <span class="bg-white border text-[9px] px-2 py-1 rounded-lg font-black uppercase tracking-wider"
                                            style="border-color: var(--secondary-color); color: var(--paragraph-color)">
                                            {{ $detail->fasilitas }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div x-show="errorMessage" x-transition class="border-l-4 p-4 rounded-2xl text-sm flex gap-3"
                            style="background-color: rgba(239, 69, 101, 0.1); border-color: var(--tertiary-color); color: var(--tertiary-color)">
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="font-bold" x-text="errorMessage"></span>
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
