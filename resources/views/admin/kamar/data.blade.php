@extends('layouts.admin-main')

@section('title', 'Kamar')

@section('admin-main')
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
                                @if ($item->is_maintenance == true)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fa-solid fa-wrench text-xs"></i> Maintenance
                                    </span>
                                @elseif($item->status == 'Tersedia')
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
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">
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
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium shadow-md hover:shadow-lg transition-all">
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

    <div id="detailModal" class="fixed inset-0 z-[60] overflow-y-auto hidden opacity-0 transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalBackdrop" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="hideDetailModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div id="modalContent"
                class="relative inline-block w-full max-w-4xl px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:p-6 scale-95 translate-y-4">

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-600">
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

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div class="relative group">
                            <div class="aspect-video bg-slate-100 rounded-xl overflow-hidden border border-slate-200">
                                <img id="galeriUtama" src="" alt="Galeri Kamar" class="w-full h-full object-cover">
                            </div>

                            <button id="prevBtn" type="button"
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 shadow text-slate-700 hover:bg-white transition-all hidden">
                                <i class="fa-solid fa-chevron-left text-xs"></i>
                            </button>
                            <button id="nextBtn" type="button"
                                class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-white/90 shadow text-slate-700 hover:bg-white transition-all hidden">
                                <i class="fa-solid fa-chevron-right text-xs"></i>
                            </button>
                        </div>

                        <div id="miniGaleri" class="flex gap-2 overflow-x-auto pb-2 hide-scrollbar"></div>

                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-blue-600"></i> Informasi Utama
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">Status:</span>
                                    <span id="modalStatus"></span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">Tipe:</span>
                                    <span id="modalTipe" class="font-bold text-slate-900 uppercase"></span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-slate-600">Luas:</span>
                                    <span id="modalLebar" class="font-bold text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 border border-blue-100">
                            <p class="text-xs text-blue-700 font-bold uppercase tracking-wider mb-1">Harga Sewa / Bulan</p>
                            <p id="modalHarga" class="text-3xl font-black text-blue-900"></p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-slate-900 mb-2 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-file-lines text-slate-400"></i> Deskripsi
                            </h4>
                            <p id="modalDeskripsi" class="text-sm text-slate-600 leading-relaxed bg-slate-50 p-3 rounded-lg border border-slate-100"></p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2 text-sm">
                                <i class="fa-solid fa-star text-amber-500"></i> Fasilitas
                            </h4>
                            <div id="modalFasilitas" class="grid grid-cols-2 gap-2"></div>
                        </div>
                    </div>
                </div>

                <!-- Di dalam modal, bagian aksi -->
                <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-100">
                    <button type="button" onclick="hideDetailModal()" class="px-5 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 transition-colors">
                        Tutup
                    </button>

                    <form id="formSetMaintenance" method="POST" style="display:none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_maintenance" value="1">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Set Maintenance
                        </button>
                    </form>

                    <form id="formAktifkanKamar" method="POST" style="display:none;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_maintenance" value="0">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Aktifkan Kamar
                        </button>
                    </form>

                    <a href="#" id="modalEditLink" class="px-5 py-2 text-sm font-bold text-white bg-blue-600 rounded-xl hover:bg-blue-700 shadow-md transition-all">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Data Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        const kamarData = @json($kamar->keyBy('id'));
        let currentSlide = 0;
        let galeriItems = [];

        function showDetailModal(id) {
            const data = kamarData[id];
            if (!data) return;

            document.getElementById('modalKodeKamar').textContent = 'Unit ' + data.kode_kamar;
            document.getElementById('modalHarga').textContent = 'Rp' + new Intl.NumberFormat('id-ID').format(data.harga);
            document.getElementById('modalTipe').textContent = data.tipe;
            document.getElementById('modalLebar').textContent = data.lebar + ' m²';
            document.getElementById('modalDeskripsi').textContent = data.deskripsi || 'Tidak ada deskripsi untuk kamar ini.';
            document.getElementById('modalEditLink').href = `kamar/${data.id}/edit`;

            const statusTarget = document.getElementById('modalStatus');
            if (data.status === 'Tersedia') {
                statusTarget.className = "px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200";
                statusTarget.innerHTML = "TERSEDIA";
            } else {
                statusTarget.className = "px-3 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200";
                statusTarget.innerHTML = "TERISI";
            }

            const fasilContainer = document.getElementById('modalFasilitas');
            fasilContainer.innerHTML = '';
            if (data.detail_kamar && data.detail_kamar.length > 0) {
                data.detail_kamar.forEach(f => {
                    fasilContainer.innerHTML += `
                        <div class="flex items-center gap-2 p-2 rounded-lg border border-slate-100 bg-white text-xs text-slate-700 font-medium">
                            <i class="fa-solid fa-check-circle text-emerald-500"></i> ${f.fasilitas}
                        </div>`;
                });
            } else {
                fasilContainer.innerHTML = '<p class="text-xs text-slate-400 italic col-span-2">Belum ada fasilitas terdaftar</p>';
            }

            galeriItems = [];
            if (data.gambar) galeriItems.push(`/storage/${data.gambar}`);
            if (data.galeri) {
                data.galeri.forEach(g => {
                    if (g.foto) galeriItems.push(`/storage/${g.foto}`);
                });
            }
            if (galeriItems.length === 0) galeriItems.push('https://via.placeholder.com/800x600?text=No+Image');

            currentSlide = 0;
            updateGalleryUI();

            const modal = document.getElementById('detailModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                document.getElementById('modalContent').classList.remove('scale-95', 'translate-y-4');
                document.getElementById('modalContent').classList.add('scale-100', 'translate-y-0');
            }, 10);
            document.body.style.overflow = 'hidden';

            const formSet = document.getElementById('formSetMaintenance');
            const formAktif = document.getElementById('formAktifkanKamar');

            formSet.action = '';
            formAktif.action = '';

            if (data.is_maintenance) {
                formAktif.action = `/kamar/maintenance/${data.id}`;
                formAktif.style.display = 'inline-block';
                formSet.style.display = 'none';
            } else {
                formSet.action = `/kamar/maintenance/${data.id}`;
                formSet.style.display = 'inline-block';
                formAktif.style.display = 'none';
            }

            setTimeout(() => {
                attachMaintenanceConfirm();
            }, 100);

        }

        function updateGalleryUI() {
            const mainImg = document.getElementById('galeriUtama');
            const mini = document.getElementById('miniGaleri');
            const pBtn = document.getElementById('prevBtn');
            const nBtn = document.getElementById('nextBtn');

            mainImg.src = galeriItems[currentSlide];
            mini.innerHTML = '';

            if (galeriItems.length > 1) {
                pBtn.classList.remove('hidden');
                nBtn.classList.remove('hidden');
                galeriItems.forEach((src, idx) => {
                    mini.innerHTML += `
                        <div onclick="currentSlide=${idx}; updateGalleryUI()" 
                             class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 cursor-pointer transition-all ${currentSlide === idx ? 'border-blue-500 ring-2 ring-blue-100' : 'border-slate-200 opacity-60 hover:opacity-100'}">
                            <img src="${src}" class="w-full h-full object-cover">
                        </div>`;
                });
            } else {
                pBtn.classList.add('hidden');
                nBtn.classList.add('hidden');
            }
        }

        document.getElementById('prevBtn').onclick = () => {
            currentSlide = currentSlide > 0 ? currentSlide - 1 : galeriItems.length - 1;
            updateGalleryUI();
        };

        document.getElementById('nextBtn').onclick = () => {
            currentSlide = currentSlide < galeriItems.length - 1 ? currentSlide + 1 : 0;
            updateGalleryUI();
        };

        function hideDetailModal() {
            const modal = document.getElementById('detailModal');
            modal.classList.remove('opacity-100');
            document.getElementById('modalContent').classList.add('scale-95', 'translate-y-4');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
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

        function attachMaintenanceConfirm() {
            const btnSet = document.querySelector('#formSetMaintenance button[type="submit"]');
            if (btnSet) {
                btnSet.onclick = function(e) {
                    e.preventDefault();
                    const kodeKamar = document.getElementById('modalKodeKamar').textContent.replace('Unit ', '');
                    konfirmasiMaintenance(true, kodeKamar, () => {
                        document.getElementById('formSetMaintenance').submit();
                    });
                }
            }

            const btnAktif = document.querySelector('#formAktifkanKamar button[type="submit"]');
            if (btnAktif) {
                btnAktif.onclick = function(e) {
                    e.preventDefault();
                    const kodeKamar = document.getElementById('modalKodeKamar').textContent.replace('Unit ', '');
                    konfirmasiMaintenance(false, kodeKamar, () => {
                        document.getElementById('formAktifkanKamar').submit();
                    });
                }
            }
        }

        function konfirmasiMaintenance(isMaintenance, kodeKamar, onConfirm) {
            const title = isMaintenance ? 'Set Maintenance?' : 'Aktifkan Kamar?';
            const message = isMaintenance ?
                `Kamar <strong>${kodeKamar}</strong> akan dimasukkan ke mode maintenance. Penghuni tidak bisa memilih kamar ini.` :
                `Kamar <strong>${kodeKamar}</strong> akan diaktifkan kembali dan tersedia untuk disewa.`;
            const confirmText = isMaintenance ?
                '<i class="fa-solid fa-wrench mr-2"></i>Ya, Set Maintenance' :
                '<i class="fa-solid fa-check-circle mr-2"></i>Ya, Aktifkan';
            const confirmColor = isMaintenance ? '#d97706' : '#059669';

            Swal.fire({
                title: title,
                html: `<div class="text-center"><p class="text-slate-700">${message}</p></div>`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: confirmColor,
                cancelButtonColor: '#6b7280',
                confirmButtonText: confirmText,
                cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Batal',
                reverseButtons: true,
                buttonsStyling: true,
                customClass: {
                    confirmButton: 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 transition ease-in-out duration-150 ml-2',
                    cancelButton: 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    onConfirm();
                }
            });
        }
    </script>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        #modalContent {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endsection
