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
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Penjualan Bulan Ini</p>
                    <p class="mt-1 text-xl font-bold text-slate-900">Rp {{ number_format($transaksi->where('status_pembayaran', 'paid')->sum('total_bayar'), 0, ',', '.') ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-pink-100 to-rose-100 flex items-center justify-center text-rose-600">
                    <i class="fa-solid fa-chart-line text-base"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-500">
                @php
                    // Hitung total penjualan bulan ini
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
                {{ $trend }} <span class="text-{{ $warna }}-600 font-medium">{{ abs($persentasePerubahan) ?? 0 }}%</span> dari bulan lalu
            </p>
        </div>

        {{-- Hunian Terisi --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Hunian Terisi</p>
                    @php
                        $totalKamar = $kamar->count();
                        $kamarTerisi = $kamar->where('status', 'Terisi')->count();
                        $persentaseHunian = $totalKamar > 0 ? round(($kamarTerisi / $totalKamar) * 100) : 0;
                    @endphp
                    <p class="mt-1 text-xl font-bold text-slate-900">{{ $persentaseHunia ?? 0 }}%</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-cyan-100 to-teal-100 flex items-center justify-center text-teal-600">
                    <i class="fa-solid fa-house-user text-base"></i>
                </div>
            </div>
            <div class="mt-3 h-1.5 w-full rounded-full bg-slate-100 overflow-hidden">
                <div class="h-full rounded-full bg-gradient-to-r from-cyan-400 to-teal-500" style="width: {{ $persentaseHunian ?? 0 }}%"></div>
            </div>
        </div>

        {{-- Total Transaksi Minggu Ini --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Transaksi Minggu Ini</p>
                    <p class="mt-1 text-xl font-bold text-slate-900">{{ $transaksi->where('created_at', '>=', \Carbon\Carbon::now()->subDays(7))->count() ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center text-purple-600">
                    <i class="fa-solid fa-receipt text-base"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-500">{{ $transaksi->where('created_at', '>=', \Carbon\Carbon::today())->count() ?? 0 }} transaksi hari ini</p>
        </div>

        {{-- Total Penghuni --}}
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm hover:shadow-md transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-slate-500 font-medium">Total Penghuni</p>
                    <p class="mt-1 text-xl font-bold text-slate-900">{{ $penghuni->count() ?? 0 }}</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-amber-100 to-orange-100 flex items-center justify-center text-orange-600">
                    <i class="fa-solid fa-users text-base"></i>
                </div>
            </div>
            <p class="mt-2 text-xs text-slate-500">Aktif bulan ini</p>
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
            <a href="#"
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
            <a href="#"
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
            <a href="#"
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
                <a href="{{ route('transaksi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200/50">
                        <tr>
                            <th class="py-2.5 px-2">Tanggal</th>
                            <th class="py-2.5 px-2">Penyewa</th>
                            <th class="py-2.5 px-2">Kamar</th>
                            <th class="py-2.5 px-2">Total</th>
                            <th class="py-2.5 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transaksi->take(5) as $item)
                            <tr>
                                <td class="py-3 px-2">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-2">{{ $item->user?->name ?? '—' }}</td>
                                <td class="py-3 px-2">{{ $item->kamar?->kode_kamar ?? '—' }}</td>
                                <td class="py-3 px-2">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-2 text-right">
                                    @php
                                        $statusMap = [
                                            'paid' => ['label' => 'Lunas', 'color' => 'green'],
                                            'pending' => ['label' => 'Menunggu', 'color' => 'yellow'],
                                            'failed' => ['label' => 'Gagal', 'color' => 'red'],
                                            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'gray'],
                                            'expired' => ['label' => 'Kadaluarsa', 'color' => 'orange'],
                                            'challenge' => ['label' => 'Tantangan', 'color' => 'purple'],
                                        ];
                                        $status = $statusMap[$item->status_pembayaran] ?? ['label' => 'Tidak Diketahui', 'color' => 'slate'];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $status['color'] }}-50 text-{{ $status['color'] }}-700 font-medium">{{ $status['label'] }}</span>
                                </td>
                            </tr>
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
                <a href="{{ route('user.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200/50">
                        <tr>
                            <th class="py-2.5 px-2">Nama</th>
                            <th class="py-2.5 px-2">Kamar</th>
                            <th class="py-2.5 px-2">Mulai</th>
                            <th class="py-2.5 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <!-- Gunakan data asli jika tersedia, fallback ke dummy -->
                        @if (isset($penghuni) && $penghuni->isNotEmpty())
                            @foreach ($penghuni->take(20) as $item)
                                <tr>
                                    <td class="py-3 px-2">{{ $item->name }}</td>
                                    <td class="py-3 px-2">{{ $item->kamar?->kode_kamar ?? '—' }}</td>
                                    <td class="py-3 px-2">{{ $item->created_at?->translatedFormat('d F Y') ?? '—' }}</td>
                                    <td class="py-3 px-2 text-right">
                                        <span class="px-2 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Aktif</span>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Dummy hanya untuk preview visual -->
                            <tr>
                                <td class="py-3 px-2">Budi Santoso</td>
                                <td class="py-3 px-2">A-05</td>
                                <td class="py-3 px-2">01 Jun 2024</td>
                                <td class="py-3 px-2 text-right"><span class="px-2 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Aktif</span></td>
                            </tr>
                            <tr>
                                <td class="py-3 px-2">Siti Nurhaliza</td>
                                <td class="py-3 px-2">B-12</td>
                                <td class="py-3 px-2">15 Mei 2024</td>
                                <td class="py-3 px-2 text-right"><span class="px-2 py-1 rounded-full text-xs bg-green-50 text-green-700 font-medium">Aktif</span></td>
                            </tr>
                            <tr>
                                <td class="py-3 px-2">Ahmad Fauzi</td>
                                <td class="py-3 px-2">C-08</td>
                                <td class="py-3 px-2">20 Apr 2024</td>
                                <td class="py-3 px-2 text-right"><span class="px-2 py-1 rounded-full text-xs bg-yellow-50 text-yellow-700 font-medium">Perpanjang</span></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tabel Penghuni Telat Bayar -->
    <div class="grid grid-cols-1 gap-5">
        <div class="rounded-2xl border border-slate-200/50 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Penghuni Telat Bayar</h2>
                <a href="{{ route('user.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200/50">
                        <tr>
                            <th class="py-2.5 px-2">Penyewa</th>
                            <th class="py-2.5 px-2">Tanggal Bayar</th>
                            <th class="py-2.5 px-2">Durasi</th>
                            <th class="py-2.5 px-2">Kamar</th>
                            <th class="py-2.5 px-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transaksi as $item)
                            <tr>
                                <td class="py-3 px-2">{{ $item->user?->name ?? '—' }}</td>
                                <td class="py-3 px-2">{{ $item->tanggal_pembayaran->translatedFormat('d F Y') ?? '—' }}</td>
                                <td class="py-3 px-2">{{ $item->durasi ?? '—' }} Bulan</td>
                                <td class="py-3 px-2">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 px-2 text-right">
                                    @php
                                        $statusMap = [
                                            'paid' => ['label' => 'Lunas', 'color' => 'green'],
                                            'pending' => ['label' => 'Menunggu', 'color' => 'yellow'],
                                            'failed' => ['label' => 'Gagal', 'color' => 'red'],
                                            'cancelled' => ['label' => 'Dibatalkan', 'color' => 'gray'],
                                            'expired' => ['label' => 'Kadaluarsa', 'color' => 'orange'],
                                            'challenge' => ['label' => 'Tantangan', 'color' => 'purple'],
                                        ];
                                        $status = $statusMap[$item->status_pembayaran] ?? ['label' => 'Tidak Diketahui', 'color' => 'slate'];
                                    @endphp
                                    <span class="px-2 py-1 rounded-full text-xs bg-{{ $status['color'] }}-50 text-{{ $status['color'] }}-700 font-medium">{{ $status['label'] }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-slate-500">Tidak ada penghuni telat bayar</td>
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
