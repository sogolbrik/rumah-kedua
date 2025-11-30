@extends('layouts.admin-main')

@section('title', 'Pengumuman')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Pengumuman</h1>
            <p class="mt-0.5 text-sm text-slate-600">Kelola dan buat pengumuman dengan mudah di halaman ini.</p>
        </div>
    </div>

    <div x-data="{ submitting: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daftar Pengumuman -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-200/40">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h2 class="text-lg font-bold text-slate-800">Daftar Pengumuman</h2>
                    @if ($pengumuman->total() > 0)
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 text-xs font-medium text-slate-600">
                            {{ $pengumuman->total() }} pengumuman
                        </span>
                    @endif
                </div>
            </div>

            <div class="px-6 py-5">
                <ul class="space-y-4">
                    @forelse ($pengumuman as $item)
                        <li class="p-4 rounded-xl border border-slate-200/50 bg-slate-50 hover:bg-slate-100/70 transition-all duration-200 group">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h3 class="font-semibold text-slate-800 group-hover:text-slate-900 text-sm">{{ $item->judul }}</h3>
                                    <p class="mt-1.5 text-xs text-slate-600 leading-relaxed pr-1">
                                        {{ Str::limit($item->isi, 70) }}
                                    </p>
                                </div>
                                <div class="flex-shrink-0 ml-3">
                                    <span class="text-[10px] text-slate-400 bg-white/60 px-2 py-1 rounded-lg">
                                        {{ $item->created_at->format('d M Y • H:i') }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-12 text-center">
                            <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-blue-100 text-blue-600 mb-4">
                                <i class="fas fa-bullhorn text-2xl"></i>
                            </div>
                            <p class="text-base font-semibold text-slate-800">Belum ada pengumuman</p>
                            <p class="text-sm text-slate-500 mt-1 max-w-xs mx-auto">
                                Buat pengumuman pertama Anda dari form di samping untuk memberi tahu penghuni.
                            </p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Pagination -->
            @if ($pengumuman->hasPages())
                <div class="border-t border-slate-200/40 px-6 py-4 bg-slate-50/50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-sm text-slate-600 text-center sm:text-left">
                            Menampilkan <span class="font-medium text-slate-800">{{ $pengumuman->firstItem() }}</span>–
                            <span class="font-medium text-slate-800">{{ $pengumuman->lastItem() }}</span> dari
                            <span class="font-medium text-slate-800">{{ $pengumuman->total() }}</span> pengumuman
                        </p>
                        <div class="flex items-center gap-2">
                            {{-- Previous --}}
                            @if ($pengumuman->onFirstPage())
                                <button disabled class="flex items-center gap-1.5 px-3.5 py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                                </button>
                            @else
                                <a href="{{ $pengumuman->previousPageUrl() }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 text-sm rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors">
                                    <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                                </a>
                            @endif

                            {{-- Next --}}
                            @if ($pengumuman->hasMorePages())
                                <a href="{{ $pengumuman->nextPageUrl() }}"
                                    class="flex items-center gap-1.5 px-3.5 py-2 text-sm rounded-lg bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-colors">
                                    Selanjutnya <i class="fa-solid fa-chevron-right text-xs"></i>
                                </a>
                            @else
                                <button disabled class="flex items-center gap-1.5 px-3.5 py-2 text-sm rounded-lg bg-slate-100 text-slate-400 cursor-not-allowed">
                                    Selanjutnya <i class="fa-solid fa-chevron-right text-xs"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Tambah Pengumuman -->
        <div class="bg-gradient-to-b from-white to-slate-50 rounded-2xl border border-slate-200/60 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-5">
                <div class="h-8 w-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                    <i class="fa-solid fa-plus text-sm"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Buat Pengumuman Baru</h3>
            </div>

            <form action="{{ route('pengumuman-admin.store') }}" method="POST" @submit="submitting = true" class="space-y-5">
                @csrf

                <div>
                    <label for="judul" class="block text-xs font-semibold text-slate-700 mb-2">Judul Pengumuman</label>
                    <input type="text" id="judul" name="judul" required
                        class="w-full rounded-xl border border-slate-200/70 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:outline-none bg-white/80 backdrop-blur-sm transition"
                        placeholder="Contoh: Pemadaman Listrik Hari Ini" />
                </div>

                <div>
                    <label for="isi" class="block text-xs font-semibold text-slate-700 mb-2">Isi Pengumuman</label>
                    <textarea id="isi" rows="5" name="isi" required
                        class="w-full rounded-xl border border-slate-200/70 px-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-blue-500/30 focus:border-blue-500 focus:outline-none bg-white/80 backdrop-blur-sm transition resize-none"
                        placeholder="Tulis pesan penting untuk penghuni..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="reset" class="px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors duration-150">
                        Batal
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl hover:from-blue-700 hover:to-indigo-700 focus:ring-2 focus:ring-blue-400/50 focus:ring-offset-1 transition-all duration-200 shadow-sm disabled:opacity-80 disabled:cursor-not-allowed">
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
