@extends('layouts.admin-main')

@section('title', 'Pengaturan Sistem')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Sistem</h1>
            <p class="mt-1 text-sm text-slate-600">Atur semua pengaturan</p>
        </div>

        <!-- Realtime Clock - Integrasi Halus -->
        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100/70 px-3.5 py-2 text-xs font-medium text-slate-700 backdrop-blur-sm border border-slate-200/40">
            <i class="fa-regular fa-clock text-slate-500"></i>
            <span id="realtime-clock" x-data="realtimeClock()" x-init="init()" x-text="time"></span>
            <span class="text-slate-500">WIB</span>
        </div>
    </div>

    <!-- Form Pengaturan -->
    <div x-data="settingsForm()" class="bg-white rounded-xl shadow-sm border border-slate-200/60 overflow-hidden">
        <!-- Header Form -->
        <div class="px-6 py-4 border-b border-slate-200/60 bg-gradient-to-r from-slate-50 to-slate-100/50">
            <h2 class="text-lg font-semibold text-slate-800">Informasi Kos</h2>
            <p class="text-sm text-slate-600 mt-1">Edit detail profil dan branding kos Anda</p>
        </div>

        <!-- Konten Utama -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Bagian Kiri: Preview Logo & Informasi -->
            <div class="space-y-6">
                <!-- Preview Logo -->
                <div class="bg-gradient-to-br from-indigo-50 to-cyan-50 p-6 rounded-xl border border-indigo-100/50 shadow-sm">
                    <h3 class="text-sm font-medium text-slate-700 mb-3">Logo Saat Ini</h3>
                    <div class="flex flex-col items-center">
                        <div class="relative group">
                            @if ($pengaturan->logo)
                                <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo Kos"
                                    class="w-32 h-32 object-contain rounded-lg border-2 border-slate-200/50 shadow-sm transition-all duration-300 group-hover:shadow-md group-hover:scale-[1.02]">
                                <form action="{{ route('pengaturan-admin.hapus-logo') }}" method="POST" class="absolute inset-0">
                                    @csrf
                                    @method('PUT')
                                    <button type="button" onclick="konfirmasiHapusLogo()"
                                        class="absolute inset-0 bg-black/30 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-trash text-white/50 text-xl"></i>
                                    </button>
                                </form>
                                <script>
                                    function konfirmasiHapusLogo() {
                                        Swal.fire({
                                            title: 'Hapus Logo?',
                                            html: `
                                                <div class="text-center">
                                                    <p class="text-slate-700 mb-2">Anda akan menghapus logo kos.</p>
                                                    <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
                                                </div>
                                            `,
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonColor: '#dc2626',
                                            cancelButtonColor: '#6b7280',
                                            confirmButtonText: '<i class="fa-solid fa-trash mr-2"></i>Ya, Hapus',
                                            cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Batal',
                                            reverseButtons: true,
                                            buttonsStyling: false,
                                            customClass: {
                                                confirmButton: 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2',
                                                cancelButton: 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
                                            }
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                document.querySelector('form[action="{{ route('pengaturan-admin.hapus-logo') }}"]').submit();
                                            }
                                        });
                                    }
                                </script>
                            @else
                                <div
                                    class="w-32 h-32 rounded-lg border-2 border-slate-200/50 shadow-sm bg-slate-100 flex flex-col items-center justify-center transition-all duration-300 group-hover:shadow-md group-hover:scale-[1.02]">
                                    <i class="fa-regular fa-image text-slate-400 text-5xl"></i>
                                    <span class="mt-2 text-xs text-slate-500">Belum ada logo</span>
                                </div>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-3">Klik logo untuk menghapus</p>
                    </div>
                </div>

                <!-- Preview Info Kos -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-6 rounded-xl border border-emerald-100/50 shadow-sm">
                    <h3 class="text-sm font-medium text-slate-700 mb-3">Pratinjau Publik</h3>
                    <div class="space-y-2">
                        <h4 class="font-bold text-slate-800 text-lg">{{ $pengaturan->nama_kos ?? 'Nama Kos' }}</h4>
                        <p class="text-slate-600 text-sm flex items-center gap-1.5">
                            <i class="fa-solid fa-phone text-emerald-500"></i>
                            <span>{{ $pengaturan->no_telepon ?? '6285870327957' }}</span>
                        </p>
                        <p class="text-slate-600 text-sm flex items-start gap-1.5">
                            <i class="fa-solid fa-envelope text-emerald-500 mt-0.5"></i>
                            <span>{{ $pengaturan->email ?? 'rumahkedua@gmail.com' }}</span>
                        </p>
                        <p class="text-slate-600 text-sm flex items-start gap-1.5">
                            <i class="fa-solid fa-location-dot text-emerald-500 mt-0.5"></i>
                            <span>{{ $pengaturan->alamat_kos ?? 'Jl. Raya Kutorejo No. 45, Kutorejo, Mojokerto, Jawa Timur 61383' }}</span>
                        </p>
                        <p class="text-slate-600 text-sm mt-3">{{ $pengaturan->deskripsi ?? 'Temukan kenyamanan seperti di rumah sendiri dengan layanan terbaik dan fasilitas lengkap.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Form Edit -->
            <div class="space-y-6">
                <form action="{{ route('pengaturan-admin.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Upload Logo -->
                    <div class="border border-dashed border-slate-300/50 rounded-xl p-5 bg-slate-50/30 transition-all hover:bg-slate-50">
                        <h3 class="text-sm font-medium text-slate-700 mb-3">Ganti Logo Kos</h3>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="flex-1">
                                <label class="block mb-2 text-sm text-slate-600">Pilih File Baru</label>
                                <input type="file" name="logo" accept="image/*"
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-lg file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100
                                    transition-colors"
                                    @change="handleLogoChange">
                                <p class="text-xs text-slate-500 mt-1">Format: PNG, JPG, WebP. Maks 2MB</p>
                            </div>
                            <div class="flex items-center justify-center">
                                <!-- Pratinjau Gambar Baru (Hanya Muncul Jika File Dipilih) -->
                                <div class="relative group" x-cloak x-show="logoPreviewUrl">
                                    <img :src="logoPreviewUrl" alt="Pratinjau Logo" class="w-16 h-16 object-contain rounded-lg border border-slate-200 shadow-sm">
                                    <div class="absolute inset-0 bg-black/30 rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fa-solid fa-eye text-white text-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nama Kos</label>
                            <input type="text" name="nama_kos" value="{{ old('nama_kos', $pengaturan->nama_kos) }}"
                                class="w-full rounded-lg border border-slate-300/50 px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}"
                                class="w-full rounded-lg border border-slate-300/50 px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                            <input type="tel" name="no_telepon" value="{{ old('telepon', $pengaturan->no_telepon) }}"
                                class="w-full rounded-lg border border-slate-300/50 px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors">
                            <small class="text-slate-400">Otomatis terformat sistem</small>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Kos</label>
                            <textarea name="alamat_kos" rows="3"
                                class="w-full rounded-lg border border-slate-300/50 px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors resize-y">{{ old('alamat', $pengaturan->alamat_kos) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi / Footer</label>
                            <textarea name="deskripsi" rows="4"
                                class="w-full rounded-lg border border-slate-300/50 px-4 py-2.5 text-slate-700 focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors resize-y">{{ old('deskripsi', $pengaturan->deskripsi) }}</textarea>
                        </div>
                    </div>

                    <button id="submit-btn" type="submit" class="hidden"></button>
                </form>
            </div>
        </div>

        <!-- Footer Form -->
        <div class="px-6 py-4 border-t border-slate-200/60 bg-slate-50/30 flex justify-end">
            <button onclick="document.getElementById('submit-btn').click()"
                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors">
                <i class="fa-solid fa-save"></i>
                <span>Simpan Perubahan</span>
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('realtimeClock', () => ({
                time: '',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    const now = new Date();
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    };
                    this.time = now.toLocaleString('id-ID', options);
                }
            }));

            Alpine.data('settingsForm', () => ({
                logoPreviewUrl: null,
                logoFile: null,

                handleLogoChange(event) {
                    const file = event.target.files[0];
                    this.logoPreviewUrl = null; // Reset pratinjau sebelumnya
                    this.logoFile = null; // Reset file sebelumnya

                    if (file) {
                        if (file.size > 2 * 1024 * 1024) { // 2MB
                            alert('File terlalu besar! Maksimal 2MB.');
                            event.target.value = ''; // Reset input file di UI
                            return;
                        }
                        this.logoPreviewUrl = URL.createObjectURL(file);
                        this.logoFile = file;
                    }
                },
            }));
        });
    </script>
@endsection
