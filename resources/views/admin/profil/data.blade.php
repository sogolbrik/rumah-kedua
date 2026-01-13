@extends('layouts.admin-main')

@section('title', 'Profil')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Akun Saya</h1>
            <p class="mt-1 text-sm text-slate-600">Kelola profil, avatar, dan keamanan akun Anda</p>
        </div>

        <!-- Avatar Card (Inline) -->
        <div class="flex items-center gap-4 p-3">
            @if (auth()->check() && auth()->user()->avatar)
                <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-14 h-14 rounded-full object-cover border-2 border-slate-200">
            @else
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white">
                    <i class="fa-solid fa-user"></i>
                </div>
            @endif
            <div class="text-left">
                <p class="font-semibold text-slate-900 text-sm">{{ auth()->user()->name ?? 'Admin Kos' }}</p>
                <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role ?? 'Admin' }}</p>
            </div>
        </div>
    </div>

    <!-- Grid Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Profil & Avatar -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Card Profil -->
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden transition-all hover:shadow-md">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-5 border-b border-slate-200/40">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-blue-100 rounded-xl flex items-center justify-center text-blue-700">
                            <i class="fa-solid fa-user text-base"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-slate-900">Informasi Profil</h2>
                            <p class="text-xs text-slate-600 mt-0.5">Perbarui nama dan email Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('profil-admin.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-800 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name ?? 'Admin Kos') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('name')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-800 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email ?? 'admin@kos.com') }}"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                            @error('email')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="px-5 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all">
                            <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Card Avatar -->
            <div class="bg-white rounded-3xl border border-slate-200/70 shadow-sm overflow-hidden transition-all duration-300 hover:shadow-xl hover:shadow-slate-200/50">
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-6 border-b border-slate-100">
                    <div class="flex items-center gap-4">
                        <div class="h-12 w-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-emerald-200">
                            <i class="fa-solid fa-camera-retro text-lg"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-lg">Foto Profil</h2>
                            <p class="text-xs text-slate-500">Perbarui identitas visual akun Anda</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form action="{{ route('profil-admin.update-avatar') }}" method="POST" enctype="multipart/form-data" class="space-y-8" x-data="{ preview: null }">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col lg:flex-row items-center gap-10">
                            <div class="relative group">
                                <div class="absolute -inset-1 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-full blur opacity-25 group-hover:opacity-40 transition duration-300"></div>

                                <div class="relative flex flex-col items-center">
                                    <span class="absolute -top-3 px-3 py-1 bg-white border border-slate-200 rounded-full text-[10px] font-bold uppercase tracking-wider text-slate-400 shadow-sm z-10">
                                        Profil Anda
                                    </span>

                                    <div class="w-40 h-40 rounded-full p-1.5 bg-white border border-slate-200 shadow-inner">
                                        @if (auth()->check() && auth()->user()->avatar)
                                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover shadow-sm">
                                        @else
                                            <div class="w-full h-full rounded-full bg-slate-50 flex items-center justify-center text-slate-300">
                                                <i class="fa-solid fa-user text-5xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 w-full space-y-6">
                                <div class="p-6 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50/50 hover:bg-white hover:border-emerald-300 transition-all duration-300">
                                    <label class="block text-sm font-semibold text-slate-700 mb-3">Pilih File Gambar</label>

                                    <input type="file" name="avatar" id="avatar" accept="image/*"
                                        class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2.5 file:px-6
                            file:rounded-xl file:border-0
                            file:text-sm file:font-bold
                            file:bg-emerald-600 file:text-white
                            hover:file:bg-emerald-700 file:cursor-pointer
                            file:transition-all file:duration-200"
                                        @change="preview = URL.createObjectURL($event.target.files[0])">

                                    <p class="mt-3 text-[11px] text-slate-400 flex items-center gap-1.5">
                                        <i class="fa-solid fa-circle-info"></i>
                                        Format yang didukung: JPG, PNG, atau WEBP. Maksimal 2MB.
                                    </p>
                                </div>

                                <div x-show="preview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                                    class="flex items-center gap-4 p-4 rounded-2xl bg-emerald-50 border border-emerald-100">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden border-2 border-white shadow-sm flex-shrink-0">
                                        <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-emerald-800">Preview Berhasil!</p>
                                        <p class="text-xs text-emerald-600/80">Klik tombol simpan di bawah untuk menerapkan perubahan.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end">
                            <button type="submit"
                                class="group flex items-center gap-2 px-8 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                Simpan Foto Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

        <!-- Kolom Kanan: Keamanan -->
        <div class="space-y-8">
            <!-- Card Keamanan -->
            <div class="bg-gradient-to-b from-amber-50 to-orange-50 border border-amber-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="bg-gradient-to-r from-amber-400 to-orange-400 p-5">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center text-white">
                            <i class="fa-solid fa-shield text-base"></i>
                        </div>
                        <div>
                            <h2 class="font-semibold text-white">Keamanan Akun</h2>
                            <p class="text-xs text-amber-100 mt-0.5">Perbarui password Anda</p>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <form action="{{ route('profil-admin.update-password') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-slate-800 mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @error('current_password')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password" class="block text-sm font-medium text-slate-800 mb-2">Password Baru</label>
                            <input type="password" name="new_password" id="new_password"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @error('new_password')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-slate-800 mb-2">Konfirmasi Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            @error('new_password_confirmation')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full px-5 py-3 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all">
                            <i class="fa-solid fa-lock mr-2"></i> Perbarui Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tips Keamanan -->
            <div class="bg-white border border-slate-200/60 rounded-xl p-5">
                <div class="flex items-start gap-3">
                    <div class="mt-0.5 h-5 w-5 text-slate-500">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                    <div class="text-sm text-slate-700">
                        <p class="font-medium text-slate-900">Tips Keamanan</p>
                        <ul class="list-disc list-inside mt-1 space-y-1 text-slate-600">
                            <li>Gunakan password minimal 8 karakter</li>
                            <li>Kombinasikan huruf, angka, dan simbol</li>
                            <li>Jangan gunakan password yang sama di platform lain</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
