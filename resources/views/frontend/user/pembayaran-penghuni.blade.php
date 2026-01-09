@extends('layouts.frontend-main')

@section('title', 'Bayar Tagihan Jatuh Tempo')

@section('frontend-main')
    <div class="min-h-screen bg-slate-50/50 pb-12" x-data="paymentApp({{ json_encode($transaksiPending) }}, {{ old('durasi') ? old('durasi') : 'null' }})" x-cloak>

        <div class="bg-white border-b border-slate-200 mt-25 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                        <i class="fa-solid fa-arrow-left text-slate-600"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Pembayaran Tagihan</h1>
                        <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 uppercase tracking-wider">
                            <a href="{{ route('dashboard-penghuni') }}" class="hover:text-indigo-600">Dashboard</a>
                            <i class="fa-solid fa-chevron-right text-[8px]"></i>
                            <span class="text-indigo-600 font-bold">Bayar Tagihan</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-7 space-y-6">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Formulir Pembayaran</h3>
                            <i class="fa-solid fa-credit-card text-slate-400"></i>
                        </div>

                        <div class="p-6">
                            @if (!$dataTransaksi && !$transaksiPending)
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fa-solid fa-calendar-check text-2xl text-slate-400"></i>
                                    </div>
                                    <h4 class="text-lg font-bold text-slate-900">Semua Tagihan Lunas</h4>
                                    <p class="text-sm text-slate-500 mt-1">{{ $message ?? 'Tidak ada tagihan yang perlu dibayar saat ini.' }}</p>
                                </div>
                            @else
                                @if ($dataTransaksi)
                                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5 mb-8">
                                        <div class="grid grid-cols-2 gap-y-3 text-sm">
                                            <span class="text-slate-500 font-medium">Kode Transaksi</span>
                                            <span class="text-right font-mono font-bold text-indigo-600">{{ $dataTransaksi['kode'] }}</span>

                                            <span class="text-slate-500 font-medium">Periode</span>
                                            <span class="text-right font-semibold text-slate-900">{{ $dataTransaksi['periode_mulai'] }} – {{ $dataTransaksi['periode_akhir'] }}</span>

                                            <span class="text-slate-500 font-medium">Jatuh Tempo</span>
                                            <span class="text-right font-bold text-red-500">{{ \Carbon\Carbon::parse($dataTransaksi['tanggal_jatuhtempo'])->translatedFormat('d M Y') }}</span>

                                            <div class="col-span-2 border-t border-slate-200 mt-2 pt-3 flex justify-between items-center">
                                                <span class="text-slate-900 font-bold">Total Tagihan</span>
                                                <span class="text-xl font-black text-slate-900">Rp {{ number_format($dataTransaksi['total_bayar'], 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!$transaksiPending)
                                    <form method="POST" action="{{ route('penghuni.pembayaran.buat-transaksi') }}" @submit="submitting = true" class="space-y-6">
                                        @csrf
                                        <div class="space-y-3">
                                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Pilih Durasi Pembayaran</label>
                                            <div class="grid grid-cols-3 gap-3">
                                                <template x-for="d in [1, 3, 6]">
                                                    <button type="button" @click="durasi = d; $el.form.durasi.value = d"
                                                        :class="durasi === d ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-100' :
                                                            'bg-white border-slate-200 text-slate-600 hover:border-indigo-300 hover:bg-slate-50'"
                                                        class="py-3.5 rounded-xl border-2 font-bold text-sm transition-all flex flex-col items-center">
                                                        <span x-text="d"></span>
                                                        <span class="text-[10px] uppercase opacity-80">Bulan</span>
                                                    </button>
                                                </template>
                                                <input type="hidden" name="durasi" :value="durasi" />
                                            </div>
                                            @error('durasi')
                                                <p class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Nama Penyewa</label>
                                                <input type="text" value="{{ auth()->user()->name }}" readonly
                                                    class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-500 outline-none">
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Email</label>
                                                <input type="text" value="{{ auth()->user()->email }}" readonly
                                                    class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-500 outline-none">
                                            </div>
                                        </div>

                                        <button type="submit" :disabled="!durasi || submitting"
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-indigo-100 disabled:opacity-50 flex items-center justify-center gap-2">
                                            <span x-show="!submitting">Buat Pesanan Pembayaran</span>
                                            <i x-show="submitting" class="fa-solid fa-circle-notch animate-spin"></i>
                                            <span x-show="submitting">Memproses...</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="space-y-6">
                                        <div class="flex items-start gap-4 p-4 bg-amber-50 border border-amber-100 rounded-2xl">
                                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-amber-600 shadow-sm flex-shrink-0">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-amber-800 uppercase tracking-wider">Transaksi Tertunda</p>
                                                <p class="text-sm text-amber-700 mt-0.5">Selesaikan pembayaran untuk invoice <strong class="font-mono">{{ $transaksiPending->kode }}</strong> sebelum
                                                    melanjutkan.</p>
                                            </div>
                                        </div>

                                        <button type="button" @click="lanjutkanPembayaran()" :disabled="submitting"
                                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-emerald-100 flex items-center justify-center gap-2">
                                            <span x-show="!submitting">Lanjutkan ke Pembayaran Snap</span>
                                            <i x-show="submitting" class="fa-solid fa-circle-notch animate-spin"></i>
                                        </button>
                                    </div>
                                @endif
                            @endif

                            <div x-show="errorMessage" x-transition class="mt-4 p-4 bg-red-50 border border-red-100 rounded-xl text-red-600 text-xs font-bold uppercase tracking-wider text-center"
                                x-text="errorMessage"></div>
                            @if (session('success'))
                                <div class="mt-4 p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-600 text-xs font-bold uppercase tracking-wider text-center">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>

                        <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 text-center">
                            <p class="text-[10px] text-slate-400 font-medium italic">
                                Aman & Terenkripsi oleh Midtrans Payment Gateway
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-6">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Informasi Kamar</h3>
                            <i class="fa-solid fa-door-open text-slate-400"></i>
                        </div>

                        @if (auth()->user()->kamar)
                            <div class="relative h-48">
                                <img src="{{ Storage::url(auth()->user()->kamar->gambar) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <div class="absolute bottom-4 left-6">
                                    <span class="bg-indigo-600 text-white text-[10px] font-bold px-2 py-1 rounded uppercase">{{ auth()->user()->kamar->tipe }}</span>
                                    <h4 class="text-white font-bold text-lg leading-tight">{{ auth()->user()->kamar->kode_kamar }}</h4>
                                </div>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-500 font-medium">Harga Sewa</span>
                                    <span class="font-bold text-indigo-600">Rp {{ number_format(auth()->user()->kamar->harga, 0, ',', '.') }} / bln</span>
                                </div>

                                @if (auth()->user()->kamar->detailKamar)
                                    <div class="pt-4 border-t border-slate-50">
                                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">Fasilitas Utama</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach (auth()->user()->kamar->detailKamar->take(4) as $detail)
                                                <span class="bg-slate-100 text-slate-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">
                                                    {{ $detail->fasilitas }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <p class="text-sm text-slate-400 italic font-medium">Data kamar tidak ditemukan.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-indigo-900 rounded-2xl p-6 text-white shadow-lg shadow-indigo-100">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 bg-indigo-800 rounded-xl flex items-center justify-center">
                                <i class="fa-solid fa-shield-halved text-indigo-300"></i>
                            </div>
                            <h4 class="font-bold text-sm uppercase tracking-wider text-indigo-100">Jaminan Keamanan</h4>
                        </div>
                        <ul class="space-y-3 text-xs text-indigo-200/80 font-medium">
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                Enkripsi SSL 256-bit
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                Verifikasi Otomatis 24/7
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-400"></i>
                                Tanpa Biaya Admin Tersembunyi
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        function paymentApp(initialTransaksiPending, initialDurasi = null) {
            return {
                submitting: false,
                transaksiPending: initialTransaksiPending,
                errorMessage: null,
                durasi: initialDurasi,

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
                            this.openMidtrans(data.snap_token);
                        } else {
                            this.errorMessage = data.message || 'Gagal menyiapkan pembayaran.';
                        }
                    } catch (error) {
                        this.errorMessage = 'Terjadi kesalahan sistem.';
                    } finally {
                        this.submitting = false;
                    }
                },

                openMidtrans(token) {
                    snap.pay(token, {
                        onSuccess: (result) => {
                            window.location.href = "{{ route('user.pembayaran.verifikasi-data') }}";
                        },
                        onPending: (result) => {
                            window.location.href = "{{ route('penghuni.pembayaran') }}";
                        },
                        onError: (result) => {
                            window.location.href = "{{ route('dashboard-penghuni') }}";
                        },
                        onClose: () => {
                            this.submitting = false;
                        }
                    });
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('paymentApp', paymentApp);
        });
    </script>
@endsection
