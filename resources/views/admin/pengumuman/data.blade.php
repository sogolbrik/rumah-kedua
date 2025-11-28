@extends('layouts.admin-main')

@section('title', 'Pengumuman')

@section('admin-main')
    <div x-data="{ submitting: false }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Daftar Pengumuman -->
        <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm">
            <div class="p-5 border-b border-slate-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-800">Daftar Pengumuman</h2>
                    @if ($pengumuman->total() > 0)
                        <span class="text-xs font-medium text-slate-500">{{ $pengumuman->total() }} pengumuman</span>
                    @endif
                </div>
            </div>

            <div class="p-5">
                <ul class="space-y-4">
                    @forelse ($pengumuman as $item)
                        <li class="p-4 rounded-lg border border-slate-100 bg-slate-50 hover:bg-slate-100 transition-colors duration-200">
                            <h3 class="font-medium text-slate-800 text-sm">{{ $item->judul }}</h3>
                            <p class="mt-1 text-xs text-slate-600 leading-relaxed">{{ Str::limit($item->isi, 120) }}</p>
                            <p class="mt-2 text-[10px] text-slate-400">
                                {{ $item->created_at->format('d M Y • H:i') }}
                            </p>
                        </li>
                    @empty
                        <li class="py-10 text-center">
                            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-50 text-blue-500 mb-3">
                                <i class="fas fa-bullhorn text-xl"></i>
                            </div>
                            <p class="text-sm font-medium text-slate-700">Tidak ada pengumuman</p>
                            <p class="text-xs text-slate-500 mt-1">Buat pengumuman pertama Anda dari form di samping.</p>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- ✨ Pagination -->
            @if ($pengumuman->hasPages())
                <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                        <p class="text-sm text-slate-700 text-center sm:text-left">
                            Menampilkan
                            <span class="font-medium">{{ $pengumuman->firstItem() }}</span>
                            sampai
                            <span class="font-medium">{{ $pengumuman->lastItem() }}</span>
                            dari
                            <span class="font-medium">{{ $pengumuman->total() }}</span>
                            hasil
                        </p>
                        <div class="flex gap-1">
                            {{-- Tombol Sebelumnya --}}
                            @if ($pengumuman->onFirstPage())
                                <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                    <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                    Sebelumnya
                                </span>
                            @else
                                <a href="{{ $pengumuman->previousPageUrl() }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                    <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                    Sebelumnya
                                </a>
                            @endif

                            {{-- Tombol Selanjutnya --}}
                            @if ($pengumuman->hasMorePages())
                                <a href="{{ $pengumuman->nextPageUrl() }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                    Selanjutnya
                                    <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                    Selanjutnya
                                    <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Form Tambah Pengumuman -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5">
            <h3 class="text-lg font-semibold text-slate-800 mb-4">Buat Pengumuman Baru</h3>

            <form action="{{ route('pengumuman-admin.store') }}" method="POST" @submit="submitting = true" class="space-y-4">
                @csrf

                <div>
                    <label for="judul" class="block text-xs font-medium text-slate-600 mb-1">Judul Pengumuman</label>
                    <input type="text" id="judul" name="judul" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="Contoh: Libur Akhir Tahun" />
                </div>

                <div>
                    <label for="isi" class="block text-xs font-medium text-slate-600 mb-1">Isi Pengumuman</label>
                    <textarea id="isi" rows="4" name="isi" required
                        class="w-full rounded-lg border border-slate-200 px-3 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                        placeholder="Tulis detail pengumuman di sini..."></textarea>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="reset" class="px-4 py-2 text-sm font-medium text-slate-600 bg-slate-100 rounded-lg hover:bg-slate-200 transition-colors duration-150">
                        Batal
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 transition-all duration-200 disabled:opacity-80 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan</span>
                        <span x-show="submitting" class="flex items-center gap-1">
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
