@extends('layouts.admin-main')

@section('title', 'Kamar')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                Daftar Kamar
            </h1>
            <p class="mt-0.5 text-sm text-slate-600">Semua informasi kamar ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <div>
            <a href="{{ route('kamar.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 text-sm font-medium hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah Kamar
            </a>
        </div>
    </div>

    <div class="mt-4 rounded-2xl border border-slate-200/40 bg-white overflow-hidden shadow-[0_4px_20px_-8px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-white border-b border-slate-200/50">
                    <tr>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest w-16 text-center">No</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-left">Informasi Kamar</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-6 py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse ($kamar as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-200 group">
                            <td class="px-6 py-4 font-medium text-slate-700 text-center">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition-all duration-300">
                                        <i class="fa-solid fa-door-closed text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-slate-900 leading-tight mb-0.5">Unit {{ $item->kode_kamar }}</p>
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs font-bold text-blue-600">Rp{{ number_format($item->harga, 0, ',', '.') }}</span>
                                            <span class="text-slate-300 text-[10px]">•</span>
                                            <span class="text-[11px] font-medium text-slate-500 uppercase">{{ $item->tipe }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($item->status == 'Tersedia')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-xs"></i> Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fa-solid fa-bed text-xs"></i> Terisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="inline-flex gap-2 justify-end">
                                    <button type="button" onclick="showDetailModal({{ $item->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 transition-all shadow-sm hover:shadow">
                                        <i class="fa-solid fa-eye text-xs"></i> Detail
                                    </button>
                                    <a href="{{ route('kamar.edit', $item->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 transition-all shadow-sm hover:shadow">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i> Edit
                                    </a>
                                    <form action="{{ route('kamar.destroy', $item->id) }}" method="POST" class="inline" id="hapus-data-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-red-200 text-red-700 hover:bg-red-50 transition-all shadow-sm hover:shadow"
                                            onclick="konfirmasiHapusKamar({{ $item->id }}, '{{ $item->kode_kamar }}')">
                                            <i class="fa-solid fa-trash-can text-xs"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                                <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-slate-100 text-slate-400 mb-3">
                                    <i class="fa-solid fa-door-closed text-2xl"></i>
                                </div>
                                <p class="text-base font-medium">Tidak ada kamar</p>
                                <p class="text-sm text-slate-500 mt-1">Tambahkan kamar pertama Anda sekarang!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kamar->hasPages())
            <div class="border-t border-slate-200/30 px-6 py-4 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-sm text-slate-600 text-center sm:text-left">
                        Menampilkan <span class="font-bold text-slate-800">{{ $kamar->firstItem() }}</span>–
                        <span class="font-bold text-slate-800">{{ $kamar->lastItem() }}</span> dari
                        <span class="font-bold text-slate-800">{{ $kamar->total() }}</span> hasil
                    </p>
                    <div class="flex gap-2">
                        @if ($kamar->onFirstPage())
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $kamar->previousPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium shadow-sm hover:shadow transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($kamar->hasMorePages())
                            <a href="{{ $kamar->nextPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-gradient-to-r from-blue-600 to-slate-400 text-white font-medium shadow-md hover:shadow-lg hover:from-blue-700 hover:to-slate-500 transition-all">
                                Selanjutnya <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </a>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                Selanjutnya <i class="fa-solid fa-chevron-right ml-1 text-xs"></i>
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Detail Kamar -->
    <div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 pointer-events-none">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop dengan blur -->
            <div id="modalBackdrop" class="fixed inset-0 transition-all duration-300 ease-out bg-gray-900/60 backdrop-blur-sm" onclick="hideDetailModal()"></div>

            <!-- Modal Content -->
            <div id="modalContent"
                class="relative inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all duration-300 ease-out transform scale-95 translate-y-4 bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:p-6">
                <!-- Header Modal -->
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-cyan-100 text-cyan-600">
                            <i class="fa-solid fa-door-open text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900" id="modalKodeKamar">Detail Kamar</h3>
                            <p class="text-sm text-slate-600">Informasi lengkap kamar</p>
                        </div>
                    </div>
                    <button type="button" onclick="hideDetailModal()" class="p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Content Modal -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Gambar Kamar -->
                    <div class="space-y-4">
                        <!-- Carousel Galeri -->
                        <div class="relative group">
                            <div class="aspect-w-16 aspect-h-12 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                                <img id="galeriUtama" src="" alt="Galeri Kamar" class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>

                            <!-- Indikator Galeri -->
                            <div id="galeriIndikator" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2"></div>

                            <!-- Navigasi Carousel -->
                            <button id="prevBtn" type="button"
                                class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 shadow-md backdrop-blur-sm text-slate-700 hover:bg-white transition-all opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button id="nextBtn" type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-white/80 shadow-md backdrop-blur-sm text-slate-700 hover:bg-white transition-all opacity-0 group-hover:opacity-100">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>

                        <!-- Miniatur Galeri -->
                        <div id="miniGaleri" class="flex space-x-2 overflow-x-auto pb-2 hide-scrollbar"></div>

                        <!-- Informasi Utama -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-cyan-600"></i>
                                Informasi Utama
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Status:</span>
                                    <span id="modalStatus" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Tipe:</span>
                                    <span id="modalTipe" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Luas:</span>
                                    <span id="modalLebar" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Informasi -->
                    <div class="space-y-6">
                        <!-- Harga -->
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-200 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600">
                                    <i class="fa-solid fa-tag"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-emerald-700 font-medium">Harga per Bulan</p>
                                    <p id="modalHarga" class="text-2xl font-bold text-emerald-900"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-file-lines text-blue-600"></i>
                                Deskripsi Kamar
                            </h4>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                                <p id="modalDeskripsi" class="text-slate-700 leading-relaxed"></p>
                            </div>
                        </div>

                        <!-- Fasilitas -->
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-star text-amber-600"></i>
                                Fasilitas Kamar
                            </h4>
                            <div id="modalFasilitas" class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <!-- Fasilitas akan diisi oleh JavaScript -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Modal -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200">
                    <button type="button" onclick="hideDetailModal()"
                        class="px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition-all duration-200 hover:shadow-sm">
                        <i class="fa-solid fa-times mr-2"></i>
                        Tutup
                    </button>
                    <a href="#" id="modalEditLink"
                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-all duration-200 hover:shadow-sm inline-flex items-center">
                        <i class="fa-solid fa-pen-to-square mr-2"></i>
                        Edit Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tambahkan class hidden jika belum ada
        if (!document.querySelector('style').textContent.includes('.hidden')) {
            const style = document.createElement('style');
            style.textContent = `.hidden { display: none !important; }`;
            document.head.appendChild(style);
        }

        // Data kamar dari server
        let currentSlide = 0;
        let galeriItems = [];
        const kamarData = @json($kamar->keyBy('id')->toArray());

        // Pasang event listener navigasi SEKALI SAJA
        document.addEventListener('DOMContentLoaded', () => {
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');

            prevBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (galeriItems.length > 1) {
                    goToSlide(currentSlide - 1);
                }
            });

            nextBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (galeriItems.length > 1) {
                    goToSlide(currentSlide + 1);
                }
            });
        });

        function showDetailModal(kamarId) {
            const kamar = kamarData[kamarId];
            if (!kamar) return;

            // Isi data ke modal
            document.getElementById('modalKodeKamar').textContent = `Kamar ${kamar.kode_kamar}`;
            document.getElementById('modalHarga').textContent = `Rp ${formatRupiah(kamar.harga)}`;
            document.getElementById('modalTipe').textContent = kamar.tipe;
            document.getElementById('modalLebar').textContent = `${kamar.lebar} m²`;
            document.getElementById('modalDeskripsi').textContent = kamar.deskripsi || 'Tidak ada deskripsi';
            document.getElementById('modalEditLink').href = `/kamar/${kamar.id}/edit`;

            // Kumpulkan gambar unik
            const galeriSet = new Set();
            if (kamar.gambar) {
                galeriSet.add(`/storage/${kamar.gambar.trim()}`);
            }
            if (Array.isArray(kamar.galeri)) {
                kamar.galeri.forEach(item => {
                    if (item && typeof item === 'object' && item.foto) {
                        const fotoPath = item.foto.trim();
                        if (fotoPath) {
                            galeriSet.add(`/storage/${fotoPath}`);
                        }
                    }
                });
            }

            let galeri = Array.from(galeriSet);
            if (galeri.length === 0) {
                galeri.push('/images/default-room.jpg');
            }

            initGaleriCarousel(galeri);

            // Set status
            const statusEl = document.getElementById('modalStatus');
            if (kamar.status === 'Tersedia') {
                statusEl.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Tersedia';
                statusEl.className = 'px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200';
            } else {
                statusEl.innerHTML = '<i class="fa-solid fa-bed mr-1"></i> Terisi';
                statusEl.className = 'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200';
            }

            // Isi fasilitas
            const fasilitasContainer = document.getElementById('modalFasilitas');
            fasilitasContainer.innerHTML = '';
            if (kamar.detail_kamar?.length > 0) {
                kamar.detail_kamar.forEach(fasilitas => {
                    const el = document.createElement('div');
                    el.className = 'flex items-center gap-2 px-3 py-2 bg-white border border-slate-200 rounded-lg transition-all duration-200 hover:bg-slate-50 hover:border-slate-300';
                    el.innerHTML = `<i class="fa-solid fa-check text-emerald-500 text-xs"></i><span class="text-sm text-slate-700">${fasilitas.fasilitas}</span>`;
                    fasilitasContainer.appendChild(el);
                });
            } else {
                fasilitasContainer.innerHTML = `
                <div class="col-span-2 text-center py-4 text-slate-500">
                    <i class="fa-solid fa-info-circle mb-2 text-lg"></i>
                    <p>Tidak ada fasilitas tersedia</p>
                </div>
            `;
            }

            // Tampilkan modal
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');
            document.body.classList.add('overflow-hidden');

            // Trigger reflow
            void modal.offsetWidth;

            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                backdrop.classList.remove('bg-gray-900/60');
                backdrop.classList.add('bg-gray-900/70');
                content.classList.remove('scale-95', 'translate-y-4');
                content.classList.add('scale-100', 'translate-y-0');
            }, 10);
        }

        function initGaleriCarousel(images) {
            galeriItems = images;
            currentSlide = 0;

            // Update gambar utama
            document.getElementById('galeriUtama').src = galeriItems[0];
            document.getElementById('galeriUtama').alt = `Foto 1 dari ${galeriItems.length}`;

            const indikatorContainer = document.getElementById('galeriIndikator');
            const miniContainer = document.getElementById('miniGaleri');

            indikatorContainer.innerHTML = '';
            miniContainer.innerHTML = '';

            if (galeriItems.length > 1) {
                // Buat indikator
                galeriItems.forEach((_, i) => {
                    const dot = document.createElement('button');
                    dot.className = `w-2 h-2 rounded-full ${i === 0 ? 'bg-white' : 'bg-white/50'} transition-colors`;
                    dot.setAttribute('aria-label', `Lihat foto ${i + 1}`);
                    dot.addEventListener('click', () => goToSlide(i));
                    indikatorContainer.appendChild(dot);
                });

                // Buat miniatur
                galeriItems.forEach((img, i) => {
                    const mini = document.createElement('div');
                    mini.className = `mini-galeri-item ${i === 0 ? 'active' : ''}`;
                    mini.innerHTML = `<img src="${img}" alt="Mini ${i + 1}" loading="lazy">`;
                    mini.addEventListener('click', () => goToSlide(i));
                    miniContainer.appendChild(mini);
                });

                // Tampilkan elemen
                miniContainer.classList.remove('hidden');
                indikatorContainer.classList.remove('hidden');
                document.getElementById('prevBtn').classList.remove('hidden');
                document.getElementById('nextBtn').classList.remove('hidden');
            } else {
                // Sembunyikan semua
                miniContainer.classList.add('hidden');
                indikatorContainer.classList.add('hidden');
                document.getElementById('prevBtn').classList.add('hidden');
                document.getElementById('nextBtn').classList.add('hidden');
            }
        }

        function goToSlide(index) {
            if (galeriItems.length <= 1) return;

            if (index >= galeriItems.length) index = 0;
            if (index < 0) index = galeriItems.length - 1;

            currentSlide = index;

            // Update gambar utama
            document.getElementById('galeriUtama').src = galeriItems[currentSlide];
            document.getElementById('galeriUtama').alt = `Foto ${currentSlide + 1} dari ${galeriItems.length}`;

            // Update indikator
            document.querySelectorAll('#galeriIndikator button').forEach((dot, i) => {
                dot.className = `w-2 h-2 rounded-full ${i === currentSlide ? 'bg-white' : 'bg-white/50'} transition-colors`;
            });

            // Update miniatur aktif
            document.querySelectorAll('.mini-galeri-item').forEach((item, i) => {
                if (i === currentSlide) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });

            // Scroll ke miniatur aktif
            const activeMini = document.querySelector('.mini-galeri-item.active');
            if (activeMini) {
                activeMini.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest',
                    inline: 'center'
                });
            }
        }

        // Navigasi keyboard
        document.addEventListener('keydown', function(event) {
            if (document.getElementById('detailModal').classList.contains('pointer-events-auto')) {
                if (event.key === 'ArrowLeft' && galeriItems.length > 1) {
                    goToSlide(currentSlide - 1);
                } else if (event.key === 'ArrowRight' && galeriItems.length > 1) {
                    goToSlide(currentSlide + 1);
                } else if (event.key === 'Escape') {
                    hideDetailModal();
                }
            }
        });

        function hideDetailModal() {
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            backdrop.classList.remove('bg-gray-900/70');
            backdrop.classList.add('bg-gray-900/60');
            content.classList.remove('scale-100', 'translate-y-0');
            content.classList.add('scale-95', 'translate-y-4');

            setTimeout(() => {
                modal.classList.remove('pointer-events-auto');
                modal.classList.add('pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function konfirmasiHapusKamar(id, kodeKamar) {
            Swal.fire({
                title: 'Hapus Kamar?',
                html: `
                <div class="text-center">
                    <p class="text-slate-700 mb-2">Anda akan menghapus kamar:</p>
                    <p class="text-lg font-bold text-red-600 mb-3">${kodeKamar}</p>
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

    <style>
        .aspect-w-16 {
            position: relative;
        }

        .aspect-w-16::before {
            content: "";
            display: block;
            padding-bottom: 75%;
            /* 4:3 Aspect Ratio */
        }

        .aspect-w-16>* {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        /* Smooth transitions for all interactive elements */
        .transition-all {
            transition-property: all;
        }

        /* Custom scrollbar for modal */
        #detailModal ::-webkit-scrollbar {
            width: 6px;
        }

        #detailModal ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Sembunyikan scrollbar horizontal */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Styling miniatur galeri */
        .mini-galeri-item {
            @apply flex-shrink-0 w-16 h-16 rounded-lg border-2 border-slate-200 overflow-hidden transition-all duration-200 cursor-pointer;
        }

        .mini-galeri-item.active {
            @apply border-cyan-500 ring-2 ring-cyan-200;
        }

        .mini-galeri-item img {
            @apply w-full h-full object-cover;
        }

        /* Sesuaikan aspect ratio */
        .aspect-w-16::before {
            padding-bottom: 75%;
        }

        .aspect-w-16>* {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }

        /* Smooth modal */
        #detailModal ::-webkit-scrollbar {
            width: 6px;
        }

        #detailModal ::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 3px;
        }

        #detailModal ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }

        /* Sembunyikan scrollbar horizontal */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Styling miniatur galeri */
        .mini-galeri-item {
            @apply flex-shrink-0 w-16 h-16 rounded-lg border-2 border-slate-200 overflow-hidden transition-all duration-200 cursor-pointer;
        }

        .mini-galeri-item.active {
            @apply border-cyan-500 ring-2 ring-cyan-200;
        }

        .mini-galeri-item img {
            @apply w-full h-full object-cover;
        }

        /* Custom backdrop blur for modal */
        #modalBackdrop {
            backdrop-filter: blur(4px);
        }
    </style>
@endsection
