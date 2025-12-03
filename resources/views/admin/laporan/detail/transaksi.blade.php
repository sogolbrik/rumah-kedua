@extends('layouts.admin-main')

@section('title', 'Laporan Transaksi')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Transaksi</h1>
            <p class="mt-0.5 text-sm text-slate-600">Pantau kinerja dan unduh laporan transaksi.</p>
        </div>
    </div>

    <!-- Wrap dalam x-data Alpine.js -->
    <!-- Wrap dalam x-data Alpine.js -->
    <div x-data="{
        tanggalMulai: '{{ request('tanggal_mulai', now()->subMonth()->startOfMonth()->format('Y-m-d')) }}',
        tanggalSelesai: '{{ request('tanggal_selesai', now()->format('Y-m-d')) }}',
        currentPage: {{ $transaksi->currentPage() }},
    
        formatDate(dateString) {
            if (!dateString) return '';
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options).replace(/ /g, ' ');
        },
    
        exportPdf() {
            const url = new URL('{{ route('laporan.transaksi.pdf') }}', window.location.origin);
            url.searchParams.set('tanggal_mulai', this.tanggalMulai);
            url.searchParams.set('tanggal_selesai', this.tanggalSelesai);
            // HANYA rentang tanggal, TANPA halaman
            window.open(url.toString(), '_blank');
        },
    
        exportExcel() {
            const url = new URL('{{ route('laporan.transaksi.excel') }}', window.location.origin);
            url.searchParams.set('tanggal_mulai', this.tanggalMulai);
            url.searchParams.set('tanggal_selesai', this.tanggalSelesai);
            window.open(url.toString(), '_blank');
        }
    }" class="space-y-6 mb-6">

        <!-- Filter Tanggal -->
        <form method="GET" action="{{ route('laporan.transaksi') }}" class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 bg-white p-6 rounded-xl shadow border border-slate-200 items-end">
            <!-- Tanggal Mulai -->
            <div class="flex flex-col">
                <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai', now()->subMonth()->startOfMonth()->format('Y-m-d')) }}"
                    class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5">
            </div>

            <!-- Tanggal Selesai -->
            <div class="flex flex-col">
                <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ request('tanggal_selesai', now()->format('Y-m-d')) }}"
                    class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5">
            </div>

            <!-- Tombol Filter -->
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-slate-700 mb-2 opacity-0">Filter</label>
                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm transition h-fit">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </form>

        <!-- Section Export Laporan -->
        <div class="bg-white p-6 rounded-xl shadow border border-slate-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <!-- Kiri: Teks Export & Periode -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Export Laporan</h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Periode:
                        <span class="font-medium" x-text="formatDate(tanggalMulai) + ' – ' + formatDate(tanggalSelesai)"></span>
                    </p>
                </div>

                <!-- Kanan: Tombol Export -->
                <div class="flex flex-wrap gap-3">
                    <!-- Tombol Download PDF -->
                    <button type="button" x-on:click="exportPdf()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                        <i class="fas fa-file-pdf"></i>
                        Download PDF
                    </button>

                    <!-- Tombol Download Excel -->
                    <button type="button" x-on:click="exportExcel()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">
                        <i class="fas fa-file-excel"></i>
                        Download Excel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Tabel Transaksi -->
    <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Riwayat Transaksi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Transaksi</th>
                        <th class="px-6 py-3 font-medium">Tanggal</th>
                        <th class="px-6 py-3 font-medium">Penyewa</th>
                        <th class="px-6 py-3 font-medium">Kamar</th>
                        <th class="px-6 py-3 font-medium text-right">Total Bayar</th>
                        <th class="px-6 py-3 font-medium">Pembayaran</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($transaksi as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-indigo-700">{{ $item->kode ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-500">{{ $item->created_at?->translatedFormat('d F Y H:i') ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-800">{{ $item->user->name ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-teal-700">{{ $item->kamar->kode_kamar ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-semibold text-emerald-700">Rp {{ number_format($item->total_bayar, 0, ',', '.') ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->midtrans_payment_type == 'bank_transfer')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                        <i class="fas fa-credit-card text-blue-600 text-xs"></i>
                                        Bank Transfer
                                    </span>
                                @elseif($item->midtrans_payment_type == 'qris')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                        <i class="fas fa-qrcode text-purple-600 text-xs"></i>
                                        QRIS
                                    </span>
                                @elseif($item->midtrans_payment_type == 'credit_card')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-medium">
                                        <i class="fas fa-credit-card text-yellow-600 text-xs"></i>
                                        Credit Card
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                        <i class="fas fa-money-bill-wave text-green-600 text-xs"></i>
                                        Cash
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusMap = [
                                        'pending' => [
                                            'label' => 'Menunggu Pembayaran',
                                            'color' => 'bg-amber-100 text-amber-800',
                                            'icon' => 'fa-clock',
                                        ],
                                        'paid' => [
                                            'label' => 'Lunas',
                                            'color' => 'bg-emerald-100 text-emerald-800',
                                            'icon' => 'fa-check-circle',
                                        ],
                                        'failed' => [
                                            'label' => 'Gagal',
                                            'color' => 'bg-rose-100 text-rose-800',
                                            'icon' => 'fa-times-circle',
                                        ],
                                        'cancelled' => [
                                            'label' => 'Dibatalkan',
                                            'color' => 'bg-slate-100 text-slate-800',
                                            'icon' => 'fa-ban',
                                        ],
                                        'expired' => [
                                            'label' => 'Kadaluarsa',
                                            'color' => 'bg-gray-100 text-gray-800',
                                            'icon' => 'fa-calendar-times',
                                        ],
                                        'challenge' => [
                                            'label' => 'Dalam Tantangan',
                                            'color' => 'bg-purple-100 text-purple-800',
                                            'icon' => 'fa-shield-alt',
                                        ],
                                    ];

                                    $status = strtolower($item->status_pembayaran ?? '');
                                    $badge = $statusMap[$status] ?? [
                                        'label' => 'Tidak Diketahui',
                                        'color' => 'bg-gray-100 text-gray-800',
                                        'icon' => 'fa-question-circle',
                                    ];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full {{ $badge['color'] }} text-xs font-medium">
                                    <i class="fas {{ $badge['icon'] }} text-xs"></i>
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-slate-500">
                                Tidak ada transaksi dalam periode ini.
                            </td>
                        </tr>
                    @endforelse
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
@endsection
