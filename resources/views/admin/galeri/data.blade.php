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
                        <span class="text-xs text-slate-700">#{{ ($galeri->currentPage() - 1) * $galeri->perPage() + $loop->iteration }}</span>
                    </div>
                    <div class="flex gap-2">
                        <form action="{{ Route('galeri.destroy', $item->id) }}" method="POST" class="inline-block" id="hapus-data-{{ $item->id }}">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors"
                                onclick="konfirmasiHapusGaleri({{ $item->id }})">
                                <i class="fa-solid fa-trash text-xs"></i>
                                Hapus
                            </button>
                        </form>
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

    <!-- Pagination -->
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
@endsection
