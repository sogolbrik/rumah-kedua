@extends('layouts.admin-main')

@section('title', 'Tambah Kamar')

@section('admin-main')
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100/50 pt-0 pb-8" x-data="kamarForm()">
        <div class="w-full">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Tambah Kamar Baru</h1>
                    <p class="mt-1 text-sm text-slate-600">Lengkapi informasi kamar dengan detail yang akurat</p>
                </div>
                <a href="{{ route('kamar.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form id="form-kamar" action="{{ route('kamar.store') }}" method="POST" enctype="multipart/form-data" class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                @csrf

                <div class="border-b border-slate-200 bg-gradient-to-r from-cyan-50 to-blue-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-600 text-white shadow-lg">
                            <i class="fa-solid fa-door-open"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Informasi Dasar</h2>
                            <p class="text-sm text-slate-600">Data utama kamar yang wajib diisi</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="group">
                            <label for="kode_kamar" class="mb-2 block text-sm font-semibold text-slate-700">
                                Kode Kamar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-hashtag text-sm"></i>
                                </div>
                                <input id="kode_kamar" name="kode_kamar" type="text" required placeholder="Contoh: A-101, B-205" x-model="formState.kode_kamar"
                                    @blur="formState.touched.kode_kamar = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500">Format: [Blok]-[Nomor], contoh A-101</p>
                            <p x-cloak x-show="formState.touched.kode_kamar && !formState.kode_kamar" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Kode kamar wajib diisi
                            </p>
                        </div>

                        <div class="group">
                            <label for="harga" class="mb-2 block text-sm font-semibold text-slate-700">
                                Harga per Bulan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-600">
                                    <span class="text-sm font-semibold">Rp</span>
                                </div>
                                <input id="harga" name="harga" type="text" inputmode="numeric" placeholder="1.500.000" x-model="formState.harga" @input="handleHargaInput"
                                    @blur="formState.touched.harga = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-12 pr-12 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                                <button type="button" @click="clearHarga" x-show="formState.hargaRaw"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition-colors hover:text-slate-600">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500">Sistem akan memformat angka secara otomatis</p>
                            <p x-cloak x-show="formState.touched.harga && !formState.hargaRaw" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Harga wajib diisi
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg">
                            <i class="fa-solid fa-list-check"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Detail Kamar</h2>
                            <p class="text-sm text-slate-600">Informasi tambahan untuk memperjelas spesifikasi</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="tipe" class="mb-2 block text-sm font-semibold text-slate-700">
                                Tipe Kamar <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-tag text-sm"></i>
                                </div>
                                <select id="tipe" name="tipe" x-model="formState.tipe" @change="updateFasilitasByTipe" @blur="formState.touched.tipe = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10">
                                    <option value="">- Pilih Tipe -</option>
                                    <option value="Standard">Standard</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Exclusive">Exclusive</option>
                                </select>
                                <p x-cloak x-show="formState.touched.tipe && !formState.tipe" class="mt-1 text-xs font-medium text-rose-600">
                                    <i class="fa-solid fa-circle-exclamation"></i> Tipe kamar wajib dipilih
                                </p>
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500">Kategori atau tipe kamar</p>
                        </div>

                        <div>
                            <label for="lebar" class="mb-2 block text-sm font-semibold text-slate-700">
                                Luas Kamar (m²) <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-ruler-combined text-sm"></i>
                                </div>
                                <input id="lebar" name="lebar" type="number" min="0" step="0.1" placeholder="Contoh: 12.5" x-model="formState.lebar"
                                    @blur="formState.touched.lebar = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                                <p x-cloak x-show="formState.touched.lebar && !formState.lebar" class="mt-1 text-xs font-medium text-rose-600">
                                    <i class="fa-solid fa-circle-exclamation"></i> Luas kamar wajib diisi
                                </p>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-4 text-sm font-medium text-slate-500">
                                    m²
                                </div>
                            </div>
                            <p class="mt-1.5 text-xs text-slate-500">Luas dalam meter persegi</p>
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="mb-2 block text-sm font-semibold text-slate-700">
                            Deskripsi Kamar <span class="text-slate-400">(opsional)</span>
                        </label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsikan fasilitas, kondisi, dan keunggulan kamar ini..." x-model="formState.deskripsi"
                            @blur="formState.touched.deskripsi = true"
                            class="w-full rounded-xl border-2 border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10"></textarea>
                        <div class="mt-1.5 flex items-center justify-between text-xs">
                            <span class="text-slate-500">Jelaskan detail kamar untuk calon penyewa</span>
                            <span x-text="`${formState.deskripsi.length} karakter`" class="font-medium text-slate-600"></span>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">
                            Foto Kamar <span class="text-rose-500">*</span>
                        </label>
                        <div id="drop-zone" @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop"
                            :class="isDragging ? 'border-cyan-500 bg-cyan-100/50' : ''"
                            class="group relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/50 transition-all hover:border-cyan-400 hover:bg-cyan-50/50">
                            <input type="file" name="gambar" accept="image/*" id="gambar-input" class="hidden" @change="handleFileSelect; formState.touched.gambar = true">

                            <div x-show="!formState.gambar" class="flex flex-col items-center justify-center px-6 py-12 text-center">
                                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/30">
                                    <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                                </div>
                                <button type="button" @click="document.getElementById('gambar-input').click()"
                                    class="mb-3 inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                                    <i class="fa-solid fa-image"></i>
                                    Pilih Foto
                                </button>
                                <p class="text-sm font-medium text-slate-700">atau seret dan lepas file di sini</p>
                                <p class="mt-2 text-xs text-slate-500">PNG, JPG, WEBP hingga 2MB</p>
                            </div>

                            <div x-cloak x-show="formState.gambar" class="relative">
                                <img :src="previewUrl" alt="Preview" class="h-64 w-full object-cover" />
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <button type="button" @click="removeImage"
                                    class="absolute right-4 top-4 flex h-10 w-10 items-center justify-center rounded-xl bg-white/90 text-slate-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:text-rose-600">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                <div class="absolute bottom-4 left-4 right-4">
                                    <p x-text="fileInfo.name" class="text-sm font-semibold text-white"></p>
                                    <p x-text="fileInfo.size" class="text-xs text-white/80"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-violet-50 to-purple-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-violet-600 text-white shadow-lg">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Fasilitas Kamar</h2>
                            <p class="text-sm text-slate-600">Pilih fasilitas yang tersedia di kamar ini</p>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <template x-for="(fasilitas, index) in fasilitasList" :key="index">
                            <label
                                class="group relative flex cursor-pointer items-center gap-3 rounded-xl border-2 border-slate-200 bg-white px-4 py-3 transition-all hover:border-violet-300 hover:bg-violet-50/50 has-[:checked]:border-violet-500 has-[:checked]:bg-violet-50 has-[:checked]:shadow-sm">
                                <input type="checkbox" name="fasilitas[]" :value="fasilitas" x-model="formState.fasilitas" @change="formState.touched.fasilitas = true"
                                    class="h-5 w-5 rounded border-2 border-slate-300 text-violet-600 transition-all focus:ring-2 focus:ring-violet-500/20 focus:ring-offset-0" />
                                <span class="text-sm font-medium text-slate-700 group-has-[:checked]:text-violet-900" x-text="fasilitas"></span>
                                <i class="fa-solid fa-check absolute right-4 top-1/2 -translate-y-1/2 text-violet-600 opacity-0 transition-opacity group-has-[:checked]:opacity-100"></i>
                            </label>
                        </template>
                        <div x-cloak x-show="formState.touched.fasilitas && formState.fasilitas.length === 0" class="mt-2 text-xs font-medium text-rose-600 col-span-full">
                            <i class="fa-solid fa-circle-exclamation"></i> Pilih minimal 1 fasilitas
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">
                        <i class="fa-solid fa-lightbulb text-amber-500"></i>
                        Tip: Pilih tipe kamar terlebih dahulu untuk mengisi fasilitas secara otomatis
                    </p>
                </div>

                <div class="flex flex-col gap-4 border-t border-slate-200 bg-slate-50 px-8 py-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-sm text-slate-600">
                        <i class="fa-solid fa-circle-info text-cyan-600"></i>
                        Pastikan semua data sudah benar sebelum menyimpan
                    </p>
                    <div class="flex gap-3">
                        <button type="button" @click="resetForm"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                            <i class="fa-solid fa-rotate-left"></i>
                            Reset
                        </button>
                        <button type="submit" :disabled="!isFormValid"
                            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-cyan-600 to-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-lg shadow-cyan-500/30 transition-all hover:shadow-xl hover:shadow-cyan-500/40 disabled:cursor-not-allowed disabled:opacity-50 disabled:shadow-none">
                            <i class="fa-solid fa-check"></i>
                            Simpan Kamar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function kamarForm() {
            return {
                formState: {
                    kode_kamar: '',
                    harga: '',
                    hargaRaw: '',
                    tipe: '',
                    lebar: '',
                    deskripsi: '',
                    gambar: null,
                    fasilitas: [],
                    touched: {
                        kode_kamar: false,
                        harga: false,
                        tipe: false,
                        lebar: false,
                        deskripsi: false,
                        gambar: false,
                        fasilitas: false,
                    }
                },
                isDragging: false,
                previewUrl: '',
                fileInfo: {
                    name: '',
                    size: ''
                },
                fasilitasList: [
                    'Kasur & Bantal',
                    'Lemari',
                    'Meja dan Kursi',
                    'K. Mandi Dalam',
                    'Kaca',
                    'TV',
                    'Dapur Pribadi',
                    'WI-FI',
                    'Tempat Sampah',
                    'Listrik',
                    'Jendela dan Tirai',
                    'Stopkontak',
                    'Rak Sepatu',
                    'AC',
                    'Kipas Angin'
                ],
                fasilitasByTipe: {
                    'Standard': [
                        'Kasur & Bantal',
                        'Lemari',
                        'Meja dan Kursi',
                        'K. Mandi Dalam',
                        'Kaca',
                        'WI-FI',
                        'Tempat Sampah',
                        'Listrik',
                        'Jendela dan Tirai',
                        'Stopkontak'
                    ],
                    'Medium': [
                        'Kasur & Bantal',
                        'Lemari',
                        'Meja dan Kursi',
                        'K. Mandi Dalam',
                        'Kaca',
                        'TV',
                        'WI-FI',
                        'Tempat Sampah',
                        'Listrik',
                        'Jendela dan Tirai',
                        'Stopkontak',
                        'Rak Sepatu',
                        'Kipas Angin'
                    ],
                    'Exclusive': [
                        'Kasur & Bantal',
                        'Lemari',
                        'Meja dan Kursi',
                        'K. Mandi Dalam',
                        'Kaca',
                        'TV',
                        'Dapur Pribadi',
                        'WI-FI',
                        'Tempat Sampah',
                        'Listrik',
                        'Jendela dan Tirai',
                        'Stopkontak',
                        'Rak Sepatu',
                        'AC'
                    ]
                },

                get isFormValid() {
                    return this.formState.kode_kamar.trim() !== '' &&
                        this.formState.hargaRaw.trim() !== '' &&
                        this.formState.tipe.trim() !== '' &&
                        this.formState.lebar.trim() !== '' &&
                        // this.formState.deskripsi.trim() !== '' &&
                        this.formState.gambar !== null &&
                        this.formState.fasilitas.length > 0;
                },

                handleHargaInput(e) {
                    const rawValue = e.target.value.replace(/\D/g, '');
                    this.formState.hargaRaw = rawValue;
                    this.formState.harga = this.formatCurrency(rawValue);
                },

                formatCurrency(value) {
                    const number = value.replace(/\D/g, '');
                    return number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                },

                clearHarga() {
                    this.formState.harga = '';
                    this.formState.hargaRaw = '';
                },

                updateFasilitasByTipe() {
                    const tipe = this.formState.tipe;
                    if (tipe && this.fasilitasByTipe[tipe]) {
                        this.formState.fasilitas = [...this.fasilitasByTipe[tipe]];
                    }
                },

                handleFileSelect(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.processFile(file);
                    }
                },

                handleDrop(e) {
                    this.isDragging = false;
                    const file = e.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const input = document.getElementById('gambar-input');
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        this.processFile(file);
                    }
                },

                processFile(file) {
                    this.formState.gambar = file;
                    this.fileInfo.name = file.name;
                    this.fileInfo.size = this.formatFileSize(file.size);

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                formatFileSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                },

                removeImage() {
                    this.formState.gambar = null;
                    this.previewUrl = '';
                    this.fileInfo = {
                        name: '',
                        size: ''
                    };
                    document.getElementById('gambar-input').value = '';
                },

                resetForm() {
                    this.formState = {
                        kode_kamar: '',
                        harga: '',
                        hargaRaw: '',
                        tipe: '',
                        lebar: '',
                        deskripsi: '',
                        gambar: null,
                        fasilitas: [],
                        touched: {
                            kode_kamar: false,
                            harga: false
                        }
                    };
                    this.removeImage();
                }
            }
        }
    </script>
@endsection
