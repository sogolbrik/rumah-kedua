@extends('layouts.admin-main')

@section('title', 'Laporan')

@section('admin-main')
    <div class="flex items-center justify-between mb-5">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Laporan</h1>
            <p class="mt-1 text-sm text-slate-600">Semua laporan ada di sini, mudah dipantau dan dikelola.</p>
        </div>
    </div>

    <!-- Realtime Clock Card -->
    <div class="mb-6">
        <div class="mx-auto max-w-xs rounded-md bg-white p-2 text-slate-800 shadow-sm">
            <div class="flex items-center justify-center gap-2 text-xs font-semibold tracking-wide">
                <i class="fa-regular fa-clock"></i>
                <span id="realtime-clock" x-data="realtimeClock()" x-init="init()" x-text="time"></span>
                <span>WIB</span>
            </div>
        </div>
    </div>

    <!-- Section Card Laporan (jumlah) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-5">
        {{-- Card: Penjualan Bulan Ini --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Penjualan Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">Rp 45.750.000</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-chart-line text-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Naik 8% dari bulan lalu</p>
        </div>

        {{-- Card: Hunian Terisi --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Hunian Terisi</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">72%</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center text-teal-600">
                    <i class="fa-solid fa-house-user text-lg"></i>
                </div>
            </div>
            <div class="mt-4 h-2 w-full rounded-full bg-slate-100 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-teal-500" style="width: 72%"></div>
            </div>
        </div>

        {{-- Card: Total Transaksi Minggu Ini --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Transaksi Minggu Ini</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">142</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fa-solid fa-receipt text-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">12 transaksi hari ini</p>
        </div>

        {{-- Card: Total Penghuni --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Total Penghuni</p>
                    <p class="mt-1 text-2xl font-bold text-slate-900">186</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Aktif bulan ini</p>
        </div>
    </div>

    <!-- Section Card Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        {{-- Card: Laporan Transaksi --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-purple-600">
                        <i class="fa-solid fa-receipt text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Laporan Transaksi</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">Semua transaksi</p>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan transaksi sewa kamar secara lengkap.</p>
            <button class="mt-4 w-1/2 rounded-lg bg-purple-600 px-4 py-2 text-sm font-medium text-white hover:bg-purple-700 flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-lines"></i>
                Buat Laporan
            </button>
        </div>

        {{-- Card: Laporan Kamar --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center text-teal-600">
                        <i class="fa-solid fa-house-user text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Laporan Kamar</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">Status hunian</p>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan ketersediaan serta status kamar.</p>
            <button class="mt-4 w-1/2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700 flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-lines"></i>
                Buat Laporan
            </button>
        </div>

        {{-- Card: Laporan Penghuni --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm hover:shadow-md transition-shadow duration-300 flex flex-col">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                    <div class="h-11 w-11 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-users text-lg"></i>
                    </div>
                    <div>
                        <p class="text-sm text-slate-500">Laporan Penghuni</p>
                        <p class="mt-1 text-lg font-bold text-slate-900">Data penghuni</p>
                    </div>
                </div>
            </div>
            <p class="mt-4 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan data seluruh penghuni kost.</p>
            <button class="mt-4 w-1/2 rounded-lg bg-orange-600 px-4 py-2 text-sm font-medium text-white hover:bg-orange-700 flex items-center justify-center gap-2">
                <i class="fa-solid fa-file-lines"></i>
                Buat Laporan
            </button>
        </div>
    </div>

    <!-- Section Table Data -->
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-5">
        {{-- Transaksi Terbaru --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Transaksi Terbaru</h2>
                <a href="{{ route('transaksi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200/50">
                        <tr>
                            <th class="py-2.5 px-1">Tanggal</th>
                            <th class="py-2.5">Penyewa</th>
                            <th class="py-2.5">Kamar</th>
                            <th class="py-2.5">Total</th>
                            <th class="py-2.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transaksi->take(20) as $item)
                            <tr>
                                <td class="py-3 px-1">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-3">{{ $item->user->name }}</td>
                                <td class="py-3">{{ $item->kamar->kode_kamar }}</td>
                                <td class="py-3">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 text-right">
                                    @if ($item->status_pembayaran === 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Lunas</span>
                                    @elseif ($item->status_pembayaran === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-yellow-50 text-yellow-700 font-medium">Menunggu</span>
                                    @elseif ($item->status_pembayaran === 'failed')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-red-50 text-red-700 font-medium">Gagal</span>
                                    @elseif ($item->status_pembayaran === 'cancelled')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-gray-50 text-gray-700 font-medium">Dibatalkan</span>
                                    @elseif ($item->status_pembayaran === 'expired')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-orange-50 text-orange-700 font-medium">Kadaluarsa</span>
                                    @elseif ($item->status_pembayaran === 'challenge')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-purple-50 text-purple-700 font-medium">Tantangan</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-slate-50 text-slate-700 font-medium">Tidak Diketahui</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <p class="text-center text-slate-500">Belum ada transaksi</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Data Penghuni --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Data Penghuni</h2>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200/50">
                        <tr>
                            <th class="py-2.5 px-1">Nama</th>
                            <th class="py-2.5">Kamar</th>
                            <th class="py-2.5">Mulai</th>
                            <th class="py-2.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        {{-- Dummy data penghuni --}}
                        <tr>
                            <td class="py-3 px-1">Budi Santoso</td>
                            <td class="py-3">A-05</td>
                            <td class="py-3">01 Jun 2024</td>
                            <td class="py-3 text-right">
                                <span class="px-2.5 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Aktif</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 px-1">Siti Nurhaliza</td>
                            <td class="py-3">B-12</td>
                            <td class="py-3">15 Mei 2024</td>
                            <td class="py-3 text-right">
                                <span class="px-2.5 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Aktif</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3 px-1">Ahmad Fauzi</td>
                            <td class="py-3">C-08</td>
                            <td class="py-3">20 Apr 2024</td>
                            <td class="py-3 text-right">
                                <span class="px-2.5 py-1 rounded-full text-xs bg-yellow-50 text-yellow-700 font-medium">Perpanjang</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alpine.js for Realtime Clock -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('realtimeClock', () => ({
                time: '',

                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },

                updateTime() {
                    const now = new Date();
                    const options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: false
                    };
                    this.time = now.toLocaleString('id-ID', options);
                }
            }));
        });
    </script>

@endsection
