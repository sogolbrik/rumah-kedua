@extends('layouts.admin-main')

@section('title', 'Laporan')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan</h1>
            <p class="mt-0.5 text-sm text-slate-600">Pantau kinerja dan unduh laporan operasional.</p>
        </div>

        <!-- Realtime Clock - Integrasi Halus -->
        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100/70 px-3.5 py-2 text-xs font-medium text-slate-700 backdrop-blur-sm border border-slate-200/40">
            <i class="fa-regular fa-clock text-slate-500"></i>
            <span id="realtime-clock" x-data="realtimeClock()" x-init="init()" x-text="time"></span>
            <span class="text-slate-500">WIB</span>
        </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
        {{-- Penjualan Bulan Ini --}}
        <div class="rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-pink-500 to-rose-300 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium opacity-90">Penjualan Bulan Ini</p>
                    <p class="mt-1 text-xl font-bold">Rp {{ number_format($transaksi->where('status_pembayaran', 'paid')->sum('total_bayar'), 0, ',', '.') ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-chart-line text-base text-white"></i>
                </div>
            </div>
            <p class="mt-2 text-xs opacity-90">
                @php
                    $bulanIni = \Carbon\Carbon::now()->startOfMonth();
                    $bulanLalu = \Carbon\Carbon::now()->subMonth()->startOfMonth();

                    $penjualanBulanIni = $transaksi->where('status_pembayaran', 'paid')->where('created_at', '>=', $bulanIni)->sum('total_bayar');
                    $penjualanBulanLalu = $transaksi->where('status_pembayaran', 'paid')->where('created_at', '>=', $bulanLalu)->where('created_at', '<', $bulanIni)->sum('total_bayar');

                    if ($penjualanBulanLalu > 0) {
                        $persentasePerubahan = round((($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100, 1);
                    } else {
                        $persentasePerubahan = $penjualanBulanIni > 0 ? 100 : 0;
                    }

                    $trend = $persentasePerubahan >= 0 ? 'Naik' : 'Turun';
                    $warna = $persentasePerubahan >= 0 ? 'green' : 'red';
                @endphp
                {{ $trend }} <span class="font-medium">{{ abs($persentasePerubahan) ?? 0 }}%</span> dari bulan lalu
            </p>
        </div>

        {{-- Hunian Terisi --}}
        <div class="rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-cyan-500 to-teal-300 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium opacity-90">Hunian Terisi</p>
                    <p class="mt-1 text-xl font-bold">
                        {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->count()) * 100, 0) : 0 }}%
                    </p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-house-user text-base text-white"></i>
                </div>
            </div>
            <div class="mt-3 h-1.5 w-full rounded-full bg-white/30 overflow-hidden">
                <div class="h-full rounded-full bg-white"
                    style="width: {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->count()) * 100, 0) : 0 }}%">
                </div>
            </div>
        </div>

        {{-- Total Transaksi Minggu Ini --}}
        <div class="rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-indigo-500 to-purple-300 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium opacity-90">Transaksi Minggu Ini</p>
                    <p class="mt-1 text-xl font-bold">{{ $transaksi->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-receipt text-base text-white"></i>
                </div>
            </div>
            <p class="mt-2 text-xs opacity-90">{{ $transaksi->where('created_at', '>=', \Carbon\Carbon::today())->count() ?? 0 }} transaksi hari ini</p>
        </div>

        {{-- Total Penghuni --}}
        <div class="rounded-2xl p-5 shadow-sm hover:shadow-md transition-all duration-300 bg-gradient-to-br from-amber-500 to-orange-300 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-medium opacity-90">Total Penghuni</p>
                    <p class="mt-1 text-xl font-bold">{{ $penghuni->count() ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-users text-base text-white"></i>
                </div>
            </div>
            <p class="mt-2 text-xs opacity-90">Aktif bulan ini</p>
        </div>
    </div>

    <!-- Kartu Aksi Laporan -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-6">
        {{-- Laporan Transaksi --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
            <div class="flex items-start gap-4">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fa-solid fa-receipt text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Laporan Transaksi</p>
                    <p class="mt-0.5 text-base font-bold text-slate-900">Semua transaksi</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan transaksi sewa kamar secara lengkap.</p>
            <a href="{{ Route('laporan.transaksi') }}"
                class="mt-4 w-full max-w-[140px] rounded-lg bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-2 text-sm font-medium text-white hover:from-purple-700 hover:to-indigo-700 shadow-sm transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-file-export text-xs"></i>
                Buat Laporan
            </a>
        </div>

        {{-- Laporan Kamar --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
            <div class="flex items-start gap-4">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center text-teal-600">
                    <i class="fa-solid fa-door-open text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Laporan Kamar</p>
                    <p class="mt-0.5 text-base font-bold text-slate-900">Status hunian</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan ketersediaan serta status kamar.</p>
            <a href="{{ Route('laporan.kamar') }}"
                class="mt-4 w-full max-w-[140px] rounded-lg bg-gradient-to-r from-teal-600 to-cyan-600 px-4 py-2 text-sm font-medium text-white hover:from-teal-700 hover:to-cyan-700 shadow-sm transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-file-export text-xs"></i>
                Buat Laporan
            </a>
        </div>

        {{-- Laporan Penghuni --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col">
            <div class="flex items-start gap-4">
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-users text-base"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-medium">Laporan Penghuni</p>
                    <p class="mt-0.5 text-base font-bold text-slate-900">Data penghuni</p>
                </div>
            </div>
            <p class="mt-3 text-sm text-slate-600 flex-grow">Lihat dan unduh laporan data seluruh penghuni kos.</p>
            <a href="{{ Route('laporan.penghuni') }}"
                class="mt-4 w-full max-w-[140px] rounded-lg bg-gradient-to-r from-orange-600 to-amber-600 px-4 py-2 text-sm font-medium text-white hover:from-orange-700 hover:to-amber-700 shadow-sm transition-all flex items-center justify-center gap-1.5">
                <i class="fa-solid fa-file-export text-xs"></i>
                Buat Laporan
            </a>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-5">
        {{-- Transaksi Terbaru --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Transaksi Terbaru</h2>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <tbody>
                        @forelse ($transaksi->take(10) as $item)
                            <tr class="bg-slate-50 rounded-lg">
                                <td class="py-3 px-2 rounded-l-lg">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-base text-slate-900">{{ $item->kode ?? '—' }}</span>
                                        <span class="text-xs text-slate-400">{{ $item->created_at?->translatedFormat('d F Y H:i') ?? '—' }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-right rounded-r-lg">
                                    <div class="flex flex-col items-end">
                                        <span class="font-semibold text-base text-green-600">Rp {{ number_format($item->total_bayar, 0, ',', '.') ?? '—' }}</span>
                                        <span class="text-xs text-slate-400">{{ $item->midtrans_payment_type ?? 'Cash' }}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="h-2"></tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">Tidak ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Data Penghuni --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Data Penghuni</h2>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="py-2.5 px-2">Nama</th>
                            <th class="py-2.5 px-2">Kamar</th>
                            <th class="py-2.5 px-2">Mulai</th>
                            <th class="py-2.5 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penghuni->take(10) as $item)
                            <tr class="bg-slate-50 rounded-lg">
                                <td class="py-3 px-2 rounded-l-lg">
                                    <span class="font-semibold text-slate-800 tracking-wide">{{ $item->name ?? '—' }}</span>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="font-medium text-slate-600">{{ $item->kamar?->kode_kamar ?? '—' }}</span>
                                </td>
                                <td class="py-3 px-2">
                                    <span class="text-sm text-slate-500 italic">{{ $item->created_at?->translatedFormat('d F Y') ?? '—' }}</span>
                                </td>
                                <td class="py-3 px-2 text-right rounded-r-lg">
                                    <span class="px-2.5 py-1 rounded-full text-xs bg-green-100 text-green-700 font-semibold tracking-wide shadow-sm">Aktif</span>
                                </td>
                            </tr>
                            <tr class="h-2"></tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">Tidak ada penghuni</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel Penghuni Telat Bayar -->
    <div id="penghuniMenunggak" class="grid grid-cols-1 gap-5">
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                    <h2 class="text-base font-bold text-amber-500">Penghuni Telat Bayar</h2>
                </div>
                <a href="{{ route('user.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat User</a>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="py-2.5 px-2">Penyewa</th>
                            <th class="py-2.5 px-2">Kamar</th>
                            <th class="py-2.5 px-2">Tanggal Bayar</th>
                            <th class="py-2.5 px-2">Jatuh Tempo</th>
                            <th class="py-2.5 px-2">Durasi</th>
                            <th class="py-2.5 px-2">Hari Tunggakan</th>
                            <th class="py-2.5 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penghuniMenunggak as $item)
                            @php
                                $transaksi = $item->transaksi->first();
                                if (!$transaksi) {
                                    continue;
                                }

                                $hariTunggakan = null;

                                if ($transaksi->tanggal_jatuhtempo) {
                                    $jatuhTempo = \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo);
                                    if ($jatuhTempo->lt(\Carbon\Carbon::today())) {
                                        $hariTunggakan = $jatuhTempo->diffInDays(\Carbon\Carbon::today());
                                    } else {
                                        continue;
                                    }
                                } else {
                                    continue;
                                }
                            @endphp

                            <tr class="bg-amber-50 rounded-lg">
                                <td class="py-3 px-2 rounded-l-lg">
                                    <span class="font-semibold text-slate-800 tracking-wide">{{ $item->name }}</span>
                                </td>

                                <td class="py-3 px-2">
                                    <span class="inline-flex items-center gap-1.5 text-slate-700">
                                        <i class="fa-solid fa-door-open text-xs text-slate-400"></i>
                                        {{ $item->kamar?->kode_kamar ?? '—' }}
                                    </span>
                                </td>

                                <td class="py-3 px-2">
                                    <span class="text-sm text-slate-600 italic">
                                        {{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}
                                    </span>
                                </td>

                                <td class="py-3 px-2">
                                    <span class="text-sm text-slate-600 italic">
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') }}
                                    </span>
                                </td>

                                <td class="py-3 px-2">
                                    <span class="inline-flex items-center gap-1 text-slate-700">
                                        <i class="fa-solid fa-calendar-days text-xs text-slate-400"></i>
                                        {{ $transaksi->durasi ?? '—' }} Bulan
                                    </span>
                                </td>

                                <td class="py-3 px-2">
                                    <span class="inline-flex items-center gap-1 text-slate-700">
                                        <i class="fa-solid fa-clock text-xs text-slate-400"></i>
                                        {{ $hariTunggakan }} Hari
                                    </span>
                                </td>

                                <td class="py-3 px-2 text-right rounded-r-lg">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs bg-white text-amber-600 font-semibold shadow-sm border border-amber-200">
                                        <i class="fa-solid fa-triangle-exclamation text-amber-500"></i>
                                        Menunggak
                                    </span>
                                </td>
                            </tr>

                            <tr class="h-2"></tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">
                                    Tidak ada penghuni menunggak
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Alpine.js: Realtime Clock -->
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
