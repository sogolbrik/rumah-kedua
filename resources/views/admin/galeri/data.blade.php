@extends('layouts.admin-main')

@section('title', 'Galeri')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Galeri Gambar</h1>
            <p class="mt-0.5 text-sm text-slate-600">Kelola semua gambar galeri kamar dengan mudah.</p>
        </div>
        <div>
            <a href="{{ route('galeri.create') }}">
                <button
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fa-solid fa-plus-circle text-sm"></i>
                    Tambah Gambar
                </button>
            </a>
        </div>
    </div>

    <!-- Alpine.js Zoom Modal -->
    <div x-data="{ zoomedImage: null }">
        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-5">
            @forelse($galeri as $item)
                <div class="group relative rounded-xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:shadow-lg overflow-hidden">
                    <div class="aspect-w-16 aspect-h-12 bg-slate-50">
                        <img src="{{ Storage::url($item->gambar) }}" alt="Galeri Image" class="h-48 w-full cursor-pointer object-cover transition-transform duration-300 group-hover:scale-105"
                            @click="zoomedImage = '{{ Storage::url($item->gambar) }}'" loading="lazy">
                    </div>
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-xs font-medium text-slate-700">#{{ ($galeri->currentPage() - 1) * $galeri->perPage() + $loop->iteration }}</span>
                        </div>
                        <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" class="inline-block" id="hapus-data-{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button"
                                class="w-full inline-flex items-center justify-center gap-1.5 rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-medium text-red-700 transition-colors hover:bg-red-100 hover:border-red-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                onclick="konfirmasiHapusGaleri({{ $item->id }})">
                                <i class="fa-solid fa-trash text-xs"></i>
                                Hapus Gambar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                        <i class="fa-solid fa-images text-2xl"></i>
                    </div>
                    <p class="text-slate-600 text-lg font-medium mb-1">Tidak ada gambar galeri</p>
                    <p class="text-slate-500 text-sm">Tambahkan gambar pertama Anda untuk memulai</p>
                </div>
            @endforelse
        </div>

        <!-- Zoom Modal -->
        <div x-show="zoomedImage" x-on:click="zoomedImage = null" x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm" style="display: none;" x-cloak>
            <div x-on:click.stop class="relative max-w-[90vw] max-h-[90vh] flex items-center justify-center">
                <img :src="zoomedImage" alt="Zoomed image" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl object-contain">
                <button @click="zoomedImage = null" class="absolute -top-12 right-0 text-white bg-black/40 hover:bg-black/60 rounded-full p-2 transition-colors" aria-label="Close zoom">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Pagination (tidak diubah) -->
    @if (isset($galeri) && $galeri->hasPages())
        <div class="mt-8 border-t border-slate-200 pt-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-slate-700">
                    Menampilkan
                    <span class="font-medium">{{ $galeri->firstItem() }}</span>
                    sampai
                    <span class="font-medium">{{ $galeri->lastItem() }}</span>
                    dari
                    <span class="font-medium">{{ $galeri->total() }}</span>
                    gambar
                </p>
                <div class="flex gap-1.5">
                    @if ($galeri->onFirstPage())
                        <span class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                            Sebelumnya
                        </span>
                    @else
                        <a href="{{ $galeri->previousPageUrl() }}"
                            class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-chevron-left text-xs"></i>
                            Sebelumnya
                        </a>
                    @endif

                    @if ($galeri->hasMorePages())
                        <a href="{{ $galeri->nextPageUrl() }}"
                            class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                            Selanjutnya
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1 px-3.5 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                            Selanjutnya
                            <i class="fa-solid fa-chevron-right text-xs"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <script>
        function konfirmasiHapusGaleri(id) {
            Swal.fire({
                title: 'Hapus Gambar Galeri?',
                html: `
                    <div class="text-center">
                        <p class="text-slate-700 mb-2">Anda akan menghapus gambar ini dari galeri</p>
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
                    document.getElementById('hapus-data-' + id).submit();
                }
            });
        }
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                Swal.fire({
                    icon: 'success',
                    title: "{{ session('success') }}",
                    position: "top-end",
                    toast: true,
                    timer: 3000,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-xl'
                    }
                });
            });
        </script>
    @endif
@endsection
