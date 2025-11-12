@extends('layouts.admin-main')

@section('title', 'Tambah Transaksi')

@section('admin-main')
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100/50 pt-0 pb-8" x-data="transaksiForm()">
        <div class="w-full">
            <div class="mb-8 flex items-center justify-between">
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
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50/50 p-4 shadow-sm">
                    <div class="flex items-center gap-2 text-rose-800">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span class="font-medium">Terdapat kesalahan dalam pengisian form:</span>
                    </div>
                    <ul class="mt-2 list-inside list-disc text-sm text-rose-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('transaksi.store') }}" method="POST" class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                @csrf

                <div class="border-b border-slate-200 bg-gradient-to-r from-emerald-50 to-green-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Informasi Dasar Transaksi</h2>
                            <p class="text-sm text-slate-600">Data utama transaksi yang wajib diisi</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Pelanggan -->
                        <div class="group">
                            <label for="id_user" class="mb-2 block text-sm font-semibold text-slate-700">
                                Pelanggan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </div>
                                <select id="id_user" name="id_user" required x-model="formState.id_user" @blur="formState.touched.id_user = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10">
                                    <option value="">Pilih Pelanggan</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" {{ old('id_user') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p x-cloak x-show="formState.touched.id_user && !formState.id_user" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Pelanggan wajib dipilih
                            </p>
                        </div>

                        <!-- Kamar -->
                        <div class="group">
                            <label for="id_kamar" class="mb-2 block text-sm font-semibold text-slate-700">
                                Kamar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-door-closed text-sm"></i>
                                </div>
                                <select id="id_kamar" name="id_kamar" required x-model="formState.id_kamar" x-on:change="updateHargaKamar()" @blur="formState.touched.id_kamar = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10">
                                    <option value="">Pilih Kamar</option>
                                    @foreach ($kamars as $kamar)
                                        <option value="{{ $kamar->id }}" data-harga="{{ $kamar->harga }}" {{ old('id_kamar') == $kamar->id ? 'selected' : '' }}>
                                            {{ $kamar->kode_kamar }} - Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p x-cloak x-show="formState.touched.id_kamar && !formState.id_kamar" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Kamar wajib dipilih
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Tanggal Pembayaran -->
                        <div class="group">
                            <label for="tanggal_pembayaran" class="mb-2 block text-sm font-semibold text-slate-700">
                                Tanggal Pembayaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-calendar-day text-sm"></i>
                                </div>
                                <input type="date" id="tanggal_pembayaran" name="tanggal_pembayaran" required x-model="formState.tanggal_pembayaran" @blur="formState.touched.tanggal_pembayaran = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                            </div>
                            <p x-cloak x-show="formState.touched.tanggal_pembayaran && !formState.tanggal_pembayaran" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Tanggal pembayaran wajib diisi
                            </p>
                        </div>

                        <!-- Tanggal Masuk Kamar -->
                        <div class="group">
                            <label for="masuk_kamar" class="mb-2 block text-sm font-semibold text-slate-700">
                                Tanggal Masuk Kamar <span class="text-slate-400">(opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-calendar-check text-sm"></i>
                                </div>
                                <input type="date" id="masuk_kamar" name="masuk_kamar" x-model="formState.masuk_kamar"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-emerald-500 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Periode & Durasi</h2>
                            <p class="text-sm text-slate-600">Informasi periode sewa dan durasi</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Periode Pembayaran -->
                        <div class="group">
                            <label for="periode_pembayaran" class="mb-2 block text-sm font-semibold text-slate-700">
                                Periode Pembayaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-calendar-alt text-sm"></i>
                                </div>
                                <input type="text" id="periode_pembayaran" name="periode_pembayaran" required placeholder="Contoh: Januari 2024" x-model="formState.periode_pembayaran"
                                    @blur="formState.touched.periode_pembayaran = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10" />
                            </div>
                            <p x-cloak x-show="formState.touched.periode_pembayaran && !formState.periode_pembayaran" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Periode pembayaran wajib diisi
                            </p>
                        </div>

                        <!-- Durasi -->
                        <div class="group">
                            <label for="durasi" class="mb-2 block text-sm font-semibold text-slate-700">
                                Durasi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-hourglass-half text-sm"></i>
                                </div>
                                <select id="durasi" name="durasi" required x-model="formState.durasi" x-on:change="updateTotalBayar()" @blur="formState.touched.durasi = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-500/10">
                                    <option value="">Pilih Durasi</option>
                                    <option value="1 bulan" {{ old('durasi') == '1 bulan' ? 'selected' : '' }}>1 Bulan</option>
                                    <option value="3 bulan" {{ old('durasi') == '3 bulan' ? 'selected' : '' }}>3 Bulan</option>
                                    <option value="6 bulan" {{ old('durasi') == '6 bulan' ? 'selected' : '' }}>6 Bulan</option>
                                    <option value="1 tahun" {{ old('durasi') == '1 tahun' ? 'selected' : '' }}>1 Tahun</option>
                                </select>
                            </div>
                            <p x-cloak x-show="formState.touched.durasi && !formState.durasi" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Durasi wajib dipilih
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-violet-50 to-purple-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 text-white shadow-lg">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Informasi Pembayaran</h2>
                            <p class="text-sm text-slate-600">Detail pembayaran dan metode</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Total Bayar -->
                        <div class="group">
                            <label for="total_bayar" class="mb-2 block text-sm font-semibold text-slate-700">
                                Total Bayar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-600">
                                    <span class="text-sm font-semibold">Rp</span>
                                </div>
                                <input type="text" id="total_bayar" name="total_bayar" required x-model="formState.total_bayar" x-on:input="handleTotalBayarInput($event)"
                                    @blur="formState.touched.total_bayar = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-12 pr-12 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-500/10" />
                                <button type="button" x-on:click="clearTotalBayar()" x-show="formState.total_bayar_raw"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition-colors hover:text-slate-600">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500">Sistem akan memformat angka secara otomatis</p>
                            <p x-cloak x-show="formState.touched.total_bayar && !formState.total_bayar_raw" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Total bayar wajib diisi
                            </p>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="group">
                            <label for="metode_pembayaran" class="mb-2 block text-sm font-semibold text-slate-700">
                                Metode Pembayaran <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-credit-card text-sm"></i>
                                </div>
                                <select id="metode_pembayaran" name="metode_pembayaran" required x-model="formState.metode_pembayaran" @blur="formState.touched.metode_pembayaran = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-violet-500 focus:outline-none focus:ring-4 focus:ring-violet-500/10">
                                    <option value="">Pilih Metode</option>
                                    <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="midtrans" {{ old('metode_pembayaran') == 'midtrans' ? 'selected' : '' }}>Online (Midtrans)</option>
                                </select>
                            </div>
                            <p x-cloak x-show="formState.touched.metode_pembayaran && !formState.metode_pembayaran" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Metode pembayaran wajib dipilih
                            </p>
                        </div>
                    </div>

                    <!-- Informasi Harga Otomatis -->
                    <div x-cloak x-show="formState.harga > 0 && formState.durasi" class="rounded-xl bg-slate-50 p-4 border border-slate-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-700">Harga Kamar per Bulan</p>
                                <p class="text-lg font-bold text-emerald-600">Rp <span x-text="formatCurrency(formState.harga)"></span></p>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-medium text-slate-700">Durasi</p>
                                <p class="text-lg font-bold text-blue-600" x-text="formState.durasi"></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-slate-700">Total Seharusnya</p>
                                <p class="text-lg font-bold text-violet-600">Rp <span x-text="formatCurrency(formState.total_seharusnya)"></span></p>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-slate-500 text-center">
                            <i class="fa-solid fa-lightbulb text-amber-500"></i>
                            Periksa kembali total bayar dengan perhitungan sistem
                        </p>
                    </div>

                    <!-- Debug Information (bisa dihapus setelah testing) -->
                    <div x-cloak x-show="false" class="rounded-xl bg-yellow-50 p-4 border border-yellow-200">
                        <p class="text-sm font-medium text-yellow-800">Debug Info:</p>
                        <p class="text-xs text-yellow-700">Harga: <span x-text="formState.harga"></span></p>
                        <p class="text-xs text-yellow-700">Durasi: <span x-text="formState.durasi"></span></p>
                        <p class="text-xs text-yellow-700">Total Seharusnya: <span x-text="formState.total_seharusnya"></span></p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 border-t border-slate-200 bg-slate-50 px-8 py-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-600">
                        <i class="fa-solid fa-circle-info text-emerald-600"></i>
                        Pastikan semua data sudah benar sebelum menyimpan
                    </p>
                    <div class="flex gap-3">
                        <button type="button" x-on:click="resetForm()"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </button>
                        <button type="submit" :disabled="!isFormValid"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-green-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition-all hover:shadow-xl hover:shadow-emerald-500/40 disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
                            <i class="fa-solid fa-check"></i>
                            Simpan Transaksi
                        </button>
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
                    masuk_kamar: '{{ old('masuk_kamar') }}',
                    periode_pembayaran: '{{ old('periode_pembayaran') }}',
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
                        periode_pembayaran: false,
                        durasi: false,
                        total_bayar: false,
                        metode_pembayaran: false,
                    }
                },

                init() {
                    // Initialize harga jika ada kamar yang sudah dipilih (old value)
                    if (this.formState.id_kamar) {
                        this.updateHargaKamar();
                    }

                    // Initialize durasi jika ada (old value)
                    if (this.formState.durasi) {
                        this.updateTotalBayar();
                    }

                    console.log('Form initialized:', this.formState);
                },

                get isFormValid() {
                    return this.formState.id_user &&
                        this.formState.id_kamar &&
                        this.formState.tanggal_pembayaran &&
                        this.formState.periode_pembayaran &&
                        this.formState.durasi &&
                        this.formState.total_bayar_raw &&
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
                        const harga = parseInt(selectedOption.getAttribute('data-harga')) || 0;
                        this.formState.harga = harga;
                        console.log('Harga kamar updated:', harga);
                        this.updateTotalSeharusnya();
                    } else {
                        this.formState.harga = 0;
                        this.formState.total_seharusnya = 0;
                        console.log('Harga kamar reset to 0');
                    }
                },

                updateTotalBayar() {
                    this.updateTotalSeharusnya();

                    // Auto-fill total bayar dengan total seharusnya jika belum diisi
                    if (this.formState.total_seharusnya > 0 && !this.formState.total_bayar_raw) {
                        this.formState.total_bayar_raw = this.formState.total_seharusnya.toString();
                        this.formState.total_bayar = this.formatCurrency(this.formState.total_bayar_raw);
                        console.log('Auto-filled total bayar:', this.formState.total_bayar);
                    }
                },

                updateTotalSeharusnya() {
                    if (!this.formState.harga || !this.formState.durasi) {
                        this.formState.total_seharusnya = 0;
                        return;
                    }

                    const harga = this.formState.harga;
                    let multiplier = 1;

                    switch (this.formState.durasi) {
                        case '1 bulan':
                            multiplier = 1;
                            break;
                        case '3 bulan':
                            multiplier = 3;
                            break;
                        case '6 bulan':
                            multiplier = 6;
                            break;
                        case '1 tahun':
                            multiplier = 12;
                            break;
                        default:
                            multiplier = 1;
                    }

                    this.formState.total_seharusnya = harga * multiplier;
                    console.log('Total seharusnya updated:', this.formState.total_seharusnya, 'Harga:', harga, 'Multiplier:', multiplier);
                },

                resetForm() {
                    this.formState = {
                        id_user: '',
                        id_kamar: '',
                        tanggal_pembayaran: '{{ date('Y-m-d') }}',
                        masuk_kamar: '',
                        periode_pembayaran: '',
                        durasi: '',
                        total_bayar: '',
                        total_bayar_raw: '',
                        metode_pembayaran: '',
                        harga: 0,
                        total_seharusnya: 0,
                        touched: {
                            id_user: false,
                            id_kamar: false,
                            tanggal_pembayaran: false,
                            periode_pembayaran: false,
                            durasi: false,
                            total_bayar: false,
                            metode_pembayaran: false,
                        }
                    };
                }
            }
        }
    </script>
@endsection
