@extends('layouts.admin-main')

@section('title', 'Dashboard')

@section('admin-main')
    {{-- Admin dashboard dengan warna biru langsung di section ini (tanpa global style) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        {{-- Card: Hunian Terisi --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Hunian Terisi</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">86%</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-building-user"></i>
                </div>
            </div>
            <div class="mt-4 h-2 w-full rounded-full bg-slate-100">
                <div class="h-2 rounded-full bg-blue-600" style="width: 86%"></div>
            </div>
        </div>

        {{-- Card: Kamar Tersedia --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Kamar Tersedia</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">14</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-door-open"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Dari total 100 kamar</p>
        </div>

        {{-- Card: Pendapatan Bulan Ini --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Pendapatan Bulan Ini</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">Rp 42.500.000</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-blue-700 bg-blue-50 inline-flex items-center gap-1 px-2 py-0.5 rounded">
                <i class="fa-solid fa-arrow-up"></i> +8.2% dari bulan lalu
            </p>
        </div>

        {{-- Card: Transaksi Pending --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Transaksi Pending</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">7</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Perlu verifikasi manual</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-4">
        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-semibold text-slate-900">Transaksi Terbaru</h2>
                <a href="{{ route('transaksi-admin') }}" class="text-sm text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Penyewa</th>
                            <th class="py-2">Kamar</th>
                            <th class="py-2">Jumlah</th>
                            <th class="py-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr>
                            <td class="py-2">02 Okt 2025</td>
                            <td class="py-2">Ayu Pratiwi</td>
                            <td class="py-2">A-203</td>
                            <td class="py-2">Rp 1.200.000</td>
                            <td class="py-2 text-right">
                                <span class="px-2 py-1 rounded text-xs bg-blue-50 text-blue-700">Berhasil</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2">02 Okt 2025</td>
                            <td class="py-2">Rizky Ananda</td>
                            <td class="py-2">B-112</td>
                            <td class="py-2">Rp 950.000</td>
                            <td class="py-2 text-right">
                                <span class="px-2 py-1 rounded text-xs bg-slate-100 text-slate-700">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2">01 Okt 2025</td>
                            <td class="py-2">Sari Wulandari</td>
                            <td class="py-2">C-305</td>
                            <td class="py-2">Rp 1.500.000</td>
                            <td class="py-2 text-right">
                                <span class="px-2 py-1 rounded text-xs bg-blue-50 text-blue-700">Berhasil</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pengumuman --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-semibold text-slate-900">Pengumuman</h2>
                <a href="{{ route('pengumuman-admin') }}" class="text-sm text-blue-700 hover:underline">Kelola</a>
            </div>
            <ul class="space-y-3">
                <li class="p-3 rounded-lg border border-slate-100 bg-blue-50/40">
                    <p class="text-sm font-medium text-blue-800">Perawatan Air (5–6 Okt)</p>
                    <p class="text-xs text-blue-700">Aliran air akan bergilir pukul 10.00–14.00</p>
                </li>
                <li class="p-3 rounded-lg border border-slate-100 bg-white">
                    <p class="text-sm font-medium text-slate-900">Pembayaran Online</p>
                    <p class="text-xs text-slate-600">Dukungan e-wallet telah tersedia.</p>
                </li>
                <li class="p-3 rounded-lg border border-slate-100 bg-white">
                    <p class="text-sm font-medium text-slate-900">Aturan Kebersihan</p>
                    <p class="text-xs text-slate-600">Sampah dibuang sebelum jam 20.00.</p>
                </li>
            </ul>
        </div>
    </div>
@endsection
