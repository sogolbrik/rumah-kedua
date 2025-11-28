@extends('layouts.admin-main')

@section('title', 'Kamar')

@section('admin-main')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Daftar Kamar</h1>
            <p class="mt-1 text-sm text-slate-600">Semua informasi kamar ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <a href="{{ Route('kamar.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-plus-circle text-sm"></i>
            Tambah Kamar
        </a>
    </div>

    <div class="mt-4 rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-4 w-12">No</th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-hashtag mr-2 text-xs"></i>
                            Kode Kamar
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-tag mr-2 text-xs"></i>
                            Harga
                        </th>
                        <th class="text-left px-6 py-4 w-36">
                            <i class="fa-solid fa-circle-info mr-2 text-xs"></i>
                            Status
                        </th>
                        <th class="text-right px-6 py-4 w-52">
                            <i class="fa-solid fa-gears mr-2 text-xs"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($kamar as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-door-closed text-slate-400 text-sm"></i>
                                    <span class="font-medium text-slate-900">{{ $item->kode_kamar }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-money-bill-wave text-green-500 text-sm"></i>
                                    <span class="text-slate-900">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'Tersedia')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                        <i class="fa-solid fa-bed text-xs"></i>
                                        Terisi
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="showDetailModal({{ $item->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 hover:border-slate-300 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        Detail
                                    </button>
                                    <a href="{{ route('kamar.edit', $item->id) }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-blue-100 border border-blue-200 text-blue-700 hover:bg-blue-200 hover:border-blue-300 transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        Edit
                                    </a>
                                    <form action="{{ route('kamar.destroy', $item->id) }}" method="POST" class="inline" id="hapus-data-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors"
                                            onclick="konfirmasiHapusKamar({{ $item->id }}, '{{ $item->kode_kamar }}')">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kamar->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan
                        <span class="font-medium">{{ $kamar->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $kamar->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $kamar->total() }}</span>
                        hasil
                    </p>
                    <div class="flex gap-1">
                        @if ($kamar->onFirstPage())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $kamar->previousPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </a>
                        @endif

                        @if ($kamar->hasMorePages())
                            <a href="{{ $kamar->nextPageUrl() }}"
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
                        <div class="aspect-w-16 aspect-h-12 bg-slate-100 rounded-xl overflow-hidden border border-slate-200 shadow-sm">
                            <img id="modalGambar" src="" alt="Gambar Kamar" class="w-full h-64 object-cover transition-transform duration-300 hover:scale-105">
                        </div>

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
        // Data kamar dari server (bisa juga di-fetch via AJAX)
        const kamarData = @json($kamar->keyBy('id')->toArray());

        // Fungsi untuk menampilkan modal detail dengan animasi
        function showDetailModal(kamarId) {
            const kamar = kamarData[kamarId];
            if (!kamar) return;

            // Isi data ke modal
            document.getElementById('modalKodeKamar').textContent = `Kamar ${kamar.kode_kamar}`;
            document.getElementById('modalGambar').src = kamar.gambar ? `/storage/${kamar.gambar}` : '/images/default-room.jpg';
            document.getElementById('modalGambar').alt = `Kamar ${kamar.kode_kamar}`;
            document.getElementById('modalHarga').textContent = `Rp ${formatRupiah(kamar.harga)}`;
            document.getElementById('modalTipe').textContent = kamar.tipe;
            document.getElementById('modalLebar').textContent = `${kamar.lebar} m²`;
            document.getElementById('modalDeskripsi').textContent = kamar.deskripsi || 'Tidak ada deskripsi';
            document.getElementById('modalEditLink').href = `/kamar/${kamar.id}/edit`;

            // Set status
            const statusElement = document.getElementById('modalStatus');
            if (kamar.status === 'Tersedia') {
                statusElement.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Tersedia';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200';
            } else {
                statusElement.innerHTML = '<i class="fa-solid fa-bed mr-1"></i> Terisi';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200';
            }

            // Isi fasilitas
            const fasilitasContainer = document.getElementById('modalFasilitas');
            fasilitasContainer.innerHTML = '';

            if (kamar.detail_kamar && kamar.detail_kamar.length > 0) {
                kamar.detail_kamar.forEach(fasilitas => {
                    const fasilitasItem = document.createElement('div');
                    fasilitasItem.className = 'flex items-center gap-2 px-3 py-2 bg-white border border-slate-200 rounded-lg transition-all duration-200 hover:bg-slate-50 hover:border-slate-300';
                    fasilitasItem.innerHTML = `
                        <i class="fa-solid fa-check text-emerald-500 text-xs"></i>
                        <span class="text-sm text-slate-700">${fasilitas.fasilitas}</span>
                    `;
                    fasilitasContainer.appendChild(fasilitasItem);
                });
            } else {
                fasilitasContainer.innerHTML = `
                    <div class="col-span-2 text-center py-4 text-slate-500">
                        <i class="fa-solid fa-info-circle mb-2 text-lg"></i>
                        <p>Tidak ada fasilitas tersedia</p>
                    </div>
                `;
            }

            // Tampilkan modal dengan animasi
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            modal.classList.remove('pointer-events-none');
            modal.classList.add('pointer-events-auto');

            // Trigger reflow untuk memastikan animasi berjalan
            void modal.offsetWidth;

            // Animasikan backdrop dan content
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                backdrop.classList.remove('bg-gray-900/60');
                backdrop.classList.add('bg-gray-900/70');
                content.classList.remove('scale-95', 'translate-y-4');
                content.classList.add('scale-100', 'translate-y-0');
            }, 10);

            document.body.classList.add('overflow-hidden');
        }

        // Fungsi untuk menyembunyikan modal dengan animasi
        function hideDetailModal() {
            const modal = document.getElementById('detailModal');
            const backdrop = document.getElementById('modalBackdrop');
            const content = document.getElementById('modalContent');

            // Animasikan keluar
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            backdrop.classList.remove('bg-gray-900/70');
            backdrop.classList.add('bg-gray-900/60');
            content.classList.remove('scale-100', 'translate-y-0');
            content.classList.add('scale-95', 'translate-y-4');

            // Tunggu animasi selesai sebelum menyembunyikan
            setTimeout(() => {
                modal.classList.remove('pointer-events-auto');
                modal.classList.add('pointer-events-none');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }

        // Fungsi format Rupiah
        function formatRupiah(angka) {
            return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Tutup modal dengan ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                hideDetailModal();
            }
        });

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
    </style>
@endsection
