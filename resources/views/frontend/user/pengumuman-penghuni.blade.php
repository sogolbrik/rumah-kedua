@extends('layouts.frontend-main')

@section('title', 'Pusat Pengumuman')

@section('frontend-main')
    <div class="min-h-screen bg-[#fffffe] pb-12" x-data="{
        search: '',
        category: 'semua',
        selectedAnnouncement: null,
        showModal: false
    }">

        <div class="bg-[#fffffe] border-b border-[#90b4ce]/30 mt-25 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h1 class="text-3xl font-black text-[#094067] tracking-tight">Pusat Pengumuman</h1>
                        <p class="text-[#5f6c7b] mt-1">Informasi terbaru mengenai hunian dan kegiatan komunitas Anda.</p>
                    </div>

                    <div class="relative group">
                        <input type="text" x-model="search" placeholder="Cari pengumuman..."
                            class="w-full md:w-80 bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-2xl px-5 py-3 pl-12 focus:ring-2 focus:ring-[#3da9fc] focus:bg-white transition-all outline-none text-sm text-[#5f6c7b]">
                        <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[#90b4ce] group-focus-within:text-[#3da9fc] transition-colors"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 p-6 sticky top-24 shadow-sm">
                        <h3 class="font-bold text-[#094067] uppercase text-xs tracking-widest mb-4">Kategori</h3>
                        <nav class="space-y-2">
                            <button @click="category = 'semua'" :class="category === 'semua' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-layer-group w-5"></i> Semua
                            </button>
                            <button @click="category = 'penting'" :class="category === 'penting' ? 'bg-[#ef4565] text-white shadow-md shadow-[#ef4565]/30' : 'text-[#5f6c7b] hover:bg-[#ef4565]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-circle-exclamation w-5"></i> Penting
                            </button>
                            <button @click="category = 'kegiatan'" :class="category === 'kegiatan' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-calendar-check w-5"></i> Kegiatan
                            </button>
                            <button @click="category = 'perbaikan'" :class="category === 'perbaikan' ? 'bg-[#3da9fc] text-white shadow-md shadow-[#3da9fc]/30' : 'text-[#5f6c7b] hover:bg-[#90b4ce]/10'"
                                class="flex items-center w-full gap-3 px-4 py-3 text-sm font-bold rounded-xl transition-all">
                                <i class="fa-solid fa-tools w-5"></i> Perbaikan
                            </button>
                        </nav>

                        <hr class="my-6 border-[#90b4ce]/20">

                        <h3 class="font-bold text-[#094067] uppercase text-xs tracking-widest mb-4">Sortir Berdasarkan</h3>
                        <select class="w-full bg-[#90b4ce]/5 border border-[#90b4ce]/30 rounded-xl px-4 py-2.5 text-sm text-[#5f6c7b] outline-none focus:ring-2 focus:ring-[#3da9fc]">
                            <option>Terbaru</option>
                            <option>Terlama</option>
                            <option>Paling Sering Dilihat</option>
                        </select>
                    </div>
                </div>

                <div class="lg:col-span-9 space-y-8">

                    <div class="relative overflow-hidden bg-[#094067] rounded-3xl p-8 md:p-12 text-white group cursor-pointer shadow-xl"
                        @click="showModal = true; selectedAnnouncement = { title: 'Pemeliharaan Listrik Berkala', date: '20 Okt 2024', category: 'Penting', content: 'Akan dilakukan pemeliharaan instalasi listrik di seluruh blok...' }">
                        <div class="relative z-10 md:w-2/3">
                            <span class="bg-[#ef4565] text-[#fffffe] text-[10px] font-black uppercase px-3 py-1 rounded-full mb-4 inline-block">Highlight Utama</span>
                            <h2 class="text-3xl font-bold mb-4 leading-tight">Pemeliharaan Listrik Berkala Gedung Utama</h2>
                            <p class="text-[#90b4ce] mb-6 line-clamp-2">Mohon perhatian bagi seluruh penghuni, akan diadakan pemeliharaan rutin panel listrik pada hari Sabtu mendatang guna meningkatkan
                                keamanan bersama.</p>
                            <div class="flex items-center gap-4 text-sm font-medium">
                                <span class="flex items-center gap-2"><i class="fa-regular fa-calendar"></i> 20 Okt 2024</span>
                                <span class="flex items-center gap-2"><i class="fa-regular fa-clock"></i> 09:00 WIB</span>
                            </div>
                        </div>
                        <i class="fa-solid fa-bullhorn absolute -right-8 -bottom-8 text-9xl text-[#fffffe]/10 -rotate-12 group-hover:rotate-0 transition-transform duration-500"></i>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach (range(1, 6) as $i)
                            <div
                                class="group bg-[#fffffe] rounded-2xl border border-[#90b4ce]/30 shadow-sm hover:shadow-xl hover:border-[#3da9fc]/50 transition-all duration-300 flex flex-col overflow-hidden">
                                <div class="h-2 bg-[#3da9fc]/20 group-hover:bg-[#3da9fc] transition-colors"></div>
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-4">
                                        <span class="px-3 py-1 rounded-lg bg-[#90b4ce]/10 text-[#3da9fc] text-[10px] font-bold uppercase tracking-wider italic">Kegiatan</span>
                                        <span class="text-xs text-[#5f6c7b]"><i class="fa-regular fa-clock mr-1"></i> 2 jam lalu</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-[#094067] mb-2 group-hover:text-[#3da9fc] transition-colors leading-snug">
                                        Kerja Bakti Minggu Ceria & Syukuran Warga Blok C
                                    </h3>
                                    <p class="text-sm text-[#5f6c7b] line-clamp-3 mb-6">
                                        Undangan bagi seluruh warga untuk berpartisipasi dalam agenda bulanan kebersihan lingkungan yang akan dilanjutkan dengan makan siang bersama...
                                    </p>
                                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-[#90b4ce]/10">
                                        <div class="flex -space-x-2">
                                            <div class="w-8 h-8 rounded-full border-2 border-white bg-[#094067] flex items-center justify-center text-[10px] text-white font-bold">A</div>
                                            <div class="w-8 h-8 rounded-full border-2 border-white bg-[#3da9fc] flex items-center justify-center text-[10px] text-white font-bold">M</div>
                                        </div>
                                        <button
                                            @click="showModal = true; selectedAnnouncement = { title: 'Judul Pengumuman ' + {{ $i }}, date: '15 Okt 2024', category: 'Kegiatan', content: 'Detail lengkap isi pengumuman akan ditampilkan di sini...' }"
                                            class="text-[#3da9fc] text-xs font-black uppercase tracking-widest hover:text-[#094067] transition-colors flex items-center gap-2">
                                            Baca Detail <i class="fa-solid fa-arrow-right-long"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex justify-center pt-8">
                        <nav class="flex items-center gap-2">
                            <button class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#094067] hover:bg-[#3da9fc] hover:text-white transition-all"><i
                                    class="fa-solid fa-chevron-left"></i></button>
                            <button class="w-10 h-10 rounded-xl bg-[#3da9fc] text-white font-bold shadow-lg shadow-[#3da9fc]/30">1</button>
                            <button class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#5f6c7b] hover:bg-[#90b4ce]/10 transition-all font-bold">2</button>
                            <button class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#5f6c7b] hover:bg-[#90b4ce]/10 transition-all font-bold">3</button>
                            <button class="w-10 h-10 rounded-xl border border-[#90b4ce]/30 flex items-center justify-center text-[#094067] hover:bg-[#3da9fc] hover:text-white transition-all"><i
                                    class="fa-solid fa-chevron-right"></i></button>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <template x-if="showModal">
            <div class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-[#094067]/60 backdrop-blur-sm transition-opacity" @click="showModal = false"></div>

                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-[#90b4ce]/30"
                        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100">

                        <div class="bg-[#fffffe] px-8 pt-8 pb-6">
                            <div class="flex justify-between items-start mb-6">
                                <span class="bg-[#3da9fc]/10 text-[#3da9fc] px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest" x-text="selectedAnnouncement.category"></span>
                                <button @click="showModal = false" class="text-[#90b4ce] hover:text-[#ef4565] transition-colors">
                                    <i class="fa-solid fa-circle-xmark text-2xl"></i>
                                </button>
                            </div>
                            <h2 class="text-3xl font-black text-[#094067] mb-4 leading-tight" x-text="selectedAnnouncement.title"></h2>
                            <div class="flex items-center gap-6 text-sm text-[#5f6c7b] mb-8 pb-6 border-b border-[#90b4ce]/20">
                                <span class="flex items-center gap-2"><i class="fa-solid fa-calendar text-[#3da9fc]"></i> <span x-text="selectedAnnouncement.date"></span></span>
                                <span class="flex items-center gap-2"><i class="fa-solid fa-user text-[#3da9fc]"></i> Admin Pengelola</span>
                            </div>
                            <div class="prose max-w-none text-[#5f6c7b] leading-relaxed">
                                <p x-text="selectedAnnouncement.content"></p>
                                <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                    nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                        <div class="bg-[#90b4ce]/5 px-8 py-6 flex flex-col sm:flex-row gap-4 justify-between items-center">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-share-nodes text-[#90b4ce]"></i>
                                <span class="text-xs font-bold text-[#5f6c7b] uppercase">Bagikan Info Ini</span>
                            </div>
                            <button @click="showModal = false"
                                class="w-full sm:w-auto bg-[#094067] text-white px-8 py-3 rounded-2xl font-bold text-sm hover:bg-[#3da9fc] transition-all shadow-lg shadow-[#094067]/20">
                                Mengerti, Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

@endsection
