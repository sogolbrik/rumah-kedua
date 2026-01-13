@extends('layouts.admin-main')

@section('title', 'Tambah Transaksi')

@section('admin-main')
    <div class="min-h-screen w-full bg-[#f8fafc] pb-12" x-data="transaksiForm()">
        <div class="absolute inset-x-0 top-0 h-64"></div>

        <div class="relative mx-auto max-w-[1400px] px-4 pt-0">
            <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Tambah Transaksi Baru</h1>
                    <p class="mt-1 text-sm text-slate-600">Lengkapi informasi transaksi dengan detail yang akurat</p>
                </div>
                <a href="{{ route('transaksi.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-8 overflow-hidden rounded-2xl border border-rose-200 bg-rose-50 shadow-sm transition-all animate-in fade-in slide-in-from-top-4">
                    <div class="flex items-center gap-3 border-b border-rose-100 bg-rose-100/50 px-6 py-3 text-rose-800">
                        <i class="fa-solid fa-triangle-exclamation animate-pulse"></i>
                        <span class="font-bold">Validation Error</span>
                    </div>
                    <ul class="list-inside list-disc px-6 py-4 text-sm text-rose-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.store') }}" method="POST" class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                @csrf

                <div class="lg:col-span-8 space-y-8">

                    <div class="rounded-3xl border border-slate-200 bg-white p-1 shadow-sm transition-all hover:shadow-md">
                        <div class="rounded-[calc(1.5rem-1px)] bg-slate-50/50 px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-white shadow-lg shadow-emerald-200">
                                    <i class="fa-solid fa-id-card text-lg"></i>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-slate-900">Identitas & Ruang</h2>
                                    <p class="text-sm text-slate-500 font-medium font-mono uppercase tracking-wider">Step 01 — Basic Info</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-8 px-8 py-8 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Pelanggan</label>
                                <div class="relative group">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <select name="id_user" required x-model="formState.id_user" @blur="formState.touched.id_user = true"
                                        class="w-full appearance-none rounded-2xl border-2 border-slate-100 bg-white py-3.5 pl-11 pr-10 text-sm font-bold text-slate-900 outline-none transition-all focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                                        <option value="">Pilih Pelanggan</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                                <template x-if="formState.touched.id_user && !formState.id_user">
                                    <span class="text-[11px] font-bold text-rose-500 flex items-center gap-1 mt-1 ml-1 animate-in fade-in slide-in-from-left-2">
                                        <i class="fa-solid fa-circle-exclamation"></i> Required Field
                                    </span>
                                </template>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Kamar</label>
                                <div class="relative group">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                                        <i class="fa-solid fa-door-open"></i>
                                    </div>
                                    <select id="id_kamar" name="id_kamar" required x-model="formState.id_kamar" x-on:change="updateHargaKamar()" @blur="formState.touched.id_kamar = true"
                                        class="w-full appearance-none rounded-2xl border-2 border-slate-100 bg-white py-3.5 pl-11 pr-10 text-sm font-bold text-slate-900 outline-none transition-all focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10">
                                        <option value="">Pilih Kamar</option>
                                        @foreach ($kamars as $kamar)
                                            <option value="{{ $kamar->id }}" data-harga="{{ $kamar->harga }}" {{ old('id_kamar') == $kamar->id ? 'selected' : '' }}>
                                                {{ $kamar->kode_kamar }} — Rp{{ number_format($kamar->harga, 0, ',', '.') }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400">
                                        <i class="fa-solid fa-chevron-down text-xs"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all hover:shadow-md">
                            <div class="mb-6 flex items-center gap-3 text-blue-600">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                                    <i class="fa-solid fa-calendar-days"></i>
                                </div>
                                <h3 class="font-bold text-slate-900">Penjadwalan</h3>
                            </div>
                            <div class="space-y-5">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Tanggal Bayar</label>
                                    <input type="date" name="tanggal_pembayaran" required x-model="formState.tanggal_pembayaran"
                                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50/50 px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:bg-white focus:border-blue-500 outline-none">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Check-In</label>
                                    <input type="date" name="masuk_kamar" required x-model="formState.masuk_kamar"
                                        class="w-full rounded-2xl border-2 border-slate-100 bg-slate-50/50 px-4 py-3 text-sm font-bold text-slate-900 transition-all focus:bg-white focus:border-blue-500 outline-none">
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all hover:shadow-md">
                            <div class="mb-6 flex items-center gap-3 text-indigo-600">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                                    <i class="fa-solid fa-clock"></i>
                                </div>
                                <h3 class="font-bold text-slate-900">Durasi Sewa</h3>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold uppercase tracking-widest text-slate-500">Pilih Paket</label>
                                <div class="grid grid-cols-1 gap-3">
                                    <template x-for="opt in [1, 3, 6]" :key="opt">
                                        <button type="button" x-on:click="formState.durasi = opt.toString(); updateTotalSeharusnya()"
                                            :class="formState.durasi == opt ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-200' :
                                                'bg-white border-slate-200 text-slate-600 hover:border-indigo-300'"
                                            class="flex items-center justify-between rounded-2xl border-2 px-5 py-4 transition-all">
                                            <span class="font-bold" x-text="opt + ' Bulan'"></span>
                                            <i class="fa-solid fa-circle-check" :class="formState.durasi == opt ? 'opacity-100' : 'opacity-0'"></i>
                                        </button>
                                    </template>
                                    <select name="durasi" class="hidden" x-model="formState.durasi" x-on:change="updateTotalSeharusnya()">
                                        <option value="1">1</option>
                                        <option value="3">3</option>
                                        <option value="6">6</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm transition-all hover:shadow-md">
                        <div class="mb-8 flex items-center gap-3 text-violet-600">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <h3 class="font-bold text-slate-900 text-xl">Payment Details</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Total Bayar</label>
                                <div class="relative group">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 font-bold text-slate-400 group-focus-within:text-violet-600 transition-colors">
                                        Rp
                                    </div>
                                    <input type="text" name="total_bayar" required x-model="formState.total_bayar" x-on:input="handleTotalBayarInput($event)"
                                        class="w-full rounded-2xl border-2 border-slate-100 bg-white py-3.5 pl-12 pr-12 text-sm font-extrabold text-slate-900 outline-none transition-all focus:border-violet-500 focus:ring-4 focus:ring-violet-500/10"
                                        placeholder="0">
                                    <button type="button" x-on:click="clearTotalBayar()" x-show="formState.total_bayar_raw"
                                        class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-300 hover:text-rose-500 transition-colors">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700 ml-1">Metode</label>
                                <div class="flex gap-3">
                                    <label class="relative flex-1 cursor-pointer">
                                        <input type="radio" name="metode_pembayaran" value="cash" x-model="formState.metode_pembayaran" class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-slate-100 py-3 transition-all peer-checked:border-violet-500 peer-checked:bg-violet-50 peer-checked:text-violet-600 hover:bg-slate-50">
                                            <i class="fa-solid fa-money-bill-1 text-lg"></i>
                                            <span class="text-xs font-bold uppercase">Cash</span>
                                        </div>
                                    </label>
                                    <label class="relative flex-1 cursor-pointer">
                                        <input type="radio" name="metode_pembayaran" value="midtrans" x-model="formState.metode_pembayaran" class="peer sr-only">
                                        <div
                                            class="flex flex-col items-center justify-center gap-2 rounded-2xl border-2 border-slate-100 py-3 transition-all peer-checked:border-violet-500 peer-checked:bg-violet-50 peer-checked:text-violet-600 hover:bg-slate-50">
                                            <i class="fa-solid fa-globe text-lg"></i>
                                            <span class="text-xs font-bold uppercase">Online</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-23 space-y-6">
                        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl shadow-slate-200/50 transition-all">
                            <div class="bg-slate-900 px-6 py-6 text-white">
                                <h3 class="text-lg font-bold italic tracking-tighter">SUMMARY_RECEIPT</h3>
                                <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest">Transaction Preview</p>
                            </div>

                            <div class="p-6 space-y-6">
                                <div class="rounded-2xl bg-slate-50 p-4 border border-dashed border-slate-200">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Harga Unit</span>
                                        <span class="text-xs font-bold text-slate-600" x-text="'Rp ' + formatCurrency(formState.harga)"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Durasi</span>
                                        <span class="text-xs font-bold text-slate-600" x-text="formState.durasi ? formState.durasi + ' Bulan' : '-'"></span>
                                    </div>
                                    <div class="my-3 border-t border-slate-200"></div>
                                    <div class="flex justify-between items-end">
                                        <span class="text-sm font-bold text-slate-900">Subtotal</span>
                                        <span class="text-xl font-black text-emerald-600" x-text="'Rp ' + formatCurrency(formState.total_seharusnya)"></span>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        <span>Pajak layanan 0%</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm font-medium text-slate-600">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                                        <span>Status: <span class="text-blue-600 font-bold uppercase text-[10px] bg-blue-50 px-2 py-0.5 rounded">Draft</span></span>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <button type="submit" :disabled="!isFormValid"
                                        class="group relative w-full overflow-hidden rounded-2xl bg-emerald-600 px-6 py-4 font-bold text-white shadow-lg shadow-emerald-200 transition-all hover:bg-emerald-700 hover:shadow-xl active:scale-95 disabled:grayscale disabled:opacity-50 disabled:cursor-not-allowed">
                                        <div class="relative z-10 flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                            <span>Simpan Transaksi</span>
                                        </div>
                                        <div
                                            class="absolute inset-0 z-0 bg-gradient-to-r from-transparent via-white/10 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1000">
                                        </div>
                                    </button>

                                    <button type="button" x-on:click="resetForm()"
                                        class="mt-4 w-full rounded-2xl bg-white px-6 py-3 text-sm font-bold text-slate-400 transition-all hover:text-rose-500">
                                        Reset Input
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 p-6 text-white shadow-lg shadow-blue-200">
                            <div class="mb-4 flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 backdrop-blur-md text-white">
                                <i class="fa-solid fa-lightbulb"></i>
                            </div>
                            <h4 class="mb-1 font-bold">Pro-Tip</h4>
                            <p class="text-sm font-medium leading-relaxed opacity-80">Pastikan <b>Total Bayar</b> sesuai dengan jumlah yang diterima dari pelanggan sebelum menekan tombol simpan.</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function transaksiForm() {
            return {
                formState: {
                    id_user: '{{ old('id_user') }}',
                    id_kamar: '{{ old('id_kamar') }}',
                    tanggal_pembayaran: '{{ old('tanggal_pembayaran', date('Y-m-d')) }}',
                    masuk_kamar: '{{ old('masuk_kamar', date('Y-m-d')) }}',
                    durasi: '{{ old('durasi') }}',
                    total_bayar: '',
                    total_bayar_raw: '',
                    metode_pembayaran: '{{ old('metode_pembayaran') }}',
                    harga: 0,
                    total_seharusnya: 0,
                    touched: {
                        id_user: false,
                        id_kamar: false,
                        tanggal_pembayaran: false,
                        durasi: false,
                        total_bayar: false,
                        metode_pembayaran: false,
                    }
                },
                init() {
                    if (this.formState.id_kamar) this.updateHargaKamar();
                    if (this.formState.durasi) this.updateTotalBayar();
                },
                get isFormValid() {
                    return this.formState.id_user && this.formState.id_kamar &&
                        this.formState.tanggal_pembayaran && this.formState.masuk_kamar &&
                        this.formState.durasi && this.formState.total_bayar_raw &&
                        this.formState.metode_pembayaran;
                },
                handleTotalBayarInput(event) {
                    const rawValue = event.target.value.replace(/\D/g, '');
                    this.formState.total_bayar_raw = rawValue;
                    this.formState.total_bayar = this.formatCurrency(rawValue);
                },
                formatCurrency(value) {
                    if (!value) return '0';
                    const number = parseInt(value) || 0;
                    return number.toLocaleString('id-ID');
                },
                clearTotalBayar() {
                    this.formState.total_bayar = '';
                    this.formState.total_bayar_raw = '';
                },
                updateHargaKamar() {
                    const kamarSelect = document.getElementById('id_kamar');
                    const selectedOption = kamarSelect?.options[kamarSelect.selectedIndex];
                    if (selectedOption && selectedOption.value) {
                        this.formState.harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                    } else {
                        this.formState.harga = 0;
                    }
                    this.updateTotalSeharusnya();
                },
                updateTotalBayar() {
                    this.updateTotalSeharusnya();
                    if (this.formState.total_seharusnya > 0 && !this.formState.total_bayar_raw) {
                        this.formState.total_bayar_raw = this.formState.total_seharusnya.toString();
                        this.formState.total_bayar = this.formatCurrency(this.formState.total_bayar_raw);
                    }
                },
                updateTotalSeharusnya() {
                    if (!this.formState.harga || !this.formState.durasi) {
                        this.formState.total_seharusnya = 0;
                        return;
                    }
                    const multiplier = parseInt(this.formState.durasi);
                    const total = this.formState.harga * multiplier;
                    this.formState.total_seharusnya = total;
                    this.formState.total_bayar_raw = total.toString();
                    this.formState.total_bayar = this.formatCurrency(total);
                },
                resetForm() {
                    window.location.reload(); // Sederhananya untuk reset UI sepenuhnya
                }
            }
        }
    </script>

    <style>
        /* Custom pattern for background */
        .bg-[#f8fafc] {
            background-image: radial-gradient(#e2e8f0 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }

        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(0.5);
            cursor: pointer;
        }
    </style>
@endsection
