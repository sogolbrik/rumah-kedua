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

    <div x-data="{ zoomedImage: null }">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @forelse($galeri as $item)
                <div class="group relative bg-white rounded-3xl border border-slate-200/60 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                    <div class="aspect-[4/5] overflow-hidden bg-slate-100 relative">
                        <img src="{{ Storage::url($item->gambar) }}" alt="Galeri Image" class="w-full h-full object-cover cursor-zoom-in transition-transform duration-700 group-hover:scale-110"
                            @click="zoomedImage = '{{ Storage::url($item->gambar) }}'" loading="lazy">

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-4">
                            <button type="button" onclick="konfirmasiHapusGaleri({{ $item->id }})"
                                class="w-full py-2.5 bg-red-500/90 hover:bg-red-600 text-white text-xs font-bold rounded-xl backdrop-blur-md transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-trash-can text-[10px]"></i>
                                Hapus Foto
                            </button>
                        </div>

                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 bg-white/90 backdrop-blur-md border border-slate-200 text-[10px] font-black text-slate-800 rounded-lg shadow-sm">
                                #{{ ($galeri->currentPage() - 1) * $galeri->perPage() + $loop->iteration }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('galeri.destroy', $item->id) }}" method="POST" id="hapus-data-{{ $item->id }}" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
            @empty
                <div class="col-span-full py-24 flex flex-col items-center justify-center text-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-[2.5rem] flex items-center justify-center border border-slate-100 mb-6 group">
                        <i class="fa-solid fa-images text-4xl text-slate-200 group-hover:scale-110 transition-transform duration-500"></i>
                    </div>
                    <h3 class="text-xl font-black text-slate-900">Media Belum Tersedia</h3>
                    <p class="text-slate-500 mt-2 max-w-xs mx-auto">Mulai isi galeri Anda dengan foto-foto terbaik unit untuk meningkatkan konversi pesanan.</p>
                </div>
            @endforelse
        </div>

        @if (isset($galeri) && $galeri->hasPages())
            <div class="mt-12 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-slate-100 pt-8">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                    Halaman {{ $galeri->currentPage() }} dari {{ $galeri->lastPage() }}
                </p>
                <div class="flex gap-2">
                    @if ($galeri->onFirstPage())
                        <span class="p-3 rounded-xl bg-slate-50 text-slate-300 cursor-not-allowed border border-slate-100">
                            <i class="fa-solid fa-arrow-left"></i>
                        </span>
                    @else
                        <a href="{{ $galeri->previousPageUrl() }}"
                            class="p-3 rounded-xl bg-white border border-slate-200 text-slate-600 hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all shadow-sm">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                    @endif

                    @if ($galeri->hasMorePages())
                        <a href="{{ $galeri->nextPageUrl() }}" class="px-6 py-3 rounded-xl bg-slate-900 text-white font-bold hover:bg-blue-600 transition-all shadow-lg active:scale-95">
                            Berikutnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    @else
                        <span class="px-6 py-3 rounded-xl bg-slate-50 text-slate-300 border border-slate-100 font-bold">
                            Akhir Galeri
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <div x-show="zoomedImage" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/90 backdrop-blur-md p-4" @click="zoomedImage = null">

            <div class="relative max-w-5xl w-full flex flex-col items-center" @click.stop>
                <img :src="zoomedImage" class="max-w-full max-h-[80vh] rounded-[2rem] shadow-2xl border-4 border-white/10 object-contain">

                <div class="mt-6 flex gap-4">
                    <button @click="zoomedImage = null" class="px-8 py-3 bg-white/10 hover:bg-white/20 text-white rounded-2xl font-bold backdrop-blur-xl transition-all border border-white/10">
                        Tutup Galeri
                    </button>
                    <a :href="zoomedImage" download class="p-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl transition-all shadow-xl">
                        <i class="fa-solid fa-download"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if (isset($galeri) && $galeri->hasPages())
        <div class="mt-8 border-t border-slate-200/40 pt-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <p class="text-sm text-slate-600">
                    Menampilkan <span class="font-semibold text-slate-800">{{ $galeri->firstItem() }}</span>
                    sampai <span class="font-semibold text-slate-800">{{ $galeri->lastItem() }}</span>
                    dari <span class="font-semibold text-slate-800">{{ $galeri->total() }}</span> gambar
                </p>
                <div class="flex gap-2">
                    @if ($galeri->onFirstPage())
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                            <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                        </span>
                    @else
                        <a href="{{ $galeri->previousPageUrl() }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium shadow-sm hover:shadow transition-colors">
                            <i class="fa-solid fa-chevron-left text-xs"></i> Sebelumnya
                        </a>
                    @endif

                    @if ($galeri->hasMorePages())
                        <a href="{{ $galeri->nextPageUrl() }}"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm bg-gradient-to-r from-slate-700 to-slate-800 text-white font-medium shadow-md hover:shadow-lg hover:from-slate-700 hover:to-slate-700 transition-all">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-xs ml-1"></i>
                        </a>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                            Selanjutnya <i class="fa-solid fa-chevron-right text-xs ml-1"></i>
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
