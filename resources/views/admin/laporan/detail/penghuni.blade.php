@extends('layouts.admin-main')

@section('title', 'Laporan Penghuni')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Transaksi</h1>
            <p class="mt-0.5 text-sm text-slate-600">Pantau kinerja dan unduh laporan transaksi.</p>
        </div>
    </div>

    <!-- Wrap dalam x-data Alpine.js -->
    <div x-data="{
        tanggalMulai: '{{ now()->subMonth()->startOfMonth()->format('Y-m-d') }}',
        tanggalSelesai: '{{ now()->format('Y-m-d') }}',
    
        formatDate(dateString) {
            if (!dateString) return '';
            const options = { day: '2-digit', month: 'short', year: 'numeric' };
            return new Date(dateString).toLocaleDateString('id-ID', options).replace(/ /g, ' ');
        }
    }" class="space-y-6 mb-6">

        <!-- Filter Tanggal -->
        <div class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 bg-white p-6 rounded-xl shadow border border-slate-200 items-end">
            <!-- Tanggal Mulai -->
            <div class="flex flex-col">
                <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" x-model="tanggalMulai"
                    class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 outline-none ring-1 ring-slate-200 focus:ring-2">
            </div>

            <!-- Tanggal Selesai -->
            <div class="flex flex-col">
                <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" x-model="tanggalSelesai"
                    class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5 outline-none ring-1 ring-slate-200 focus:ring-2">
            </div>

            <!-- Tombol Filter -->
            <div class="flex flex-col">
                <label class="block text-sm font-medium text-slate-700 mb-2 opacity-0 pointer-events-none">Filter</label>
                <button type="button"
                    class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm transition h-fit">
                    <i class="fas fa-filter"></i>
                    Filter
                </button>
            </div>
        </div>

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
                    <!-- Download PDF -->
                    <button type="button"
                        class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                        <i class="fas fa-file-pdf"></i>
                        Download PDF
                    </button>

                    <!-- Download Excel -->
                    <button type="button"
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
                    <!-- Row 1 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-indigo-700">TRX-20251201-001</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500">01 Des 2025</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-800">Budi Santoso</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-teal-700">Kamar 302</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold text-emerald-700">Rp 1.250.000</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-medium">
                                <i class="fas fa-credit-card text-blue-600 text-xs"></i>
                                Bank
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-medium">
                                <i class="fas fa-check-circle text-emerald-600 text-xs"></i>
                                Berhasil
                            </span>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-indigo-700">TRX-20251128-045</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500">28 Nov 2025</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-800">Siti Rahayu</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-teal-700">Kamar 205</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold text-emerald-700">Rp 950.000</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                <i class="fas fa-qrcode text-purple-600 text-xs"></i>
                                QRIS
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-medium">
                                <i class="fas fa-clock text-amber-600 text-xs"></i>
                                Pending
                            </span>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-mono font-bold text-indigo-700">TRX-20251120-112</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500">20 Nov 2025</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-800">Agus Firmansyah</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-teal-700">Kamar 101</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="font-semibold text-emerald-700">Rp 1.100.000</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-medium">
                                <i class="fas fa-money-bill-wave text-green-600 text-xs"></i>
                                Cash
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-medium">
                                <i class="fas fa-times-circle text-rose-600 text-xs"></i>
                                Ditolak
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Jika diperlukan, tambahkan tombol "Lihat Semua" di bawah -->
        <div class="px-6 py-4 border-t border-slate-100 text-center">
            <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium inline-flex items-center gap-1">
                Lihat Semua Transaksi
                <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </div>
    </div>
@endsection
