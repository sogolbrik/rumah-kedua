@extends('layouts.admin-main')

@section('title', 'Pengumuman')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                Daftar Pengumuman
            </h1>
            <p class="mt-0.5 text-sm text-slate-600">Kelola dan buat pengumuman dengan mudah di halaman ini.</p>
        </div>
    </div>

    <div x-data="{ submitting: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daftar Pengumuman -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/40 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/30 bg-gradient-to-r from-slate-50 to-white">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-list-check text-slate-600 text-sm"></i>
                        Daftar Pengumuman
                    </h2>
                    @if ($pengumuman->total() > 0)
                        <span class="px-3 py-1 rounded-full bg-indigo-100 text-xs font-semibold text-indigo-800">
                            {{ $pengumuman->total() }} pengumuman
                        </span>
                    @endif
                </div>
            </div>

            <div class="px-6 py-5">
                <ul class="space-y-4">
                    @forelse ($pengumuman as $item)
                        <li
                            class="group relative p-4 rounded-xl border border-slate-200/40 bg-gradient-to-br from-white to-slate-50 hover:shadow-[0_4px_12px_-6px_rgba(0,0,0,0.1)] transition-all duration-250 hover:-translate-y-0.5">
                            <!-- Accent strip -->
                            <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-gradient-to-b from-indigo-400 to-purple-500 rounded-r-full"></div>

                            <div class="flex items-start justify-between pl-3">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-slate-900 group-hover:text-indigo-900 text-sm line-clamp-1">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="mt-2 text-xs text-slate-600 leading-relaxed line-clamp-2 pr-2">
                                        {{ Str::limit($item->isi, 80) }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-3">
                                    <span class="text-[10px] font-medium text-slate-500 bg-slate-100/80 px-2 py-1 rounded-lg backdrop-blur-sm">
                                        {{ $item->created_at->translatedFormat('d M Y • H:i') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-10 text-center">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-600 mb-4 mx-auto">
                                <i class="fas fa-bullhorn text-2xl"></i>
                            </div>
                            <p class="text-base font-bold text-slate-800">Belum ada pengumuman</p>
                            <p class="text-sm text-slate-500 mt-2 max-w-xs mx-auto">
                                Buat pengumuman pertama Anda dari form di samping untuk memberi tahu penghuni.
                            </p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Pagination -->
            @if ($pengumuman->hasPages())
                <div class="border-t border-slate-200/30 px-6 py-4 bg-slate-50/40">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-sm text-slate-600 text-center sm:text-left">
                            Menampilkan <span class="font-bold text-slate-800">{{ $pengumuman->firstItem() }}</span>–
                            <span class="font-bold text-slate-800">{{ $pengumuman->lastItem() }}</span> dari
                            <span class="font-bold text-slate-800">{{ $pengumuman->total() }}</span> pengumuman
                        </p>
                        <div class="flex items-center gap-2">
                            {{-- Previous --}}
                            @if ($pengumuman->onFirstPage())
                                <button disabled class="px-4 py-2 text-sm rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                    <i class="fa-solid fa-chevron-left text-xs mr-1"></i> Sebelumnya
                                </button>
                            @else
                                <a href="{{ $pengumuman->previousPageUrl() }}"
                                    class="px-4 py-2 text-sm rounded-xl bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium transition-colors shadow-sm hover:shadow">
                                    <i class="fa-solid fa-chevron-left text-xs mr-1"></i> Sebelumnya
                                </a>
                            @endif

                            {{-- Next --}}
                            @if ($pengumuman->hasMorePages())
                                <a href="{{ $pengumuman->nextPageUrl() }}"
                                    class="px-4 py-2 text-sm rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-medium shadow-sm hover:shadow-md hover:from-indigo-700 hover:to-purple-700 transition-all">
                                    Selanjutnya <i class="fa-solid fa-chevron-right text-xs ml-1"></i>
                                </a>
                            @else
                                <button disabled class="px-4 py-2 text-sm rounded-xl bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                    Selanjutnya <i class="fa-solid fa-chevron-right text-xs ml-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Tambah Pengumuman -->
        <div class="bg-gradient-to-br from-white to-indigo-50/10 rounded-2xl border border-indigo-200/30 shadow-[0_4px_20px_-8px_rgba(79,70,229,0.1)] p-6 relative overflow-hidden">
            <!-- Decorative blob -->
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-16 -left-16 w-56 h-56 bg-purple-500/5 rounded-full blur-3xl"></div>

            <div class="relative z-10 flex items-center gap-2.5 mb-5">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-md">
                    <i class="fa-solid fa-plus text-sm"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Buat Pengumuman Baru</h3>
            </div>

            <form action="{{ route('pengumuman-admin.store') }}" method="POST" @submit="submitting = true" class="space-y-5 relative z-10">
                @csrf

                <div>
                    <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2">Judul Pengumuman</label>
                    <input type="text" id="judul" name="judul" required
                        class="w-full rounded-xl border border-slate-300/60 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 focus:outline-none bg-white/90 backdrop-blur-sm transition-all duration-200 shadow-sm hover:shadow"
                        placeholder="Contoh: Pemadaman Listrik Hari Ini" />
                </div>

                <div>
                    <label for="isi" class="block text-xs font-semibold text-slate-700 mb-2">Isi Pengumuman</label>
                    <textarea id="isi" rows="5" name="isi" required
                        class="w-full rounded-xl border border-slate-300/60 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-indigo-500/40 focus:border-indigo-500 focus:outline-none bg-white/90 backdrop-blur-sm transition-all duration-200 shadow-sm hover:shadow resize-none"
                        placeholder="Tulis pesan penting untuk penghuni..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="reset" class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-150 shadow-sm hover:shadow">
                        Batal
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 focus:ring-2 focus:ring-amber-400/50 focus:ring-offset-1 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-80 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan Pengumuman</span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
