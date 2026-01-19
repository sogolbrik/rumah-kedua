@extends('layouts.frontend-main')

@section('title', 'Pusat Pengumuman')

@section('frontend-main')
    <div class="min-h-screen pt-28 pb-20 relative bg-[#fffffe]" x-data="{
        search: @js(request('search', '')),
        category: @js(request('kategori', 'semua')),
        selectedAnnouncement: null,
        showModal: false,
        submitForm(newCategory = null) {
            if (newCategory !== null) {
                this.category = newCategory;
            }
            const form = document.getElementById('filter-form');
            form.elements['search'].value = this.search;
            form.elements['kategori'].value = this.category;
            form.submit();
        }
    }">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#3da9fc]/10 rounded-full blur-[120px] -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#90b4ce]/10 rounded-full blur-[100px] -ml-24 -mb-24"></div>
        </div>

        <form id="filter-form" method="GET" action="{{ route('pengumuman-penghuni') }}" class="hidden">
            <input type="hidden" name="search" x-model="search">
            <input type="hidden" name="kategori" x-model="category">
            <input type="hidden" name="sort" id="temp-sort-value" value="{{ request('sort', 'terbaru') }}">
        </form>

        <div class="bg-[#fffffe] border-b border-[#90b4ce]/30 mt-0 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="flex items-center gap-3">
                        <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-[#90b4ce]/10 rounded-full transition-colors text-[#094067]">
                            <i class="fa-solid fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="text-3xl font-black text-[#094067] tracking-tight">Pusat Pengumuman</h1>
                            <p class="text-[#5f6c7b] mt-1">Informasi terbaru mengenai hunian dan kegiatan komunitas Anda.</p>
                        </div>
                    </div>

                    <div class="relative group">
                        <input type="text" x-model="search" @keyup.enter="submitForm()" placeholder="Cari pengumuman..."
                            class="w-full md:w-80 bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-2xl px-5 py-3 pl-12 focus:ring-2 focus:ring-[#3da9fc] focus:bg-white transition-all outline-none text-sm text-[#5f6c7b]">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#90b4ce] group-focus-within:text-[#3da9fc] transition-colors"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Sidebar Kategori -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 p-6 sticky top-24 shadow-sm">
                        <h3 class="font-bold text-[#094067] uppercase text-xs tracking-widest mb-4">Kategori</h3>
                        <nav class="space-y-2">
                            <button type="button" @click="submitForm('semua')"
                                :class="category === 'semua' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-layer-group w-5"></i> Semua
                            </button>
                            <button type="button" @click="submitForm('Penting')"
                                :class="category === 'Penting' ? 'bg-[#ef4565] text-white shadow-md shadow-[#ef4565]/30' : 'text-[#5f6c7b] hover:bg-[#ef4565]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-circle-exclamation w-5"></i> Penting
                            </button>
                            <button type="button" @click="submitForm('Kegiatan')"
                                :class="category === 'Kegiatan' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-calendar-check w-5"></i> Kegiatan
                            </button>
                            <button type="button" @click="submitForm('Perbaikan')"
                                :class="category === 'Perbaikan' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-tools w-5"></i> Perbaikan
                            </button>
                        </nav>

                        <hr class="my-6 border-[#90b4ce]/20">

                        <h3 class="font-bold text-[#094067] uppercase text-xs tracking-widest mb-4">Sortir Berdasarkan</h3>
                        <select class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 text-sm text-[#5f6c7b] outline-none focus:ring-2 focus:ring-[#3da9fc]"
                            @change="document.getElementById('temp-sort-value').value = $event.target.value; submitForm()" name="sort-temp">
                            <option value="terbaru" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                        </select>
                    </div>
                </div>

                <!-- Daftar Pengumuman -->
                <div class="lg:col-span-9 space-y-8">
                    @if ($is_highlight)
                        <div class="relative overflow-hidden bg-[#094067] rounded-3xl p-8 md:p-12 text-white group cursor-pointer shadow-xl"
                            @click="showModal = true; selectedAnnouncement = @js([
    'title' => $is_highlight->judul,
    'date' => \Carbon\Carbon::parse($is_highlight->created_at)->format('d M Y'),
    'category' => ucfirst($is_highlight->kategori),
    'content' => strip_tags($is_highlight->isi),
])">
                            <div class="relative z-10 md:w-2/3">
                                <span class="bg-[#ef4565] text-[#fffffe] text-[10px] font-black uppercase px-3 py-1 rounded-full mb-4 inline-block">Highlight Utama</span>
                                <h2 class="text-3xl font-bold mb-4 leading-tight">{{ $is_highlight->judul }}</h2>
                                <p class="text-[#90b4ce] mb-6 line-clamp-2">{{ strip_tags($is_highlight->isi) }}</p>
                                <div class="flex items-center gap-4 text-sm font-medium">
                                    <span class="flex items-center gap-2"><i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::parse($is_highlight->created_at)->format('d M Y') }}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-bullhorn absolute -right-8 -bottom-8 text-9xl text-[#fffffe]/10 -rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($pengumuman as $item)
                            @if (!$item->highlight)
                                <div
                                    class="group bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm hover:shadow-xl hover:border-[#3da9fc]/50 transition-all duration-300 flex flex-col overflow-hidden">
                                    <div class="h-2 bg-[#3da9fc]/20 group-hover:bg-[#3da9fc] transition-colors"></div>
                                    <div class="p-6">
                                        <div class="flex justify-between items-start mb-4">
                                            <span class="px-3 py-1 rounded-lg bg-[#90b4ce]/10 text-[#3da9fc] text-[10px] font-bold uppercase tracking-wider italic">{{ ucfirst($item->kategori) }}</span>
                                            <span class="text-xs text-[#5f6c7b]">
                                                <i class="fa-regular fa-clock mr-1"></i> {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                            </span>
                                        </div>
                                        <h3 class="text-lg font-bold text-[#094067] mb-2 group-hover:text-[#3da9fc] transition-colors leading-snug">
                                            {{ $item->judul }}
                                        </h3>
                                        <p class="text-sm text-[#5f6c7b] line-clamp-3 mb-6">
                                            {{ strip_tags($item->isi) }}
                                        </p>
                                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-[#90b4ce]/10">
                                            <button @click="showModal = true; selectedAnnouncement = @js([
    'title' => $item->judul,
    'date' => \Carbon\Carbon::parse($item->created_at)->format('d M Y'),
    'category' => ucfirst($item->kategori),
    'content' => $item->isi,
])"
                                                class="text-[#3da9fc] text-xs font-black uppercase tracking-widest hover:text-[#094067] transition-colors flex items-center gap-2">
                                                Baca Detail <i class="fa-solid fa-arrow-right-long"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if ($pengumuman->hasPages())
                        <div class="flex justify-center pt-8">
                            <nav class="flex items-center gap-2">

                                {{-- Previous --}}
                                @if ($pengumuman->onFirstPage())
                                    <span class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#90b4ce] cursor-not-allowed">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </span>
                                @else
                                    <a href="{{ $pengumuman->previousPageUrl() }}"
                                        class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#094067] hover:bg-[#3da9fc] hover:text-white transition-all">
                                        <i class="fa-solid fa-chevron-left"></i>
                                    </a>
                                @endif

                                {{-- Nomor halaman --}}
                                @foreach ($pengumuman->links()->elements[0] ?? [] as $page => $url)
                                    @if ($page == $pengumuman->currentPage())
                                        <span class="w-10 h-10 rounded-xl bg-[#3da9fc] text-white font-bold shadow-lg shadow-[#3da9fc]/30 flex items-center justify-center">
                                            {{ $page }}
                                        </span>
                                    @else
                                        <a href="{{ $url }}"
                                            class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#5f6c7b] hover:bg-[#90b4ce]/10 transition-all font-bold">
                                            {{ $page }}
                                        </a>
                                    @endif
                                @endforeach

                                {{-- Next --}}
                                @if ($pengumuman->hasMorePages())
                                    <a href="{{ $pengumuman->nextPageUrl() }}"
                                        class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#094067] hover:bg-[#3da9fc] hover:text-white transition-all">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </a>
                                @else
                                    <span class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#90b4ce] cursor-not-allowed">
                                        <i class="fa-solid fa-chevron-right"></i>
                                    </span>
                                @endif

                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div x-show="showModal" x-cloak x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-250"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-[999] overflow-y-auto flex items-center justify-center p-4 sm:p-6"
            aria-labelledby="modal-title" role="dialog" aria-modal="true" style="display: none;">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-[#094067]/60 backdrop-blur-sm transition-opacity duration-300" @click="showModal = false" x-show="showModal" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"></div>

            <!-- Modal Container -->
            <div class="relative z-[1000] bg-white rounded-3xl shadow-2xl max-w-2xl w-full border border-[#90b4ce]/30 overflow-hidden transform transition-all" x-show="showModal" @click.stop=""
                x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
                <!-- Header -->
                <div class="bg-[#fffffe] px-8 pt-8 pb-6">
                    <div class="flex justify-between items-start mb-6">
                        <span class="bg-[#3da9fc]/10 text-[#3da9fc] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest" x-text="selectedAnnouncement.category"></span>
                        <button @click="showModal = false" class="text-[#90b4ce] hover:text-[#ef4565] transition-colors focus:outline-none" aria-label="Tutup modal">
                            <i class="fa-solid fa-circle-xmark text-2xl"></i>
                        </button>
                    </div>
                    <h2 class="text-3xl font-black text-[#094067] mb-4 leading-tight" x-text="selectedAnnouncement.title"></h2>
                    <div class="flex items-center gap-6 text-sm text-[#5f6c7b] mb-8 pb-6 border-b border-[#90b4ce]/20">
                        <span class="flex items-center gap-2"><i class="fa-solid fa-calendar text-[#3da9fc]"></i> <span x-text="selectedAnnouncement.date"></span></span>
                        <span class="flex items-center gap-2"><i class="fa-solid fa-user text-[#3da9fc]"></i> Admin Pengelola</span>
                    </div>
                    <div class="prose max-w-none text-[#5f6c7b] leading-relaxed" x-html="selectedAnnouncement.content"></div>
                </div>

                <!-- Footer -->
                <div class="bg-[#90b4ce]/5 px-8 py-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-[#90b4ce]"></i>
                        <span class="text-xs font-bold text-[#5f6c7b] uppercase">Bagikan Info Ini</span>
                    </div>
                    <button @click="showModal = false"
                        class="w-full sm:w-auto bg-[#094067] text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-[#3da9fc] transition-all shadow-lg shadow-[#094067]/20 focus:outline-none focus:ring-2 focus:ring-[#3da9fc]">
                        Mengerti, Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
