@extends('layouts.admin-main')

@section('title', 'Transaksi')

@section('admin-main')
    {{-- Halaman Transaksi (UI biru, tanpa global style) --}}
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-slate-900">Transaksi</h2>
        <div class="flex items-center gap-2">
            <input type="month" class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            <button class="inline-flex items-center gap-2 rounded-lg bg-blue-600 text-white px-3 py-2 text-sm hover:bg-blue-700">
                <i class="fa-solid fa-arrow-rotate-right"></i> Refresh
            </button>
        </div>
    </div>

    <div class="mt-4 rounded-xl border border-slate-200 bg-white overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-4 py-3">Tanggal</th>
                        <th class="text-left px-4 py-3">Penyewa</th>
                        <th class="text-left px-4 py-3">Kamar</th>
                        <th class="text-left px-4 py-3">Metode</th>
                        <th class="text-right px-4 py-3">Jumlah</th>
                        <th class="text-right px-4 py-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr>
                        <td class="px-4 py-3">02 Okt 2025</td>
                        <td class="px-4 py-3">Ayu Pratiwi</td>
                        <td class="px-4 py-3">A-203</td>
                        <td class="px-4 py-3">Transfer</td>
                        <td class="px-4 py-3 text-right">Rp 1.200.000</td>
                        <td class="px-4 py-3 text-right">
                            <span class="px-2 py-1 rounded text-xs bg-blue-50 text-blue-700">Berhasil</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">02 Okt 2025</td>
                        <td class="px-4 py-3">Rizky Ananda</td>
                        <td class="px-4 py-3">B-112</td>
                        <td class="px-4 py-3">E-wallet</td>
                        <td class="px-4 py-3 text-right">Rp 950.000</td>
                        <td class="px-4 py-3 text-right">
                            <span class="px-2 py-1 rounded text-xs bg-slate-100 text-slate-700">Pending</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
