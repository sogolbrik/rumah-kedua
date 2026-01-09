@extends('layouts.frontend-main')

@section('title', 'Pengaturan Profil')

@section('frontend-main')
    <div class="min-h-screen bg-slate-50/50 pb-12">
        <div class="bg-white border-b border-slate-200 mt-25 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                        <i class="fa-solid fa-arrow-left text-slate-600"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Pengaturan Akun</h1>
                        <p class="text-sm text-slate-500">Kelola informasi profil dan keamanan akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-4">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-2 sticky top-24">
                        <div class="p-4 flex items-center gap-4 border-b border-slate-100 mb-2">
                            @if (auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-12 h-12 rounded-xl object-cover">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-indigo-600 flex items-center justify-center text-white">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                            <div>
                                <h2 class="font-bold text-slate-900 leading-tight">{{ auth()->user()->name }}</h2>
                                <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                        </div>

                        <nav class="space-y-1">
                            <a href="#umum"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-all border-l-4 border-transparent hover:border-indigo-500 group">
                                <i class="fa-solid fa-address-card w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                Informasi Umum
                            </a>
                            <a href="#foto"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-all border-l-4 border-transparent hover:border-indigo-500 group">
                                <i class="fa-solid fa-image w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                Foto Profil
                            </a>
                            <a href="#keamanan"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 rounded-xl transition-all border-l-4 border-transparent hover:border-indigo-500 group">
                                <i class="fa-solid fa-shield-halved w-5 text-slate-400 group-hover:text-indigo-500"></i>
                                Keamanan Akun
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-6">

                    <div id="umum" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Informasi Umum</h3>
                            <i class="fa-solid fa-circle-info text-slate-400"></i>
                        </div>
                        <form action="{{ route('profil-penghuni.update') }}" method="POST" class="p-6 space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all outline-none text-sm text-slate-500">
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-xl font-bold text-sm transition-all shadow-sm shadow-indigo-200">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="foto" x-data="{ preview: null }" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Foto Profil</h3>
                            <i class="fa-solid fa-camera text-slate-400"></i>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('profil-penghuni.update-avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="flex flex-col md:flex-row items-center gap-8">
                                    <div class="relative group">
                                        <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-slate-100 shadow-inner">
                                            <template x-if="!preview">
                                                @if (auth()->user()->avatar)
                                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                                                        <i class="fa-solid fa-user text-3xl"></i>
                                                    </div>
                                                @endif
                                            </template>
                                            <template x-if="preview">
                                                <img :src="preview" class="w-full h-full object-cover">
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex-1 space-y-4">
                                        <div class="bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl p-4 text-center hover:border-indigo-400 transition-colors relative">
                                            <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer" @change="preview = URL.createObjectURL($event.target.files[0])">
                                            <i class="fa-solid fa-cloud-arrow-up text-slate-400 text-2xl mb-2"></i>
                                            <p class="text-xs text-slate-500 font-medium">Klik atau tarik file untuk mengganti foto</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-slate-900 text-white px-5 py-2 rounded-xl font-bold text-xs hover:bg-slate-800 transition-all">
                                                Upload Foto Baru
                                            </button>
                                            <button type="button" @click="preview = null" x-show="preview"
                                                class="text-red-600 bg-red-50 px-5 py-2 rounded-xl font-bold text-xs hover:bg-red-100 transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="keamanan" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Keamanan Akun</h3>
                            <i class="fa-solid fa-lock text-slate-400"></i>
                        </div>
                        <form action="{{ route('profil-penghuni.update-password') }}" method="POST" class="p-6 space-y-4">
                            @csrf @method('PUT')
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-700 uppercase">Password Saat Ini</label>
                                    <input type="password" name="current_password"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                    @error('current_password')
                                        <p class="text-[10px] text-red-500 font-bold uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-700 uppercase">Password Baru</label>
                                        <input type="password" name="new_password"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-slate-700 uppercase">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation"
                                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-red-500 outline-none text-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold text-sm transition-all shadow-sm shadow-red-200">
                                    Perbarui Keamanan
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <style>
        /* Halus scrolling untuk anchor links */
        html {
            scroll-behavior: smooth;
        }

        /* Custom style untuk focus state agar seragam dengan desain dashboard */
        input:focus {
            border-color: transparent !important;
        }
    </style>
@endsection
