@extends('layouts.admin-main')

@section('title', 'Pengaturan Sistem')

@section('admin-main')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Sistem</h1>
            <p class="mt-1 text-sm text-slate-600">Kelola identitas visual dan informasi operasional kos Anda.</p>
        </div>

        <!-- Realtime Clock - Integrasi Halus -->
        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100/70 px-3.5 py-2 text-xs font-medium text-slate-700 backdrop-blur-sm border border-slate-200/40">
            <i class="fa-regular fa-clock text-slate-500"></i>
            <span id="realtime-clock" x-data="realtimeClock()" x-init="init()" x-text="time"></span>
            <span class="text-slate-500">WIB</span>
        </div>
    </div>

    <div x-data="settingsForm()" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-200/40">
        <div class="border-b border-slate-100 bg-slate-50/50 px-8 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-600 text-white shadow-lg shadow-slate-200">
                    <i class="fa-solid fa-gear"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Profil & Branding</h2>
                    <p class="text-xs text-slate-500">Informasi ini akan muncul di halaman publik dan struk transaksi.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">

            <div class="lg:col-span-5 border-r border-slate-100 bg-slate-50/30 p-8">
                <div class="sticky top-8 space-y-8">

                    <div class="space-y-4">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-400 px-1">Logo Identitas</label>
                        <div class="relative flex flex-col items-center justify-center rounded-2xl border border-slate-200 bg-white p-8 shadow-sm transition-all hover:shadow-md">
                            <div class="relative group">
                                @if ($pengaturan->logo)
                                    <img src="{{ Storage::url($pengaturan->logo) }}" alt="Logo Kos"
                                        class="h-40 w-40 rounded-2xl border border-slate-100 object-contain p-2 shadow-inner transition-transform duration-500 group-hover:scale-105">
                                    <form action="{{ route('pengaturan-admin.hapus-logo') }}" method="POST" class="absolute inset-0">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" onclick="konfirmasiHapusLogo()"
                                            class="absolute inset-0 flex items-center justify-center rounded-2xl bg-slate-900/60 opacity-0 transition-all duration-300 group-hover:opacity-100 backdrop-blur-[2px]">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-white/20 text-white ring-1 ring-white/30">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </div>
                                        </button>
                                    </form>
                                @else
                                    <div
                                        class="flex h-40 w-40 flex-col items-center justify-center rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 text-slate-400 transition-colors group-hover:bg-slate-100">
                                        <i class="fa-regular fa-image text-5xl opacity-20"></i>
                                        <span class="mt-3 text-[10px] font-bold uppercase">No Logo Uploaded</span>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 flex items-center gap-2 text-[11px] font-medium text-slate-400">
                                <i class="fa-solid fa-circle-info"></i>
                                <span>Rasio 1:1 disarankan untuk hasil maksimal</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-400 px-1">Pratinjau Kartu Kontak</label>
                        <div class="overflow-hidden rounded-2xl bg-gradient-to-br from-slate-600 to-slate-800 p-6 text-white shadow-lg shadow-slate-100">
                            <div class="mb-4 flex items-center justify-between opacity-80">
                                <i class="fa-solid fa-house-chimney text-xl"></i>
                                <span class="text-[10px] font-bold uppercase tracking-tighter">Business Card</span>
                            </div>
                            <h4 class="text-xl font-bold tracking-tight">{{ $pengaturan->nama_kos ?? 'Nama Kos Anda' }}</h4>
                            <div class="mt-4 space-y-2.5">
                                <div class="flex items-center gap-3 text-sm opacity-90">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-md bg-white/10">
                                        <i class="fa-solid fa-phone text-[10px]"></i>
                                    </div>
                                    <span>{{ Str::startsWith($pengaturan->no_telepon, '62') ? '0' . substr($pengaturan->no_telepon, 2) : $pengaturan->no_telepon ?? '-' }}</span>
                                </div>
                                <div class="flex items-start gap-3 text-sm opacity-90">
                                    <div class="flex h-6 w-6 items-center justify-center rounded-md bg-white/10 mt-0.5">
                                        <i class="fa-solid fa-location-dot text-[10px]"></i>
                                    </div>
                                    <span class="line-clamp-2 text-xs leading-relaxed">{{ $pengaturan->alamat_kos ?? 'Alamat belum diatur' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-7 p-8">
                <form action="{{ route('pengaturan-admin.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="rounded-2xl border border-slate-100 bg-slate-50/30 p-6">
                        <div class="mb-4 flex items-center gap-3">
                            <i class="fa-solid fa-cloud-arrow-up text-slate-600"></i>
                            <h3 class="text-sm font-bold text-slate-700">Ganti Logo Kos</h3>
                        </div>
                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="file" name="logo" accept="image/*" @change="handleLogoChange" class="absolute inset-0 z-10 h-full w-full cursor-pointer opacity-0">
                                    <div class="flex items-center justify-between rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm transition-all hover:border-slate-300">
                                        <span class="text-sm text-slate-500" x-text="logoFile ? logoFile.name : 'Pilih file logo...'"></span>
                                        <span class="rounded-lg bg-slate-50 px-3 py-1.5 text-xs font-bold text-slate-600">Browse</span>
                                    </div>
                                </div>
                                <p class="mt-2 text-[11px] leading-relaxed text-slate-400 italic">Mendukung PNG, JPG, WebP. Ukuran maksimal file adalah 2MB.</p>
                            </div>

                            <div x-show="logoPreviewUrl" x-cloak class="flex flex-col items-center shrink-0">
                                <div class="relative h-16 w-16 overflow-hidden rounded-xl border-2 border-slate-500 shadow-md ring-4 ring-slate-50">
                                    <img :src="logoPreviewUrl" class="h-full w-full object-cover">
                                </div>
                                <span class="mt-1 text-[10px] font-black text-slate-600 uppercase italic">New!</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Nama Kos</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-slate-500 transition-colors">
                                    <i class="fa-solid fa-tag text-xs"></i>
                                </div>
                                <input type="text" name="nama_kos" value="{{ old('nama_kos', $pengaturan->nama_kos) }}"
                                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 placeholder:text-slate-300"
                                    placeholder="Contoh: Kos Amanah">
                            </div>
                            <small class="text-slate-400 mx-2 font-medium">wajib 2 kata, per kata 5 huruf, jangan ada spasi</small>
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Email Business</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-slate-500 transition-colors">
                                    <i class="fa-solid fa-envelope text-xs"></i>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $pengaturan->email) }}"
                                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10"
                                    placeholder="admin@kosanda.com">
                            </div>
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Nomor Telepon / WhatsApp</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400 group-focus-within:text-slate-500 transition-colors">
                                    <i class="fa-brands fa-whatsapp text-sm"></i>
                                </div>
                                <input type="tel" name="no_telepon"
                                    value="{{ old('telepon', Str::startsWith($pengaturan->no_telepon, '62') ? '0' . substr($pengaturan->no_telepon, 2) : $pengaturan->no_telepon) }}"
                                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10">
                            </div>
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Alamat Lengkap</label>
                            <div class="relative">
                                <textarea name="alamat_kos" rows="2"
                                    class="w-full rounded-xl border border-slate-200 p-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10 resize-none">{{ old('alamat', $pengaturan->alamat_kos) }}</textarea>
                            </div>
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <label class="text-xs font-bold uppercase tracking-wider text-slate-500 ml-1">Deskripsi Footer / Slogan</label>
                            <div class="relative">
                                <textarea name="deskripsi" rows="3"
                                    class="w-full rounded-xl border border-slate-200 p-4 text-sm font-medium text-slate-700 outline-none transition-all focus:border-slate-500 focus:ring-4 focus:ring-slate-500/10">{{ old('deskripsi', $pengaturan->deskripsi) }}</textarea>
                                <div class="absolute bottom-3 right-3 text-[10px] font-bold text-slate-300">MAX 255 CHARS</div>
                            </div>
                        </div>
                    </div>

                    <button id="submit-btn" type="submit" class="hidden"></button>
                </form>
            </div>
        </div>

        <div class="border-t border-slate-100 bg-slate-50 px-8 py-5 flex items-center justify-between">
            <p class="hidden sm:block text-[11px] font-medium text-slate-400 uppercase tracking-widest">Terakhir diperbarui: {{ $pengaturan->updated_at->diffForHumans() }}</p>
            <button onclick="document.getElementById('submit-btn').click()"
                class="inline-flex w-full sm:w-auto items-center justify-center gap-2 rounded-xl bg-slate-600 px-8 py-3 font-bold text-white shadow-lg shadow-slate-200 transition-all hover:bg-slate-700 hover:shadow-xl active:scale-95">
                <i class="fa-solid fa-circle-check"></i>
                <span>Simpan Konfigurasi</span>
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
                    this.logoPreviewUrl = null;
                    this.logoFile = null;
                    if (file) {
                        if (file.size > 2 * 1024 * 1024) {
                            Swal.fire('Error', 'File terlalu besar! Maksimal 2MB.', 'error');
                            event.target.value = '';
                            return;
                        }
                        this.logoPreviewUrl = URL.createObjectURL(file);
                        this.logoFile = file;
                    }
                },
            }));
        });

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
@endsection
