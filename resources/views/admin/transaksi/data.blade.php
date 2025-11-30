@extends('layouts.admin-main')

@section('title', 'Transaksi')

@section('admin-main')
<!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Transaksi</h1>
            <p class="mt-0.5 text-sm text-slate-600">Semua informasi transaksi ada di sini, gampang banget buat dilihat dan dikelola.</p>
        </div>
        <div>
            <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors">
                <i class="fa-solid fa-plus-circle text-sm"></i>
                Tambah Transaksi
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mt-4 rounded-lg bg-emerald-50 border border-emerald-200 p-4">
            <div class="flex items-center gap-2 text-emerald-800">
                <i class="fa-solid fa-circle-check"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="mt-4 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex items-center gap-2 text-red-800">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <div class="mt-4 rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-4 w-12">No</th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-hashtag mr-2 text-xs"></i>
                            Kode Transaksi
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-money-bill-wave mr-2 text-xs"></i>
                            Total Bayar
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
                    @foreach ($transaksis as $transaksi)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700 align-top">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col">
                                    <span class="font-medium text-slate-900">{{ $transaksi->kode }}</span>
                                    @if ($transaksi->midtrans_order_id)
                                        <span class="text-xs text-slate-500 mt-1">{{ $transaksi->midtrans_order_id }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-money-bill-wave text-green-500 text-sm"></i>
                                    <span class="text-slate-900">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-top">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'paid' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'failed' => 'bg-red-100 text-red-800 border-red-200',
                                        'cancelled' => 'bg-slate-100 text-slate-800 border-slate-200',
                                        'expired' => 'bg-gray-100 text-gray-800 border-gray-200',
                                        'challenge' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    ];
                                    $statusIcons = [
                                        'pending' => 'fa-clock',
                                        'paid' => 'fa-circle-check',
                                        'failed' => 'fa-circle-exclamation',
                                        'cancelled' => 'fa-ban',
                                        'expired' => 'fa-hourglass-end',
                                        'challenge' => 'fa-shield-halved',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium border {{ $statusColors[$transaksi->status_pembayaran] ?? 'bg-slate-100 text-slate-800 border-slate-200' }}">
                                    <i class="fa-solid {{ $statusIcons[$transaksi->status_pembayaran] ?? 'fa-circle' }} text-xs"></i>
                                    {{ ucfirst($transaksi->status_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 align-top">
                                <div class="flex justify-end gap-2">
                                    <button type="button" onclick="showDetailModal({{ $transaksi->id }})"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-slate-100 border border-slate-200 text-slate-700 hover:bg-slate-200 hover:border-slate-300 transition-colors">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                        Detail
                                    </button>

                                    @if (in_array($transaksi->status_pembayaran, ['failed', 'cancelled', 'expired']))
                                        <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" class="inline" id="hapus-data-{{ $transaksi->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors"
                                                onclick="konfirmasiHapusTransaksi({{ $transaksi->id }}, '{{ $transaksi->kode }}')">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transaksis->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan
                        <span class="font-medium">{{ $transaksis->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $transaksis->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $transaksis->total() }}</span>
                        hasil
                    </p>
                    <div class="flex gap-1">
                        @if ($transaksis->onFirstPage())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $transaksis->previousPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </a>
                        @endif

                        @if ($transaksis->hasMorePages())
                            <a href="{{ $transaksis->nextPageUrl() }}"
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

    <!-- Modal Detail Transaksi -->
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
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-600">
                            <i class="fa-solid fa-receipt text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-slate-900" id="modalKodeTransaksi">Detail Transaksi</h3>
                            <p class="text-sm text-slate-600">Informasi lengkap transaksi</p>
                        </div>
                    </div>
                    <button type="button" onclick="hideDetailModal()" class="p-2 text-slate-400 hover:text-slate-600 transition-colors rounded-lg hover:bg-slate-100">
                        <i class="fa-solid fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Content Modal -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Informasi Utama -->
                    <div class="space-y-4">
                        <!-- Informasi Transaksi -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-blue-600"></i>
                                Informasi Transaksi
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Kode Transaksi:</span>
                                    <span id="modalKode" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Tanggal Pembayaran:</span>
                                    <span id="modalTanggal" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Metode Pembayaran:</span>
                                    <span id="modalMetode" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Pelanggan -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user text-cyan-600"></i>
                                Informasi Pelanggan
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Nama:</span>
                                    <span id="modalPelanggan" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Informasi -->
                    <div class="space-y-6">
                        <!-- Total Bayar -->
                        <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-200 shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600">
                                    <i class="fa-solid fa-money-bill-wave"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-emerald-700 font-medium">Total Bayar</p>
                                    <p id="modalTotal" class="text-2xl font-bold text-emerald-900"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Pembayaran -->
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-circle-info text-amber-600"></i>
                                Status Pembayaran
                            </h4>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                                <div id="modalStatus" class="flex items-center justify-between">
                                    <!-- Status akan diisi oleh JavaScript -->
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Kamar -->
                        <div>
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-door-open text-purple-600"></i>
                                Informasi Kamar
                            </h4>
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                                <div class="space-y-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-600">Kamar:</span>
                                        <span id="modalKamar" class="font-medium text-slate-900"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-slate-600">Durasi:</span>
                                        <span id="modalDurasi" class="font-medium text-slate-900"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Aksi Tambahan -->
                        <div id="modalAksi" class="bg-blue-50 rounded-xl p-4 border border-blue-200 shadow-sm">
                            <!-- Aksi tambahan akan diisi oleh JavaScript -->
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
