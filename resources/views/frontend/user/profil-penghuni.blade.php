@extends('layouts.frontend-main')

@section('title', 'Pengaturan Profil')

@section('frontend-main')
    <div class="min-h-screen bg-[#fffffe] pb-12">
        <div class="bg-[#fffffe] border-b border-[#90b4ce]/30 mt-25 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-[#90b4ce]/10 rounded-full transition-colors text-[#094067]">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="text-2xl font-bold text-[#094067]">Pengaturan Akun</h1>
                        <p class="text-sm text-[#5f6c7b]">Kelola informasi profil dan keamanan akun Anda</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-4">
                    <div class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm p-2 sticky top-24">
                        <div class="p-4 flex items-center gap-4 border-b border-[#90b4ce]/20 mb-2">
                            @if (auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-12 h-12 rounded-xl object-cover border border-[#90b4ce]/20">
                            @else
                                <div class="w-12 h-12 rounded-xl bg-[#094067] flex items-center justify-center text-[#fffffe]">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                            <div>
                                <h2 class="font-bold text-[#094067] leading-tight">{{ auth()->user()->name }}</h2>
                                <span class="text-xs font-bold text-[#3da9fc] bg-[#3da9fc]/10 px-2 py-0.5 rounded-full uppercase tracking-wider">
                                    {{ auth()->user()->role }}
                                </span>
                            </div>
                        </div>

                        <nav class="space-y-1">
                            <a href="#umum"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-[#5f6c7b] hover:bg-[#90b4ce]/10 rounded-xl transition-all border-l-4 border-transparent hover:border-[#3da9fc] group">
                                <i class="fa-solid fa-address-card w-5 text-[#90b4ce] group-hover:text-[#3da9fc]"></i>
                                Informasi Umum
                            </a>
                            <a href="#foto"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-[#5f6c7b] hover:bg-[#90b4ce]/10 rounded-xl transition-all border-l-4 border-transparent hover:border-[#3da9fc] group">
                                <i class="fa-solid fa-image w-5 text-[#90b4ce] group-hover:text-[#3da9fc]"></i>
                                Foto Profil
                            </a>
                            <a href="#keamanan"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-[#5f6c7b] hover:bg-[#90b4ce]/10 rounded-xl transition-all border-l-4 border-transparent hover:border-[#3da9fc] group">
                                <i class="fa-solid fa-shield-halved w-5 text-[#90b4ce] group-hover:text-[#3da9fc]"></i>
                                Keamanan Akun
                            </a>
                        </nav>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-6">

                    <div id="umum" class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#90b4ce]/20 flex justify-between items-center bg-[#90b4ce]/5">
                            <h3 class="font-bold text-[#094067] italic uppercase tracking-wider text-sm">Informasi Umum</h3>
                            <i class="fa-solid fa-circle-info text-[#90b4ce]"></i>
                        </div>
                        <form action="{{ route('profil-penghuni.update') }}" method="POST" class="p-6 space-y-4">
                            @csrf @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-[#094067] uppercase">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                        class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#3da9fc] focus:bg-white transition-all outline-none text-sm text-[#5f6c7b]">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-[#094067] uppercase">Email</label>
                                    <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                        class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#3da9fc] focus:bg-white transition-all outline-none text-sm text-[#5f6c7b]">
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-[#3da9fc] hover:bg-[#094067] text-[#fffffe] px-6 py-2 rounded-xl font-bold text-sm transition-all shadow-md shadow-[#3da9fc]/20">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>

                    <div id="foto" x-data="{ preview: null }" class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#90b4ce]/20 flex justify-between items-center bg-[#90b4ce]/5">
                            <h3 class="font-bold text-[#094067] italic uppercase tracking-wider text-sm">Foto Profil</h3>
                            <i class="fa-solid fa-camera text-[#90b4ce]"></i>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('profil-penghuni.update-avatar') }}" method="POST" enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <div class="flex flex-col md:flex-row items-center gap-8">
                                    <div class="relative group">
                                        <div class="w-32 h-32 rounded-2xl overflow-hidden border-4 border-[#90b4ce]/10 shadow-inner bg-[#90b4ce]/5">
                                            <template x-if="!preview">
                                                @if (auth()->user()->avatar)
                                                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-[#90b4ce]">
                                                        <i class="fa-solid fa-user text-3xl"></i>
                                                    </div>
                                                @endif
                                            </template>
                                            <template x-if="preview">
                                                <img :src="preview" class="w-full h-full object-cover">
                                            </template>
                                        </div>
                                    </div>

                                    <div class="flex-1 space-y-4 w-full">
                                        <div class="bg-[#90b4ce]/5 border-2 border-dashed border-[#90b4ce]/30 rounded-2xl p-4 text-center hover:border-[#3da9fc] transition-colors relative">
                                            <input type="file" name="avatar" class="absolute inset-0 opacity-0 cursor-pointer" @change="preview = URL.createObjectURL($event.target.files[0])">
                                            <i class="fa-solid fa-cloud-arrow-up text-[#90b4ce] text-2xl mb-2"></i>
                                            <p class="text-xs text-[#5f6c7b] font-medium">Klik atau tarik file untuk mengganti foto</p>
                                        </div>
                                        <div class="flex gap-2">
                                            <button type="submit" class="bg-[#094067] text-[#fffffe] px-5 py-2 rounded-xl font-bold text-xs hover:bg-[#3da9fc] transition-all">
                                                Upload Foto Baru
                                            </button>
                                            <button type="button" @click="preview = null" x-show="preview"
                                                class="text-[#ef4565] bg-[#ef4565]/10 px-5 py-2 rounded-xl font-bold text-xs hover:bg-[#ef4565]/20 transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div id="keamanan" class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#90b4ce]/20 flex justify-between items-center bg-[#90b4ce]/5">
                            <h3 class="font-bold text-[#094067] italic uppercase tracking-wider text-sm">Keamanan Akun</h3>
                            <i class="fa-solid fa-lock text-[#90b4ce]"></i>
                        </div>
                        <form action="{{ route('profil-penghuni.update-password') }}" method="POST" class="p-6 space-y-4">
                            @csrf @method('PUT')
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-[#094067] uppercase">Password Saat Ini</label>
                                    <input type="password" name="current_password"
                                        class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#ef4565] outline-none text-sm text-[#5f6c7b]">
                                    @error('current_password')
                                        <p class="text-[10px] text-[#ef4565] font-bold uppercase">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-[#094067] uppercase">Password Baru</label>
                                        <input type="password" name="new_password"
                                            class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#ef4565] outline-none text-sm text-[#5f6c7b]">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="text-xs font-bold text-[#094067] uppercase">Konfirmasi Password Baru</label>
                                        <input type="password" name="new_password_confirmation"
                                            class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-[#ef4565] outline-none text-sm text-[#5f6c7b]">
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-end pt-4">
                                <button type="submit" class="bg-[#ef4565] hover:bg-[#094067] text-[#fffffe] px-6 py-2 rounded-xl font-bold text-sm transition-all shadow-md shadow-[#ef4565]/20">
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
        html {
            scroll-behavior: smooth;
        }

        input:focus {
            border-color: transparent !important;
        }

        /* Custom selection color */
        ::selection {
            background-color: #3da9fc;
            color: #fffffe;
        }
    </style>
@endsection
