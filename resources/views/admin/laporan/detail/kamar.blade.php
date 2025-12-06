@extends('layouts.admin-main')

@section('title', 'Laporan Kamar')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Kamar</h1>
            <p class="mt-0.5 text-sm text-slate-600">Pantau kinerja dan unduh laporan kamar.</p>
        </div>
        <div>
            <a href="{{ route('laporan.index') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Wrap dalam x-data Alpine.js -->
    <div x-data="{
        tipe: '{{ request('tipe', '') }}',
        status: '{{ request('status', '') }}',
        currentPage: {{ $kamar->currentPage() }},
    
        exportPdf() {
            const url = new URL('{{ route('laporan.kamar.export.pdf') }}', window.location.origin);
            if (this.tipe) url.searchParams.set('tipe', this.tipe);
            if (this.status) url.searchParams.set('status', this.status);
            window.open(url.toString(), '_blank');
        },
    
        exportExcel() {
            const url = new URL('{{ route('laporan.kamar.export.excel') }}', window.location.origin);
            if (this.tipe) url.searchParams.set('tipe', this.tipe);
            if (this.status) url.searchParams.set('status', this.status);
            window.open(url.toString(), '_blank');
        }
    }" class="space-y-6 mb-6">

        <!-- Filter Tipe & Status -->
        <form method="GET" action="{{ route('laporan.kamar') }}" class="grid grid-cols-1 sm:grid-cols-[1fr_1fr_auto] gap-4 bg-white p-6 rounded-xl shadow border border-slate-200 items-end">
            <!-- Tipe Kamar -->
            <div class="flex flex-col">
                <label for="tipe" class="block text-sm font-medium text-slate-700 mb-2">Tipe Kamar</label>
                <select id="tipe" name="tipe" x-model="tipe" class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5">
                    <option value="">Semua Tipe</option>
                    <option value="Standard">Standard</option>
                    <option value="Medium">Medium</option>
                    <option value="Exclusive">Exclusive</option>
                </select>
            </div>

            <!-- Status Kamar -->
            <div class="flex flex-col">
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status Kamar</label>
                <select id="status" name="status" x-model="status" class="w-full rounded-lg border border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm px-4 py-2.5">
                    <option value="">Semua Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Terisi">Terisi</option>
                </select>
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
                <!-- Kiri: Teks Export & Filter Aktif -->
                <div>
                    <h3 class="text-lg font-semibold text-slate-800">Export Laporan</h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Filter:
                        <span class="font-medium">
                            Tipe: <span x-text="tipe || 'Semua'"></span> |
                            Status: <span x-text="status || 'Semua'"></span>
                        </span>
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

    <!-- Section Tabel Kamar -->
    <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Riwayat Kamar</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Kode Kamar</th>
                        <th class="px-6 py-3 font-medium">Tipe</th>
                        <th class="px-6 py-3 font-medium">Lebar</th>
                        <th class="px-6 py-3 font-medium">Harga</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($kamar as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="font-mono font-bold text-indigo-700">{{ $item->kode_kamar ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-800">{{ $item->tipe ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $item->lebar ? $item->lebar . ' m²' : '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-emerald-700">Rp {{ number_format($item->harga, 0, ',', '.') ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($item->status == 'Tersedia')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-medium">
                                        <i class="fas fa-door-open text-emerald-600 text-xs"></i>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-medium">
                                        <i class="fas fa-door-closed text-red-600 text-xs"></i>
                                        Terisi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-slate-500">
                                Tidak ada kamar yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
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
@endsection
