@extends('layouts.admin-main')

@section('title', 'Laporan Penghuni')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Penghuni</h1>
            <p class="mt-0.5 text-sm text-slate-600">Pantau kinerja dan unduh laporan penghuni.</p>
        </div>
        <div>
            <a href="{{ route('laporan.index') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Section Export Laporan -->
    <div class="bg-white p-6 rounded-xl shadow border border-slate-200 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Kiri: Teks Export -->
            <div>
                <h3 class="text-lg font-semibold text-slate-800">Export Laporan</h3>
                <p class="text-sm text-slate-600 mt-1">Semua data tersedia untuk diunduh.</p>
            </div>

            <!-- Kanan: Tombol Export -->
            <div class="flex flex-wrap gap-3">
                <!-- Download PDF -->
                <a href="{{ route('laporan.penghuni.pdf') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition">
                    <i class="fas fa-file-pdf"></i>
                    Download PDF
                </a>

                <!-- Download Excel -->
                <a href="{{ route('laporan.penghuni.excel') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-medium rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition">
                    <i class="fas fa-file-excel"></i>
                    Download Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Section Tabel Kamar -->
    <div class="bg-white rounded-xl shadow border border-slate-200 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Daftar Penghuni</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead>
                    <tr class="text-left text-xs text-slate-500 uppercase tracking-wider">
                        <th class="px-6 py-3 font-medium">Nama Penghuni</th>
                        <th class="px-6 py-3 font-medium">Kode Kamar</th>
                        <th class="px-6 py-3 font-medium">No. Telepon</th>
                        <th class="px-6 py-3 font-medium">Email</th>
                        <th class="px-6 py-3 font-medium">Tanggal Masuk</th>
                        <th class="px-6 py-3 font-medium">Hari Tunggakan</th>
                        <th class="px-6 py-3 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($penghuni as $item)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-slate-900 tracking-tight">{{ $item->name ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-slate-700">{{ $item->kamar->kode_kamar ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ $item->telepon ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-700">{{ $item->email ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y') ?? '—' }}</span>
                            </td>

                            @php
                                $lastTransaksi = $item->transaksi->first();
                            @endphp
                            {{-- Kolom Hari Tunggakan --}}
                            <td class="px-6 py-4">
                                @if ($lastTransaksi && $lastTransaksi->tanggal_jatuhtempo < \Carbon\Carbon::today())
                                    <span class="text-sm font-semibold text-rose-600">
                                         {{ \Carbon\Carbon::parse($lastTransaksi->tanggal_jatuhtempo)->diffInDays(\Carbon\Carbon::today()) }} hari
                                    </span>
                                @else
                                    <span class="text-sm text-slate-500">—</span>
                                @endif
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-4">
                                @if ($lastTransaksi && $lastTransaksi->tanggal_jatuhtempo < \Carbon\Carbon::today())
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-medium">
                                        <i class="fas fa-exclamation-circle text-amber-600 text-xs"></i>
                                        Menunggak
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-medium">
                                        <i class="fas fa-check-circle text-emerald-600 text-xs"></i>
                                        Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-slate-500">
                                Tidak ada data penghuni.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($penghuni->hasPages())
            <div class="border-t border-slate-200 px-6 py-4 bg-slate-50">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-slate-700">
                        Menampilkan
                        <span class="font-medium">{{ $penghuni->firstItem() }}</span>
                        sampai
                        <span class="font-medium">{{ $penghuni->lastItem() }}</span>
                        dari
                        <span class="font-medium">{{ $penghuni->total() }}</span>
                        hasil
                    </p>
                    <div class="flex gap-1">
                        @if ($penghuni->onFirstPage())
                            <span class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-slate-100 text-slate-400 cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </span>
                        @else
                            <a href="{{ $penghuni->previousPageUrl() }}"
                                class="inline-flex items-center px-3 py-1.5 rounded-md text-sm bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 transition-colors">
                                <i class="fa-solid fa-chevron-left mr-1 text-xs"></i>
                                Sebelumnya
                            </a>
                        @endif

                        @if ($penghuni->hasMorePages())
                            <a href="{{ $penghuni->nextPageUrl() }}"
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
