@extends('layouts.admin-main')

@section('title', 'Profil')

@section('admin-main')
    <div class="p-6">
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
                <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden transition-all hover:shadow-md">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-5 border-b border-slate-200/40">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 bg-green-100 rounded-xl flex items-center justify-center text-green-700">
                                <i class="fa-solid fa-camera text-base"></i>
                            </div>
                            <div>
                                <h2 class="font-semibold text-slate-900">Foto Profil</h2>
                                <p class="text-xs text-slate-600 mt-0.5">Unggah gambar profil baru</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('profil-admin.update-avatar') }}" method="POST" enctype="multipart/form-data" class="space-y-6" x-data="{ preview: null }">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
                                <!-- Preview Saat Ini -->
                                <div class="text-center">
                                    <p class="text-sm font-medium text-slate-800 mb-3">Foto Saat Ini</p>
                                    @if (auth()->check() && auth()->user()->avatar)
                                        <div class="w-36 h-36 mx-auto rounded-2xl overflow-hidden border-2 border-slate-200">
                                            <img src="{{ Storage::url(auth()->user()->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                        </div>
                                    @else
                                        <div class="w-36 h-36 mx-auto rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400">
                                            <i class="fa-solid fa-user text-4xl"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Upload & Preview Baru -->
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-800 mb-2">Pilih Gambar Baru</label>
                                        <input type="file" name="avatar" id="avatar" accept="image/*"
                                            class="w-full text-sm text-slate-600 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition"
                                            @change="preview = URL.createObjectURL($event.target.files[0])">
                                    </div>

                                    <!-- Preview Baru -->
                                    <div x-show="preview" class="mt-3">
                                        <p class="text-sm font-medium text-slate-800 mb-2">Preview Baru</p>
                                        <div class="w-36 h-36 mx-auto rounded-2xl overflow-hidden border-2 border-dashed border-slate-300">
                                            <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                class="px-5 py-3 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium rounded-xl shadow-sm hover:shadow-md transition-all">
                                <i class="fa-solid fa-upload mr-2"></i> Unggah Foto
                            </button>
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
    </div>
@endsection
