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

    <div x-data="{ submitting: false, highlight: false, showModal: false, selected: {} }" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-[0_4px_20px_-8px_rgba(0,0,0,0.06)] overflow-hidden">
            <div class="px-6 py-5 border-b border-[#90b4ce]/20 bg-[#90b4ce]/5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <h2 class="text-lg font-bold text-[#094067] flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-[#f59f00] text-sm"></i>
                        Manajemen Pengumuman
                    </h2>
                    @if ($pengumuman->total() > 0)
                        <span class="px-3 py-1 rounded-full bg-[#f59f00]/10 text-xs font-bold text-[#f59f00]">
                            {{ $pengumuman->total() }} Total
                        </span>
                    @endif
                </div>
            </div>

            <div class="px-6 py-5">
                <ul class="space-y-4">
                    @forelse ($pengumuman as $item)
                        <li class="group relative p-4 rounded-xl border border-[#90b4ce]/30 bg-white hover:shadow-md transition-all duration-300">
                            @if ($item->highlight == 1)
                                <div class="absolute -left-1 -top-1 z-10">
                                    <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-[#f59f00] text-white shadow-sm ring-4 ring-white">
                                        <i class="fa-solid fa-star text-[10px]"></i>
                                    </span>
                                </div>
                            @endif

                            <div class="absolute left-0 top-0 bottom-0 w-1 {{ $item->highlight == 1 ? 'bg-[#f59f00]' : 'bg-[#f59f00]/30' }} rounded-r-full"></div>

                            <div class="flex items-start justify-between pl-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="text-[10px] font-medium uppercase tracking-wider px-2 py-0.5 rounded {{ $item->kategori == 'Penting'
                                                ? 'bg-[#ef4565]/10 text-[#ef4565]'
                                                : ($item->kategori == 'Perbaikan'
                                                    ? 'bg-[#3da9fc]/10 text-[#3da9fc]'
                                                    : ($item->kategori == 'Kegiatan'
                                                        ? 'bg-[#094067]/10 text-[#094067]'
                                                        : 'bg-[#90b4ce]/20 text-[#5f6c7b]')) }}">
                                            {{ $item->kategori ?? 'Umum' }}
                                        </span>
                                        <span class="text-[10px] text-[#5f6c7b] italic">{{ $item->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h3 class="font-bold text-[#094067] group-hover:text-[#f59f00] text-sm transition-colors line-clamp-1">
                                        {{ $item->judul }}
                                    </h3>
                                    <p class="mt-1 text-xs text-[#5f6c7b] leading-relaxed line-clamp-2 pr-4">
                                        {{ Str::limit($item->isi, 90) }}
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2">
                                    <span class="text-[10px] font-medium text-[#90b4ce]">
                                        {{ $item->created_at->translatedFormat('d M') }}
                                    </span>
                                    <button
                                        @click="showModal = true; selected = { 
                                            judul: '{{ addslashes($item->judul) }}', 
                                            isi: '{{ addslashes($item->isi) }}', 
                                            kategori: '{{ $item->kategori ?? 'Umum' }}',
                                            tgl: '{{ $item->created_at->translatedFormat('d M Y • H:i') }}'
                                        }"
                                        class="mt-2 p-2 bg-[#f59f00]/10 text-[#f59f00] rounded-lg hover:bg-[#f59f00] hover:text-white transition-all group/btn">
                                        <i class="fa-solid fa-eye text-xs group-hover/btn:scale-110 transition-transform"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="py-10 text-center text-[#5f6c7b]">
                            <i class="fas fa-bullhorn text-4xl mb-4 opacity-20"></i>
                            <p class="font-bold text-[#094067]">Belum ada data</p>
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
                                    class="px-4 py-2 text-sm rounded-xl bg-gradient-to-r from-amber-600 to-orange-600 text-white font-medium shadow-sm hover:shadow-md hover:from-amber-700 hover:to-orange-700 transition-all">
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

        <div class="bg-white rounded-2xl border border-[#90b4ce]/30 shadow-sm p-6 overflow-hidden flex flex-col h-fit sticky top-24">
            <div class="relative z-10 flex items-center gap-3 mb-6">
                <div class="h-10 w-10 rounded-xl bg-[#f59f00] flex items-center justify-center text-white shadow-lg shadow-[#f59f00]/20">
                    <i class="fa-solid fa-pen-nib text-sm"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#094067]">Buat Baru</h3>
                    <p class="text-[10px] text-[#5f6c7b] uppercase font-bold tracking-wider">Editor Pengumuman</p>
                </div>
            </div>

            <form action="{{ route('pengumuman-admin.store') }}" method="POST" @submit="submitting = true" class="space-y-4 relative z-10">
                @csrf

                <div class="space-y-1.5">
                    <label for="judul" class="text-[11px] font-black text-[#094067] uppercase tracking-wider ml-1">Judul Utama</label>
                    <input type="text" id="judul" name="judul" required
                        class="w-full rounded-xl border border-[#90b4ce]/40 px-4 py-3 text-sm text-[#094067] placeholder-[#90b4ce] focus:ring-2 focus:ring-[#f59f00]/20 focus:border-[#f59f00] focus:outline-none transition-all duration-200"
                        placeholder="Judul pengumuman..." />
                </div>

                <div class="grid grid-cols-1 gap-4">
                    <div class="space-y-1.5">
                        <label for="kategori" class="text-[11px] font-black text-[#094067] uppercase tracking-wider ml-1">Kategori</label>
                        <div class="relative">
                            <select id="kategori" name="kategori" required
                                class="w-full rounded-xl border border-[#90b4ce]/40 px-4 py-3 text-sm text-[#094067] focus:ring-2 focus:ring-[#f59f00]/20 focus:border-[#f59f00] focus:outline-none appearance-none bg-white transition-all duration-200">
                                <option value="Umum">📢 Umum</option>
                                <option value="Penting">🚨 Penting</option>
                                <option value="Perbaikan">🛠️ Perbaikan</option>
                                <option value="Kegiatan">🗓️ Kegiatan</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#90b4ce]">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl border border-[#90b4ce]/20 bg-[#90b4ce]/5">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-star text-[#f59f00]"></i>
                            <span class="text-xs font-bold text-[#094067]">Set sebagai Highlight?</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="highlight" value="1" class="sr-only peer" x-model="highlight">
                            <div
                                class="w-10 h-5 bg-[#90b4ce]/40 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#f59f00]">
                            </div>
                        </label>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label for="isi" class="text-[11px] font-black text-[#094067] uppercase tracking-wider ml-1">Konten Pesan</label>
                    <textarea id="isi" rows="4" name="isi" required
                        class="w-full rounded-xl border border-[#90b4ce]/40 px-4 py-3 text-sm text-[#094067] placeholder-[#90b4ce] focus:ring-2 focus:ring-[#f59f00]/20 focus:border-[#f59f00] focus:outline-none transition-all duration-200 resize-none"
                        placeholder="Tulis detail pengumuman di sini..."></textarea>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="reset" @click="highlight = false" class="flex-1 px-4 py-3 text-xs font-bold text-[#5f6c7b] bg-[#90b4ce]/10 hover:bg-[#90b4ce]/20 rounded-xl transition-all">
                        Reset
                    </button>
                    <button type="submit" :disabled="submitting"
                        class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 focus:ring-2 focus:ring-amber-400/50 focus:ring-offset-1 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-80 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Simpan Pengumuman</span>
                        <span x-show="submitting" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Modal --}}
        <template x-teleport="body">
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-[#094067]/40 backdrop-blur-sm" x-cloak>
    
                <div @click.outside="showModal = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0" class="bg-[#fffffe] w-full max-w-lg rounded-3xl shadow-2xl border border-[#90b4ce]/30 overflow-hidden">
    
                    <div class="px-8 pt-8 flex justify-between items-start">
                        <span class="px-3 py-1 rounded-full bg-[#f59f00]/10 text-[#f59f00] text-[10px] font-black uppercase tracking-widest" x-text="selected.kategori"></span>
                        <button @click="showModal = false" class="text-slate-400 hover:text-[#f59f00] transition-colors">
                            <i class="fa-solid fa-circle-xmark text-2xl"></i>
                        </button>
                    </div>
    
                    <div class="px-8 py-6">
                        <h2 class="text-2xl font-black text-[#094067] leading-tight mb-2" x-text="selected.judul"></h2>
                        <div class="flex items-center gap-2 text-[#5f6c7b] text-xs mb-6 font-medium">
                            <i class="fa-regular fa-calendar-check text-[#f59f00]"></i>
                            <span x-text="selected.tgl"></span>
                        </div>
    
                        <div class="max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                            <p class="text-[#5f6c7b] leading-relaxed whitespace-pre-line" x-text="selected.isi"></p>
                        </div>
                    </div>
    
                    <div class="px-8 py-6 bg-[#f59f00]/5 border-t border-[#f59f00]/10">
                        <button @click="showModal = false" class="w-full py-3 bg-[#f59f00] text-[#fffffe] rounded-2xl font-bold text-sm shadow-lg shadow-[#f59f00]/20 hover:bg-[#094067] transition-all">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </template>

    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #90b4ce;
            border-radius: 10px;
        }
    </style>
@endsection
