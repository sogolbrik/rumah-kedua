@extends('layouts.admin-main')

@section('title', 'Transaksi')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                Daftar Transaksi
            </h1>
            <p class="mt-0.5 text-sm text-slate-600">Semua informasi transaksi ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <div>
            <a href="{{ route('transaksi.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-2.5 text-sm font-medium hover:from-blue-700 hover:to-indigo-700 shadow-md hover:shadow-lg transition-all duration-200">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah Transaksi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 rounded-xl bg-emerald-50 border border-emerald-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-2 text-emerald-800">
                <i class="fa-solid fa-circle-check text-lg"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-xl bg-red-50 border border-red-200/60 p-4 shadow-sm">
            <div class="flex items-center gap-2 text-red-800">
                <i class="fa-solid fa-circle-exclamation text-lg"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="mt-4 rounded-2xl border border-slate-200/40 bg-white overflow-hidden shadow-[0_4px_20px_-8px_rgba(0,0,0,0.06)]">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gradient-to-r from-slate-50 to-white border-b border-slate-200/50">
                    <tr>
                        <th class="text-left px-6 py-4 w-12">
                            <span class="text-slate-500">#</span>
                        </th>
                        <th class="text-left px-6 py-4">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-hashtag text-xs text-slate-500"></i>
                                Kode Transaksi
                            </span>
                        </th>
                        <th class="text-left px-6 py-4">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-money-bill-wave text-xs text-green-500"></i>
                                Total Bayar
                            </span>
                        </th>
                        <th class="text-left px-6 py-4 w-36">
                            <span class="text-slate-700 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-xs text-amber-500"></i>
                                Status
                            </span>
                        </th>
                        <th class="text-right px-6 py-4 w-52">
                            <span class="text-slate-700 font-medium flex items-center gap-2 justify-end">
                                <i class="fa-solid fa-gears text-xs text-slate-500"></i>
                                Aksi
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/60">
                    @forelse ($transaksis as $transaksi)
                        <tr class="hover:bg-slate-50/70 transition-colors duration-200 group">
                            <td class="px-6 py-4 font-medium text-slate-700 align-top">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col">
                                    <span class="font-semibold text-slate-900 group-hover:text-indigo-900">{{ $transaksi->kode }}</span>
                                    @if ($transaksi->midtrans_order_id)
                                        <span class="text-xs text-slate-500 mt-1 truncate max-w-[180px]">{{ $transaksi->midtrans_order_id }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-money-bill-wave text-green-500 text-sm"></i>
                                    <span class="text-slate-900 font-medium">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @php
                                    $statusConfig = [
                                        'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-800 border-yellow-200', 'icon' => 'fa-clock'],
                                        'paid' => ['label' => 'Lunas', 'color' => 'bg-emerald-100 text-emerald-800 border-emerald-200', 'icon' => 'fa-circle-check'],
                                        'failed' => ['label' => 'Gagal', 'color' => 'bg-red-100 text-red-800 border-red-200', 'icon' => 'fa-circle-exclamation'],
                                        'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-slate-100 text-slate-800 border-slate-200', 'icon' => 'fa-ban'],
                                        'expired' => ['label' => 'Kadaluarsa', 'color' => 'bg-gray-100 text-gray-800 border-gray-200', 'icon' => 'fa-hourglass-end'],
                                        'challenge' => ['label' => 'Tantangan', 'color' => 'bg-blue-100 text-blue-800 border-blue-200', 'icon' => 'fa-shield-halved'],
                                    ];
                                    $status = $statusConfig[$transaksi->status_pembayaran] ?? [
                                        'label' => 'Tidak Diketahui',
                                        'color' => 'bg-slate-100 text-slate-800 border-slate-200',
                                        'icon' => 'fa-circle',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border {{ $status['color'] }} transition-all duration-150 group-hover:scale-105 group-hover:shadow-sm">
                                    <i class="fa-solid {{ $status['icon'] }} text-xs"></i>
                                    {{ $status['label'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="showDetailModal({{ $transaksi->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-100 hover:border-slate-300 transition-all shadow-sm hover:shadow">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        Detail
                                    </button>

                                    @if (in_array($transaksi->status_pembayaran, ['failed', 'cancelled', 'expired']))
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="inline" id="hapus-data-{{ $transaksi->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-sm bg-white border border-red-200 text-red-700 hover:bg-red-50 hover:border-red-300 transition-all shadow-sm hover:shadow"
                                                onclick="konfirmasiHapusTransaksi({{ $transaksi->id }}, '{{ $transaksi->kode }}')">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                                <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-slate-100 text-slate-400 mb-3">
                                    <i class="fa-regular fa-credit-card text-2xl"></i>
                                </div>
                                <p class="text-base font-medium">Tidak ada transaksi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transaksis->hasPages())
            <div class="border-t border-slate-200/30 px-6 py-4 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-3">
                    <p class="text-sm text-slate-600 text-center sm:text-left">
                        Menampilkan <span class="font-bold text-slate-800">{{ $transaksis->firstItem() }}</span>–
                        <span class="font-bold text-slate-800">{{ $transaksis->lastItem() }}</span> dari
                        <span class="font-bold text-slate-800">{{ $transaksis->total() }}</span> hasil
                    </p>
                    <div class="flex gap-2">
                        @if ($transaksis->onFirstPage())
                            <span class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-slate-100 text-slate-400 cursor-not-allowed font-medium">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </span>
                        @else
                            <a href="{{ $transaksis->previousPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-medium shadow-sm hover:shadow transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i> Sebelumnya
                            </a>
                        @endif

                        @if ($transaksis->hasMorePages())
                            <a href="{{ $transaksis->nextPageUrl() }}"
                                class="inline-flex items-center px-4 py-2 rounded-lg text-sm bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-medium shadow-md hover:shadow-lg hover:from-emerald-700 hover:to-teal-700 transition-all">
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

    <!-- Modal Detail Transaksi -->
    <div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto transition-all duration-300 ease-out opacity-0 pointer-events-none">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div id="modalBackdrop" class="fixed inset-0 transition-all duration-300 ease-out bg-[#094067]/60 backdrop-blur-sm" onclick="hideDetailModal()"></div>

            <div id="modalContent"
                class="relative inline-block w-full max-w-4xl overflow-hidden text-left align-bottom transition-all duration-300 ease-out transform scale-95 translate-y-4 bg-[#fffffe] rounded-3xl shadow-2xl sm:my-8 sm:align-middle">

                <div class="px-8 py-7 border-b border-[#90b4ce]/20 flex items-center justify-between bg-[#fffffe]">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-[#3da9fc] text-[#fffffe] shadow-lg shadow-[#3da9fc]/20">
                            <i class="fa-solid fa-receipt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-[#094067]" id="modalKodeTransaksi">Detail Transaksi</h3>
                            <p class="text-sm font-medium text-[#5f6c7b] tracking-wide" id="modalKode">TRX-ID-XXXX</p>
                        </div>
                    </div>
                    <button type="button" onclick="hideDetailModal()" class="p-2 text-[#5f6c7b] hover:text-[#094067] transition-all rounded-xl hover:bg-[#90b4ce]/10">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12">

                    <div class="lg:col-span-5 p-8 bg-[#90b4ce]/5 border-r border-[#90b4ce]/10 space-y-8">

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-[#094067]">
                                <i class="fa-solid fa-user-circle text-xs"></i>
                                <span class="text-[11px] font-bold uppercase tracking-widest">Informasi Pelanggan</span>
                            </div>
                            <div class="bg-[#fffffe] p-5 rounded-2xl border border-[#90b4ce]/30 shadow-sm flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-[#3da9fc]/10 text-[#3da9fc] flex items-center justify-center font-bold text-lg border border-[#3da9fc]/20">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-[11px] text-[#5f6c7b] uppercase font-bold tracking-tighter">Nama Pelanggan</p>
                                    <p id="modalPelanggan" class="font-bold text-[#094067] text-lg leading-tight"></p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center gap-2 text-[#094067]">
                                <i class="fa-solid fa-door-open text-xs"></i>
                                <span class="text-[11px] font-bold uppercase tracking-widest">Detail Hunian</span>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-[#fffffe] p-4 rounded-2xl border border-[#90b4ce]/30 shadow-sm">
                                    <p class="text-[10px] text-[#5f6c7b] uppercase font-bold mb-1">Kamar</p>
                                    <p id="modalKamar" class="text-lg font-bold text-[#094067]"></p>
                                </div>
                                <div class="bg-[#fffffe] p-4 rounded-2xl border border-[#90b4ce]/30 shadow-sm">
                                    <p class="text-[10px] text-[#5f6c7b] uppercase font-bold mb-1">Durasi</p>
                                    <p id="modalDurasi" class="text-lg font-bold text-[#094067]"></p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-[#fffffe] rounded-2xl p-5 border border-[#90b4ce]/30 space-y-4 shadow-sm">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-[#5f6c7b]">Tgl Pembayaran</span>
                                <span id="modalTanggal" class="font-bold text-[#094067]"></span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-[#5f6c7b]">Metode</span>
                                <span id="modalMetode" class="px-3 py-1 rounded-lg bg-[#3da9fc] text-[#fffffe] font-bold text-[10px] uppercase"></span>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-7 p-8 bg-[#fffffe] space-y-8">

                        <div class="relative overflow-hidden bg-[#094067] rounded-3xl p-8 shadow-xl shadow-[#094067]/20">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-[#3da9fc]/10 rounded-full -mr-16 -mt-16"></div>
                            <div class="relative z-10">
                                <p class="text-[#90b4ce] text-sm font-medium mb-1">Total yang dibayar</p>
                                <h2 id="modalTotal" class="text-4xl lg:text-5xl font-black text-[#fffffe] tracking-tight"></h2>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center gap-2 text-[#094067]">
                                    <i class="fa-solid fa-shield-halved text-xs"></i>
                                    <span class="text-[11px] font-bold uppercase tracking-widest">Status Pembayaran</span>
                                </div>
                                <div class="h-2 w-2 rounded-full bg-[#ef4565] animate-pulse"></div>
                            </div>

                            <div class="p-6 rounded-2xl bg-[#fffffe] border-2 border-dashed border-[#90b4ce]/40 flex items-center justify-center min-h-[80px]">
                                <div id="modalStatus" class="w-full flex justify-center text-center font-bold uppercase tracking-widest text-[#094067]">
                                </div>
                            </div>
                        </div>

                        <div id="modalAksi" class="pt-4">
                        </div>

                    </div>
                </div>

                <div class="px-8 py-6 bg-[#90b4ce]/5 border-t border-[#90b4ce]/10 flex justify-end">
                    <button type="button" onclick="hideDetailModal()"
                        class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition-all duration-200 shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-arrow-left text-xs"></i>
                        Kembali
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data transaksi dari server
        const transaksiData = @json($transaksis->keyBy('id')->toArray());

        // Fungsi untuk menampilkan modal detail dengan animasi
        function showDetailModal(transaksiId) {
            const transaksi = transaksiData[transaksiId];
            if (!transaksi) return;

            // Isi data ke modal
            document.getElementById('modalKodeTransaksi').textContent = `Transaksi ${transaksi.kode}`;
            document.getElementById('modalKode').textContent = transaksi.kode;
            document.getElementById('modalTanggal').textContent = new Date(transaksi.tanggal_pembayaran).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });
            document.getElementById('modalMetode').textContent = transaksi.metode_pembayaran.toUpperCase();
            document.getElementById('modalPelanggan').textContent = transaksi.user.name;
            document.getElementById('modalTotal').textContent = `Rp ${formatRupiah(transaksi.total_bayar)}`;
            document.getElementById('modalKamar').textContent = transaksi.kamar?.kode_kamar ?? '—';
            document.getElementById('modalDurasi').textContent = transaksi.durasi ? transaksi.durasi + ' Bulan' : '—';

            // Set status
            const statusElement = document.getElementById('modalStatus');
            const statusColors = {
                'pending': 'bg-yellow-100 text-yellow-800 border-yellow-200',
                'paid': 'bg-emerald-100 text-emerald-800 border-emerald-200',
                'failed': 'bg-red-100 text-red-800 border-red-200',
                'cancelled': 'bg-slate-100 text-slate-800 border-slate-200',
                'expired': 'bg-gray-100 text-gray-800 border-gray-200',
                'challenge': 'bg-blue-100 text-blue-800 border-blue-200',
            };
            const statusIcons = {
                'pending': 'fa-clock',
                'paid': 'fa-circle-check',
                'failed': 'fa-circle-exclamation',
                'cancelled': 'fa-ban',
                'expired': 'fa-hourglass-end',
                'challenge': 'fa-shield-halved',
            };

            statusElement.innerHTML = `
                <span class="text-slate-600">Status:</span>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border ${statusColors[transaksi.status_pembayaran] || 'bg-slate-100 text-slate-800 border-slate-200'}">
                    <i class="fa-solid ${statusIcons[transaksi.status_pembayaran] || 'fa-circle'} text-xs"></i>
                    ${transaksi.status_pembayaran.charAt(0).toUpperCase() + transaksi.status_pembayaran.slice(1)}
                </span>
            `;

            // Set aksi tambahan
            const aksiElement = document.getElementById('modalAksi');
            let aksiHTML = '';

            if (transaksi.metode_pembayaran === 'midtrans' && transaksi.status_pembayaran === 'pending') {
                aksiHTML = `
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-credit-card text-blue-600"></i>
                        Aksi Pembayaran
                    </h4>
                    <div class="flex gap-2">
                        <a href="/transaksi/${transaksi.id}/payment" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-yellow-100 border border-yellow-200 text-yellow-800 hover:bg-yellow-200 hover:border-yellow-300 transition-colors">
                            <i class="fa-solid fa-credit-card text-xs"></i>
                            Lanjutkan Pembayaran
                        </a>
                        <form action="/transaksi/${transaksi.id}/cancel" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <button type="button" onclick="konfirmasiBatalkanTransaksi(${transaksi.id}, '${transaksi.kode}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors">
                                <i class="fa-solid fa-times text-xs"></i>
                                Batalkan
                            </button>
                        </form>
                    </div>
                `;
            } else if (['failed', 'cancelled', 'expired'].includes(transaksi.status_pembayaran)) {
                aksiHTML = `
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-trash text-red-600"></i>
                        Aksi Transaksi
                    </h4>
                    <div class="flex gap-2">
                        <form action="/transaksi/${transaksi.id}" method="POST" class="inline" id="hapus-transaksi-${transaksi.id}">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="konfirmasiHapusTransaksi(${transaksi.id}, '${transaksi.kode}')"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors">
                                <i class="fa-solid fa-trash-can text-xs"></i>
                                Hapus Transaksi
                            </button>
                        </form>
                    </div>
                `;
            } else {
                aksiHTML = `
                    <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-info-circle text-blue-600"></i>
                        Informasi
                    </h4>
                    <p class="text-sm text-slate-600">Tidak ada aksi tambahan yang tersedia untuk transaksi ini.</p>
                `;
            }

            aksiElement.innerHTML = aksiHTML;

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

        function konfirmasiHapusTransaksi(id, kodeTransaksi) {
            Swal.fire({
                title: 'Hapus Transaksi?',
                html: `
                    <div class="text-center">
                        <p class="text-slate-700 mb-2">Anda akan menghapus transaksi:</p>
                        <p class="text-lg font-bold text-red-600 mb-3">${kodeTransaksi}</p>
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

        function konfirmasiBatalkanTransaksi(id, kodeTransaksi) {
            Swal.fire({
                title: 'Batalkan Transaksi?',
                html: `
                    <div class="text-center">
                        <p class="text-slate-700 mb-2">Anda akan membatalkan transaksi:</p>
                        <p class="text-lg font-bold text-yellow-600 mb-3">${kodeTransaksi}</p>
                        <p class="text-sm text-slate-500">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d97706',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="fa-solid fa-times mr-2"></i>Ya, Batalkan',
                cancelButtonText: '<i class="fa-solid fa-times mr-2"></i>Batal',
                reverseButtons: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-800 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-2',
                    cancelButton: 'inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Submit form pembatalan
                    const form = document.querySelector(`form[action="/transaksi/${id}/cancel"]`);
                    if (form) {
                        form.submit();
                    }
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

        /* Ensure vertical alignment in table cells */
        .align-top {
            vertical-align: top;
        }
    </style>
@endsection
