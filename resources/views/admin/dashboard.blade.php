@extends('layouts.admin-main')

@section('title', 'Dashboard')

@section('admin-main')
    <!-- Header Utama -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="mt-0.5 text-sm text-slate-600">Kelola kos RumahKedua lebih mudah dari dashboard ini.</p>
        </div>

        <!-- Realtime Clock - Integrasi Halus -->
        <div class="inline-flex items-center gap-2 rounded-full bg-slate-100/70 px-3.5 py-2 text-xs font-medium text-slate-700 backdrop-blur-sm border border-slate-200/40">
            <i class="fa-regular fa-clock text-slate-500"></i>
            <span id="realtime-clock" x-data="realtimeClock()" x-init="init()" x-text="time"></span>
            <span class="text-slate-500">WIB</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        {{-- Card: Hunian Terisi --}}
        <div class="rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Hunian Terisi</p>
                    <p class="mt-1 text-2xl font-bold">
                        {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->where('status', 'Tersedia')->count()) * 100, 0) : 0 }}%
                    </p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-building-user text-lg text-white"></i>
                </div>
            </div>
            <div class="mt-4 h-2 w-full rounded-full bg-white/30 overflow-hidden">
                <div class="h-full rounded-full bg-white"
                    style="width: {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->where('status', 'Tersedia')->count()) * 100, 0) : 0 }}%">
                </div>
            </div>
        </div>

        {{-- Card: Kamar Tersedia --}}
        <div class="rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Kamar Tersedia</p>
                    <p class="mt-1 text-2xl font-bold">{{ $kamar->where('status', 'Tersedia')->count() }}</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-door-open text-lg text-white"></i>
                </div>
            </div>
            <p class="mt-3 text-xs opacity-90">Dari total {{ $kamar->count() }} kamar</p>
        </div>

        {{-- Card: Pendapatan Bulan Ini --}}
        <div class="rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-violet-500 to-violet-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pendapatan Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold">Rp {{ number_format($transaksi->where('status_pembayaran', 'paid')->sum('total_bayar'), 0, ',', '.') }}</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-wallet text-lg text-white"></i>
                </div>
            </div>
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

                $trendNaik = $persentasePerubahan >= 0;
            @endphp
            <p class="mt-3 text-xs inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-white/20">
                <i class="fa-solid fa-arrow-{{ $trendNaik ? 'up' : 'down' }} text-white"></i>
                <span>{{ $trendNaik ? '+' : '' }}{{ $persentasePerubahan }}% dari bulan lalu</span>
            </p>
        </div>

        {{-- Card: Transaksi Pending --}}
        <div class="rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow duration-300 bg-gradient-to-br from-amber-500 to-amber-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Transaksi Pending</p>
                    <p class="mt-1 text-2xl font-bold">{{ $transaksi->where('status_pembayaran', 'pending')->count() }}</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-clock text-lg text-white"></i>
                </div>
            </div>
            <p class="mt-3 text-xs opacity-90">Perlu verifikasi manual</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-5">
        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Transaksi Terbaru</h2>
                <a href="{{ route('transaksi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="py-2.5 px-1">Tanggal</th>
                            <th class="py-2.5">Penyewa</th>
                            <th class="py-2.5">Kamar</th>
                            <th class="py-2.5">Total</th>
                            <th class="py-2.5 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi->take(3) as $item)
                            <tr class="bg-slate-50 rounded-lg">
                                <td class="py-3 px-1 rounded-l-lg">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-3">{{ $item->user->name }}</td>
                                <td class="py-3">{{ $item->kamar->kode_kamar }}</td>
                                <td class="py-3">{{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 text-right rounded-r-lg">
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
                            <tr class="h-2"></tr>
                        @empty
                            <p class="text-center text-slate-500">Belum ada transaksi</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pengumuman --}}
        <div class="rounded-xl border border-slate-200/60 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-base font-bold text-slate-900">Pengumuman</h2>
                <a href="{{ route('pengumuman-admin') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline">Kelola</a>
            </div>
            <ul class="space-y-3">
                @forelse ($pengumuman->take(3) as $item)
                    <li class="p-3 rounded-lg border border-slate-100 bg-slate-50">
                        <p class="text-sm font-semibold text-slate-900">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-600 mt-1">{{ Str::limit($item->isi, 35) }}</p>
                    </li>
                @empty
                    <p class="pt-15 text-sm text-center text-slate-900">Belum ada pengumuman</p>
                @endforelse
            </ul>
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
