@extends('layouts.admin-main')

@section('title', 'Tambah User')

@section('admin-main')
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100/50 pt-0 pb-8" x-data="userForm()">
        <div class="w-full">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Tambah User Baru</h1>
                    <p class="mt-1 text-sm text-slate-600">Lengkapi informasi user dengan detail yang akurat</p>
                </div>
                <a href="{{ route('user.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

            <form id="form-user" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                @csrf

                <div class="border-b border-slate-200 bg-gradient-to-r from-cyan-50 to-blue-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-600 text-white shadow-lg">
                            <i class="fa-solid fa-user-plus"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Informasi Dasar</h2>
                            <p class="text-sm text-slate-600">Data utama user yang wajib diisi</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="group">
                            <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nama Lengkap <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-user text-sm"></i>
                                </div>
                                <input id="name" name="name" type="text" required placeholder="Masukkan nama lengkap" x-model="formState.name" @blur="formState.touched.name = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                            </div>
                            <p x-cloak x-show="formState.touched.name && !formState.name" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Nama wajib diisi
                            </p>
                        </div>

                        <div class="group">
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                Email <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-envelope text-sm"></i>
                                </div>
                                <input id="email" name="email" type="email" required placeholder="user@example.com" x-model="formState.email" @blur="formState.touched.email = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                            </div>
                            <p x-cloak x-show="formState.touched.email && !formState.email" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Email wajib diisi
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div class="group">
                            <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">
                                Password <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required placeholder="Minimal 8 karakter" x-model="formState.password"
                                    @blur="formState.touched.password = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-12 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                                <button type="button" @click="showPassword = !showPassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition-colors hover:text-slate-600">
                                    <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <p x-cloak x-show="formState.touched.password && !formState.password" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Password wajib diisi
                            </p>
                            <p x-cloak x-show="formState.password && formState.password.length < 8" class="mt-1 text-xs font-medium text-amber-600">
                                <i class="fa-solid fa-triangle-exclamation"></i> Password minimal 8 karakter
                            </p>
                        </div>

                        <div class="group">
                            <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">
                                Konfirmasi Password <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <input id="password_confirmation" name="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" required placeholder="Ulangi password"
                                    x-model="formState.password_confirmation" @blur="formState.touched.password_confirmation = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-12 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                                <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                    class="absolute inset-y-0 right-0 flex items-center px-4 text-slate-400 transition-colors hover:text-slate-600">
                                    <i class="fa-solid" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                                </button>
                            </div>
                            <p x-cloak x-show="formState.touched.password_confirmation && !formState.password_confirmation" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Konfirmasi password wajib diisi
                            </p>
                            <p x-cloak x-show="formState.password_confirmation && formState.password !== formState.password_confirmation" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Password tidak cocok
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Informasi Akun</h2>
                            <p class="text-sm text-slate-600">Data yang berkaitan dengan identitas dan hak akses pengguna</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label for="telepon" class="mb-2 block text-sm font-semibold text-slate-700">
                                Nomor Telepon <span class="text-slate-400">(opsional)</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-phone text-sm"></i>
                                </div>
                                <input id="telepon" name="telepon" type="tel" placeholder="081234567890" x-model="formState.telepon"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10" />
                            </div>
                        </div>
                        <div>
                            <label for="role" class="mb-2 block text-sm font-semibold text-slate-700">
                                Role User <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                    <i class="fa-solid fa-user-shield text-sm"></i>
                                </div>
                                <select id="role" name="role" x-model="formState.role" @blur="formState.touched.role = true"
                                    class="w-full rounded-xl border-2 border-slate-200 bg-white py-3 pl-11 pr-4 text-sm font-medium text-slate-900 placeholder:text-slate-400 transition-all focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/10">
                                    <option value="" selected disabled>- Pilih Role -</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <p x-cloak x-show="formState.touched.role && !formState.role" class="mt-1 text-xs font-medium text-rose-600">
                                <i class="fa-solid fa-circle-exclamation"></i> Role wajib dipilih
                            </p>
                        </div>
                    </div>
                </div>

                <div class="border-y border-slate-200 bg-gradient-to-r from-amber-50 to-orange-50 px-8 py-6">
                    <div class="flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-600 text-white shadow-lg">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">Upload Foto</h2>
                            <p class="text-sm text-slate-600">Foto profil user (opsional)</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 px-8 py-8">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Upload Avatar -->
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">
                                Foto Profil <span class="text-slate-400">(opsional)</span>
                            </label>
                            <div id="avatar-drop-zone" @dragover.prevent="isAvatarDragging = true" @dragleave.prevent="isAvatarDragging = false" @drop.prevent="handleAvatarDrop"
                                :class="isAvatarDragging ? 'border-cyan-500 bg-cyan-100/50' : ''"
                                class="group relative overflow-hidden rounded-xl border-2 border-dashed border-slate-300 bg-slate-50/50 transition-all hover:border-cyan-400 hover:bg-cyan-50/50">
                                <input type="file" name="avatar" accept="image/*" id="avatar-input" class="hidden" @change="handleAvatarSelect">

                                <div x-show="!formState.avatar" class="flex flex-col items-center justify-center px-6 py-8 text-center">
                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-cyan-500 to-blue-600 text-white shadow-lg shadow-cyan-500/30">
                                        <i class="fa-solid fa-user text-lg"></i>
                                    </div>
                                    <button type="button" @click="document.getElementById('avatar-input').click()"
                                        class="mb-2 inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                                        <i class="fa-solid fa-image"></i>
                                        Pilih Foto
                                    </button>
                                    <p class="text-xs text-slate-500">PNG, JPG, WEBP hingga 2MB</p>
                                </div>

                                <div x-cloak x-show="formState.avatar" class="relative">
                                    <img :src="avatarPreviewUrl" alt="Preview Avatar" class="h-48 w-full object-cover" />
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                    <button type="button" @click="removeAvatar"
                                        class="absolute right-3 top-3 flex h-8 w-8 items-center justify-center rounded-xl bg-white/90 text-slate-700 shadow-lg backdrop-blur-sm transition-all hover:bg-white hover:text-rose-600">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                    <div class="absolute bottom-3 left-3 right-3">
                                        <p x-text="avatarFileInfo.name" class="text-sm font-semibold text-white"></p>
                                        <p x-text="avatarFileInfo.size" class="text-xs text-white/80"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            Simpan User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function userForm() {
            return {
                formState: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    telepon: '',
                    role: '',
                    avatar: null,
                    touched: {
                        name: false,
                        email: false,
                        password: false,
                        password_confirmation: false,
                        role: false
                    }
                },
                showPassword: false,
                showConfirmPassword: false,
                isAvatarDragging: false,

                avatarPreviewUrl: '',
                avatarFileInfo: {
                    name: '',
                    size: ''
                },

                get isFormValid() {
                    return this.formState.name.trim() !== '' &&
                        this.formState.email.trim() !== '' &&
                        this.formState.password.trim() !== '' &&
                        this.formState.password_confirmation.trim() !== '' &&
                        this.formState.password === this.formState.password_confirmation &&
                        this.formState.password.length >= 8 &&
                        this.formState.role.trim() !== '';
                },

                handleAvatarSelect(e) {
                    const file = e.target.files[0];
                    if (file) {
                        this.processAvatarFile(file);
                    }
                },

                handleAvatarDrop(e) {
                    this.isAvatarDragging = false;
                    const file = e.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const input = document.getElementById('avatar-input');
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(file);
                        input.files = dataTransfer.files;
                        this.processAvatarFile(file);
                    }
                },

                processAvatarFile(file) {
                    this.formState.avatar = file;
                    this.avatarFileInfo.name = file.name;
                    this.avatarFileInfo.size = this.formatFileSize(file.size);

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.avatarPreviewUrl = e.target.result;
                    };
                    reader.readAsDataURL(file);
                },

                removeAvatar() {
                    this.formState.avatar = null;
                    this.avatarPreviewUrl = '';
                    this.avatarFileInfo = {
                        name: '',
                        size: ''
                    };
                    document.getElementById('avatar-input').value = '';
                },

                formatFileSize(bytes) {
                    if (bytes < 1024) return bytes + ' B';
                    if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
                    return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
                },

                resetForm() {
                    this.formState = {
                        name: '',
                        email: '',
                        password: '',
                        password_confirmation: '',
                        telepon: '',
                        role: '',
                        avatar: null,
                        touched: {
                            name: false,
                            email: false,
                            password: false,
                            password_confirmation: false,
                            role: false
                        }
                    };
                    this.removeAvatar();
                    this.showPassword = false;
                    this.showConfirmPassword = false;
                }
            }
        }
    </script>
@endsection
