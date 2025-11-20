@extends('layouts.admin-main')

@section('title', 'Galeri')

@section('admin-main')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Galeri Gambar</h1>
            <p class="mt-1 text-sm text-slate-600">Kelola semua gambar galeri kamar dengan mudah.</p>
        </div>
        <a href="{{ Route('galeri.create') }}">
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah Gambar
            </button>
        </a>
    </div>

    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($galeri as $item)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
                <div class="aspect-w-16 aspect-h-12 bg-slate-100 overflow-hidden">
                    <img src="{{ Storage::url($item->gambar) }}" alt="Galeri Image" class="w-full h-48 object-cover hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-xs text-slate-700">#{{ $loop->iteration }}</span>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                            <i class="fa-solid fa-trash text-xs"></i>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-slate-400 mb-4">
                    <i class="fa-solid fa-image text-4xl"></i>
                </div>
                <p class="text-slate-500 text-lg mb-2">Tidak ada gambar galeri</p>
                <p class="text-slate-400 text-sm">Tambahkan gambar pertama Anda untuk memulai</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination (jika menggunakan paginate) -->
    @if (isset($galeri) && $galeri->hasPages())
        <div class="mt-6 border-t border-slate-200 pt-6">
            <div class="flex items-center justify-between">
                <p class="text-sm text-slate-700">
                    Menampilkan
                    <span class="font-medium">{{ $galeri->firstItem() }}</span>
                    sampai
                    <span class="font-medium">{{ $galeri->lastItem() }}</span>
                    dari
                    <span class="font-medium">{{ $galeri->total() }}</span>
                    gambar
                </p>
                <div class="flex gap-1">
                    @if ($galeri->onFirstPage())
                        <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $galeri->previousPageUrl() }}"
                            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                            Sebelumnya
                        </a>
                    @endif

                    @if ($galeri->hasMorePages())
                        <a href="{{ $galeri->nextPageUrl() }}"
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
@endsection
