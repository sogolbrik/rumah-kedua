@extends('layouts.admin-main')

@section('title', 'Transaksi')

@section('admin-main')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Daftar Transaksi</h1>
            <p class="mt-1 text-sm text-slate-600">Semua informasi transaksi pembayaran kamar ada di sini.</p>
        </div>
        <a href="{{ route('transaksi.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-4 py-2.5 text-sm font-medium hover:bg-blue-700 transition-colors">
            <i class="fa-solid fa-plus-circle text-sm"></i>
            Tambah Transaksi
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
                            Kode Transaksi
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-user mr-2 text-xs"></i>
                            User
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-door-closed mr-2 text-xs"></i>
                            Kamar
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-money-bill-wave mr-2 text-xs"></i>
                            Total Bayar
                        </th>
                        <th class="text-left px-6 py-4">
                            <i class="fa-solid fa-calendar mr-2 text-xs"></i>
                            Periode
                        </th>
                        <th class="text-left px-6 py-4 w-36">
                            <i class="fa-solid-circle-info mr-2 text-xs"></i>
                            Status
                        </th>
                        <th class="text-right px-6 py-4 w-52">
                            <i class="fa-solid fa-gears mr-2 text-xs"></i>
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($transaksi as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-receipt text-slate-400 text-sm"></i>
                                    <span class="font-medium text-slate-900">{{ $item->kode }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-user text-blue-500 text-sm"></i>
                                    <span class="text-slate-900">{{ $item->user->name ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-door-closed text-green-500 text-sm"></i>
                                    <span class="text-slate-900">{{ $item->kamar->kode_kamar ?? 'N/A' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-money-bill-wave text-emerald-500 text-sm"></i>
                                    <span class="text-slate-900">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-calendar text-purple-500 text-sm"></i>
                                    <span class="text-slate-900">{{ $item->periode_pembayaran }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status_pembayaran == 'paid')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-xs"></i>
                                        Lunas
                                    </span>
                                @elseif($item->status_pembayaran == 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                        <i class="fa-solid fa-clock text-xs"></i>
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <i class="fa-solid fa-times text-xs"></i>
                                        Gagal
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
                                    {{-- <form action="{{ route('transaksi.destroy', $item->id) }}" method="POST" class="inline" id="hapus-data-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md text-sm bg-red-100 border border-red-200 text-red-700 hover:bg-red-200 hover:border-red-300 transition-colors"
                                            onclick="konfirmasiHapusTransaksi({{ $item->id }}, '{{ $item->kode }}')">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                            Hapus
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($transaksi->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan
                        <span class="font-medium">{{ $transaksi->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $transaksi->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $transaksi->total() }}</span>
                        hasil
                    </p>
                    <div class="flex gap-1">
                        @if ($transaksi->onFirstPage())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $transaksi->previousPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </a>
                        @endif

                        @if ($transaksi->hasMorePages())
                            <a href="{{ $transaksi->nextPageUrl() }}"
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
                    <div class="space-y-6">
                        <!-- Informasi Transaksi -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-info-circle text-blue-600"></i>
                                Informasi Transaksi
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Kode:</span>
                                    <span id="modalKode" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Status:</span>
                                    <span id="modalStatus" class="px-3 py-1 rounded-full text-xs font-medium"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Metode Bayar:</span>
                                    <span id="modalMetode" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Total Bayar:</span>
                                    <span id="modalTotal" class="font-bold text-slate-900"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Waktu -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-clock text-amber-600"></i>
                                Informasi Waktu
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Tanggal Bayar:</span>
                                    <span id="modalTanggalBayar" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Jatuh Tempo:</span>
                                    <span id="modalJatuhTempo" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Periode:</span>
                                    <span id="modalPeriode" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Masuk Kamar:</span>
                                    <span id="modalMasukKamar" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Lainnya -->
                    <div class="space-y-6">
                        <!-- Informasi User & Kamar -->
                        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 rounded-xl p-4 border border-blue-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-user text-blue-600"></i>
                                Informasi User & Kamar
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">User:</span>
                                    <span id="modalUser" class="font-medium text-slate-900"></span>
                                </div>
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

                        <!-- Informasi Midtrans -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-purple-600"></i>
                                Informasi Pembayaran
                            </h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Order ID:</span>
                                    <span id="modalOrderId" class="font-mono text-xs text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Transaction ID:</span>
                                    <span id="modalTransactionId" class="font-mono text-xs text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Payment Type:</span>
                                    <span id="modalPaymentType" class="font-medium text-slate-900"></span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-slate-600">Expired At:</span>
                                    <span id="modalExpired" class="font-medium text-slate-900"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Response Midtrans -->
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-200 shadow-sm">
                            <h4 class="font-semibold text-slate-900 mb-3 flex items-center gap-2">
                                <i class="fa-solid fa-code text-slate-600"></i>
                                Response Midtrans
                            </h4>
                            <div class="max-h-32 overflow-y-auto">
                                <pre id="modalResponse" class="text-xs text-slate-700 whitespace-pre-wrap"></pre>
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
                </div>
            </div>
        </div>
    </div>

    <script>
        // Data transaksi dari server
        const transaksiData = @json($transaksi->keyBy('id')->toArray());

        // Fungsi untuk menampilkan modal detail dengan animasi
        function showDetailModal(transaksiId) {
            const transaksi = transaksiData[transaksiId];
            if (!transaksi) return;

            // Isi data ke modal
            document.getElementById('modalKodeTransaksi').textContent = `Transaksi ${transaksi.kode}`;
            document.getElementById('modalKode').textContent = transaksi.kode;
            document.getElementById('modalTotal').textContent = `Rp ${formatRupiah(transaksi.total_bayar)}`;
            document.getElementById('modalMetode').textContent = transaksi.metode_pembayaran || '-';
            document.getElementById('modalTanggalBayar').textContent = formatDate(transaksi.tanggal_pembayaran);
            document.getElementById('modalJatuhTempo').textContent = formatDate(transaksi.tanggal_jatuhtempo);
            document.getElementById('modalPeriode').textContent = transaksi.periode_pembayaran;
            document.getElementById('modalMasukKamar').textContent = formatDate(transaksi.masuk_kamar);
            document.getElementById('modalDurasi').textContent = `${transaksi.durasi} bulan`;
            document.getElementById('modalUser').textContent = transaksi.user?.name || 'N/A';
            document.getElementById('modalKamar').textContent = transaksi.kamar?.kode_kamar || 'N/A';
            document.getElementById('modalOrderId').textContent = transaksi.midtrans_order_id || '-';
            document.getElementById('modalTransactionId').textContent = transaksi.midtrans_transaction_id || '-';
            document.getElementById('modalPaymentType').textContent = transaksi.midtrans_payment_type || '-';
            document.getElementById('modalExpired').textContent = formatDate(transaksi.expired_at);
            document.getElementById('modalResponse').textContent = transaksi.midtrans_response ? JSON.stringify(JSON.parse(transaksi.midtrans_response), null, 2) : '-';
            // document.getElementById('modalEditLink').href = `/transaksi/${transaksi.id}/edit`;

            // Set status
            const statusElement = document.getElementById('modalStatus');
            if (transaksi.status_pembayaran === 'paid') {
                statusElement.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> Lunas';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200';
            } else if (transaksi.status_pembayaran === 'pending') {
                statusElement.innerHTML = '<i class="fa-solid fa-clock mr-1"></i> Pending';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200';
            } else {
                statusElement.innerHTML = '<i class="fa-solid fa-times mr-1"></i> Gagal';
                statusElement.className = 'px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200';
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

        // Fungsi format tanggal
        function formatDate(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
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
    </script>

    <style>
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
