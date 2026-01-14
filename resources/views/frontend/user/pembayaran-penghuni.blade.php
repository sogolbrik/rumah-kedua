@extends('layouts.frontend-main')

@section('title', 'Bayar Tagihan Jatuh Tempo')

@section('frontend-main')
    <div class="min-h-screen bg-[#fffffe] pb-12" x-data="paymentApp({{ json_encode($transaksiPending) }}, {{ old('durasi') ? old('durasi') : 'null' }})" x-cloak>

        <div class="relative bg-[#094067] pt-32 pb-20 overflow-hidden">
            <div class="absolute top-0 right-0 -translate-y-12 translate-x-12 w-64 h-64 bg-[#3da9fc] opacity-10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 translate-y-12 -translate-x-12 w-96 h-96 bg-[#90b4ce] opacity-10 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="flex items-start gap-5">
                        <a href="{{ route('dashboard-penghuni') }}" class="mt-1 p-3 bg-white/10 hover:bg-white/20 rounded-2xl transition-all border border-white/10 backdrop-blur-sm group">
                            <i class="fa-solid fa-arrow-left text-[#fffffe] group-hover:-translate-x-1 transition-transform"></i>
                        </a>
                        <div>
                            <nav class="flex items-center gap-2 text-xs font-bold text-[#90b4ce] uppercase tracking-[0.2em] mb-2">
                                <a href="{{ route('dashboard-penghuni') }}" class="hover:text-[#3da9fc]">Workspace</a>
                                <i class="fa-solid fa-chevron-right text-[8px] opacity-50"></i>
                                <span class="text-[#fffffe]">Bill Payment</span>
                            </nav>
                            <h1 class="text-4xl font-black text-[#fffffe] tracking-tight">Tagihan <span class="text-[#3da9fc]">Sewa</span></h1>
                        </div>
                    </div>
                    <div class="hidden md:block text-right">
                        <p class="text-[#90b4ce] text-sm font-medium mb-1 uppercase tracking-widest">Status Akun</p>
                        <span class="px-4 py-1.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-full text-xs font-bold">Terverifikasi</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 relative z-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-7 space-y-8">
                    <div class="bg-white rounded-[2.5rem] border border-[#90b4ce]/20 shadow-[0_20px_50px_rgba(9,64,103,0.05)] overflow-hidden">
                        <div class="px-8 py-6 border-b border-[#90b4ce]/10 flex justify-between items-center bg-[#fffffe]">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-[#3da9fc]/10 rounded-xl flex items-center justify-center text-[#3da9fc]">
                                    <i class="fa-solid fa-file-invoice-dollar"></i>
                                </div>
                                <h3 class="font-bold text-[#094067] uppercase tracking-wider text-sm">Rincian Pembayaran</h3>
                            </div>
                            <span class="text-[10px] font-black text-[#90b4ce] uppercase">Secure 256-bit</span>
                        </div>

                        <div class="p-8">
                            @if (!$dataTransaksi && !$transaksiPending)
                                <div class="text-center py-16">
                                    <div class="w-24 h-24 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-6 ring-8 ring-emerald-50/50">
                                        <i class="fa-solid fa-check-double text-3xl text-emerald-500"></i>
                                    </div>
                                    <h4 class="text-xl font-bold text-[#094067]">Luar Biasa!</h4>
                                    <p class="text-[#5f6c7b] mt-2">{{ $message ?? 'Semua tagihan Anda telah lunas terbayar.' }}</p>
                                </div>
                            @else
                                @if ($dataTransaksi)
                                    <div class="relative overflow-hidden bg-gradient-to-br from-[#094067] to-[#0b5387] rounded-3xl p-8 mb-10 text-white shadow-xl shadow-blue-900/10">
                                        <div class="absolute top-0 right-0 opacity-10 translate-x-1/4 -translate-y-1/4">
                                            <i class="fa-solid fa-wallet text-[150px]"></i>
                                        </div>
                                        <div class="relative z-10">
                                            <div class="flex justify-between items-start mb-8">
                                                <div>
                                                    <p class="text-[#90b4ce] text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Nomor Tagihan</p>
                                                    <h2 class="text-xl font-mono font-bold">{{ $dataTransaksi['kode'] }}</h2>
                                                </div>
                                                <div class="text-right">
                                                    <p class="text-[#90b4ce] text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Jatuh Tempo</p>
                                                    <span class="px-3 py-1 bg-[#ef4565] text-white rounded-lg text-[10px] font-black italic">
                                                        {{ \Carbon\Carbon::parse($dataTransaksi['tanggal_jatuhtempo'])->translatedFormat('d M Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                                                <div>
                                                    <p class="text-[#90b4ce] text-xs mb-1 font-medium italic">Total yang harus dibayar</p>
                                                    <div class="text-4xl font-black">Rp {{ number_format($dataTransaksi['total_bayar'], 0, ',', '.') }}</div>
                                                </div>
                                                <div class="text-sm font-medium text-[#90b4ce] border-l-2 border-[#3da9fc] pl-4">
                                                    Periode: {{ $dataTransaksi['periode_mulai'] }} <br> s/d {{ $dataTransaksi['periode_akhir'] }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (!$transaksiPending)
                                    <form method="POST" action="{{ route('penghuni.pembayaran.buat-transaksi') }}" @submit="submitting = true" class="space-y-8">
                                        @csrf
                                        <div class="space-y-4">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="w-8 h-px bg-[#3da9fc]"></span>
                                                <label class="text-xs font-black text-[#094067] uppercase tracking-widest">Pilih Durasi Sewa</label>
                                            </div>
                                            <div class="grid grid-cols-3 gap-4">
                                                <template x-for="d in [1, 3, 6]">
                                                    <button type="button" @click="durasi = d; $el.form.durasi.value = d"
                                                        :class="durasi === d ? 'bg-[#3da9fc] border-[#3da9fc] text-[#fffffe] shadow-lg scale-105' :
                                                            'bg-[#fffffe] border-[#90b4ce]/30 text-[#5f6c7b] hover:border-[#3da9fc] hover:bg-[#3da9fc]/5'"
                                                        class="py-5 rounded-2xl border-2 font-bold transition-all duration-300 flex flex-col items-center group relative overflow-hidden">
                                                        <span class="text-2xl mb-1" x-text="d"></span>
                                                        <span class="text-[10px] uppercase tracking-tighter opacity-80" x-text="d > 1 ? 'Bulan' : 'Bulan'"></span>
                                                        <div x-show="durasi === d" class="absolute -top-2 -right-2 bg-white/20 p-4 rounded-full"></div>
                                                    </button>
                                                </template>
                                                <input type="hidden" name="durasi" :value="durasi" />
                                            </div>
                                            @error('durasi')
                                                <p class="text-[10px] text-[#ef4565] font-bold uppercase mt-2 flex items-center gap-1">
                                                    <i class="fa-solid fa-circle-exclamation"></i> {{ $message }}
                                                </p>
                                            @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-[#094067] uppercase tracking-widest ml-1">Nama Penyewa</label>
                                                <div class="relative">
                                                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-[#90b4ce] text-xs"></i>
                                                    <input type="text" value="{{ auth()->user()->name }}" readonly
                                                        class="w-full bg-[#f8fafc] border border-[#90b4ce]/20 rounded-2xl pl-10 pr-4 py-4 text-sm text-[#5f6c7b] outline-none font-semibold">
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <label class="text-[10px] font-black text-[#094067] uppercase tracking-widest ml-1">Email Terdaftar</label>
                                                <div class="relative">
                                                    <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-[#90b4ce] text-xs"></i>
                                                    <input type="text" value="{{ auth()->user()->email }}" readonly
                                                        class="w-full bg-[#f8fafc] border border-[#90b4ce]/20 rounded-2xl pl-10 pr-4 py-4 text-sm text-[#5f6c7b] outline-none font-semibold">
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" :disabled="!durasi || submitting"
                                            class="group w-full bg-[#3da9fc] hover:bg-[#094067] text-[#fffffe] font-black py-5 rounded-2xl transition-all duration-300 shadow-xl shadow-[#3da9fc]/20 disabled:opacity-50 flex items-center justify-center gap-3 text-sm uppercase tracking-widest">
                                            <span x-show="!submitting">Buat Pesanan Pembayaran</span>
                                            <i x-show="!submitting" class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                                            <i x-show="submitting" class="fa-solid fa-circle-notch animate-spin"></i>
                                            <span x-show="submitting">Sedang Memproses...</span>
                                        </button>
                                    </form>
                                @else
                                    <div class="space-y-8 py-4">
                                        <div class="flex items-center gap-5 p-6 bg-[#3da9fc]/5 border-2 border-dashed border-[#3da9fc]/30 rounded-[2rem]">
                                            <div class="w-16 h-16 bg-[#fffffe] rounded-2xl flex items-center justify-center text-[#3da9fc] shadow-sm flex-shrink-0">
                                                <i class="fa-solid fa-hourglass-half text-2xl animate-pulse"></i>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-[#094067] uppercase tracking-wider">Menunggu Pembayaran</p>
                                                <p class="text-sm text-[#5f6c7b] mt-1 leading-relaxed">Invoice <strong class="text-[#094067] font-mono">{{ $transaksiPending->kode }}</strong> masih
                                                    tertunda. Silahkan selesaikan transaksi ini.</p>
                                            </div>
                                        </div>

                                        @if (\Carbon\Carbon::parse($transaksiPending->midtrans_response['expired_at'])->isPast())
                                            <form method="POST" action="{{ route('penghuni.pembayaran.buat-ulang', $user->id_kamar) }}">
                                                @csrf
                                                <button type="submit" :disabled="submitting"
                                                    class="w-full bg-[#ef4565] hover:bg-[#d63c5a] text-[#fffffe] font-black py-5 rounded-2xl transition-all duration-300 shadow-xl shadow-[#ef4565]/20 flex items-center justify-center gap-3 text-sm uppercase tracking-widest">
                                                    <span x-show="!submitting">Buat Ulang Token</span>
                                                    <i x-show="!submitting" class="fa-solid fa-external-link text-xs"></i>
                                                    <i x-show="submitting" class="fa-solid fa-circle-notch animate-spin"></i>
                                                    <span x-show="submitting">Membuat Ulang...</span>
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" @click="lanjutkanPembayaran()" :disabled="submitting"
                                                class="w-full bg-[#3da9fc] hover:bg-[#094067] text-[#fffffe] font-black py-5 rounded-2xl transition-all duration-300 shadow-xl shadow-[#3da9fc]/20 flex items-center justify-center gap-3 text-sm uppercase tracking-widest">
                                                <span x-show="!submitting">Bayar Sekarang</span>
                                                <i x-show="!submitting" class="fa-solid fa-external-link text-xs"></i>
                                                <i x-show="submitting" class="fa-solid fa-circle-notch animate-spin"></i>
                                                <span x-show="submitting">Menghubungkan...</span>
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            @endif

                            <div x-show="errorMessage" x-transition
                                class="mt-6 p-4 bg-[#ef4565]/10 border border-[#ef4565]/20 rounded-2xl text-[#ef4565] text-[10px] font-black uppercase tracking-widest text-center" x-text="errorMessage">
                            </div>

                            @if ($transaksiPending)
                                @if (\Carbon\Carbon::parse($transaksiPending->midtrans_response['expired_at'])->isPast())
                                    <div class="mt-6 p-4 bg-[#ef4565]/10 border border-[#ef4565]/20 rounded-2xl text-[#ef4565] text-[10px] font-black uppercase tracking-widest text-center">
                                        <p>Token pembayaran sudah kadaluarsa. Silahkan klik "Buat Ulang Token" untuk transaksi ulang.</p>
                                    </div>
                                @endif
                            @endif

                            @if (session('success'))
                                <div class="mt-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-[10px] font-black uppercase tracking-widest text-center">
                                    {{ session('success') }}
                                </div>
                            @endif
                        </div>

                        <div class="px-8 py-5 bg-[#f8fafc] border-t border-[#90b4ce]/10 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-lock text-[#90b4ce] text-[10px]"></i>
                                <p class="text-[10px] text-[#90b4ce] font-bold uppercase tracking-tighter">Pembayaran Terenkripsi</p>
                            </div>
                            <div class="flex gap-4 opacity-50 grayscale hover:grayscale-0 transition-all">
                                <i class="fa-brands fa-cc-visa text-xl"></i>
                                <i class="fa-brands fa-cc-mastercard text-xl"></i>
                                <span class="text-[10px] font-black text-[#094067] border border-[#094067] px-1 rounded">MIDTRANS</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5 space-y-8">
                    <div class="bg-white rounded-[2.5rem] border border-[#90b4ce]/20 shadow-sm overflow-hidden group">
                        <div class="px-8 py-6 border-b border-[#90b4ce]/10 flex justify-between items-center bg-[#fffffe]">
                            <h3 class="font-bold text-[#094067] uppercase tracking-wider text-sm">Informasi Kamar</h3>
                            <i class="fa-solid fa-door-closed text-[#90b4ce] group-hover:text-[#3da9fc] transition-colors"></i>
                        </div>

                        @if (auth()->user()->kamar)
                            <div class="relative h-56 m-4 overflow-hidden rounded-[2rem]">
                                <img src="{{ Storage::url(auth()->user()->kamar->gambar) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#094067]/80 via-transparent to-transparent"></div>
                                <div class="absolute bottom-6 left-6">
                                    <span class="bg-[#3da9fc] text-[#fffffe] text-[9px] font-black px-3 py-1.5 rounded-full uppercase tracking-widest mb-2 inline-block">
                                        {{ auth()->user()->kamar->tipe }}
                                    </span>
                                    <h4 class="text-[#fffffe] font-black text-2xl tracking-tight">{{ auth()->user()->kamar->kode_kamar }}</h4>
                                </div>
                            </div>
                            <div class="px-8 pb-8 space-y-6">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[#5f6c7b] text-[10px] font-bold uppercase tracking-widest mb-1">Harga Sewa</p>
                                        <span class="text-2xl font-black text-[#094067]">Rp {{ number_format(auth()->user()->kamar->harga, 0, ',', '.') }}</span>
                                        <span class="text-[#5f6c7b] text-xs">/ bln</span>
                                    </div>
                                </div>

                                @if (auth()->user()->kamar->detailKamar)
                                    <div class="pt-6 border-t border-slate-100">
                                        <label class="text-[10px] font-black text-[#90b4ce] uppercase tracking-[0.2em] block mb-4">Fasilitas Utama</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            @foreach (auth()->user()->kamar->detailKamar->take(4) as $detail)
                                                <div class="flex items-center gap-2 bg-[#f8fafc] p-3 rounded-xl border border-slate-100">
                                                    <i class="fa-solid fa-circle-check text-[#3da9fc] text-[10px]"></i>
                                                    <span class="text-[#5f6c7b] text-[10px] font-bold uppercase truncate">
                                                        {{ $detail->fasilitas }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="p-16 text-center">
                                <p class="text-sm text-[#90b4ce] italic font-medium">Data kamar tidak ditemukan.</p>
                            </div>
                        @endif
                    </div>

                    <div class="bg-[#094067] rounded-[2.5rem] p-8 text-[#fffffe] shadow-2xl shadow-blue-900/20 relative overflow-hidden group">
                        <div class="absolute -right-10 -bottom-10 opacity-10 group-hover:rotate-12 transition-transform duration-500">
                            <i class="fa-solid fa-shield-halved text-[150px]"></i>
                        </div>

                        <div class="flex items-center gap-4 mb-8">
                            <div class="w-12 h-12 bg-[#3da9fc]/20 rounded-2xl flex items-center justify-center border border-[#3da9fc]/30">
                                <i class="fa-solid fa-shield-heart text-[#3da9fc] text-xl"></i>
                            </div>
                            <h4 class="font-black text-sm uppercase tracking-[0.2em]">Sistem Aman</h4>
                        </div>

                        <ul class="space-y-4 relative z-10">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-5 h-5 bg-emerald-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-emerald-400 text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Verifikasi Otomatis</p>
                                    <p class="text-[#90b4ce] text-[10px] mt-0.5">Sistem akan memverifikasi pembayaran Anda secara real-time.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 w-5 h-5 bg-emerald-500/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="fa-solid fa-check text-emerald-400 text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Bebas Biaya Tersembunyi</p>
                                    <p class="text-[#90b4ce] text-[10px] mt-0.5">Total yang tertera adalah jumlah bersih yang Anda bayarkan.</p>
                                </div>
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
