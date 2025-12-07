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
    </div>

    <!-- Card Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5">
        {{-- Card: Hunian Terisi --}}
        <div x-data="countUp({{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->where('status', 'Tersedia')->count()) * 100, 0) : 0 }})" x-init="animate"
            class="group rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-blue-500 to-blue-600 text-white relative overflow-hidden">
            <div class="absolute -top-3 -right-3 h-16 w-16 bg-white/10 rounded-full blur-lg group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Hunian Terisi</p>
                    <p class="mt-1 text-2xl font-bold" x-text="display + '%'">0%</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center group-hover:rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-building-user text-lg text-white"></i>
                </div>
            </div>
            <div class="mt-4 h-2 w-full rounded-full bg-white/30 overflow-hidden">
                <div class="h-full rounded-full bg-white transition-all duration-1000 ease-out" :style="'width: ' + display + '%'"></div>
            </div>
        </div>

        {{-- Card: Kamar Tersedia --}}
        <div x-data="countUp({{ $kamar->where('status', 'Tersedia')->count() }})" x-init="animate"
            class="group rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-emerald-500 to-emerald-600 text-white relative overflow-hidden">
            <div class="absolute -top-3 -right-3 h-16 w-16 bg-white/10 rounded-full blur-lg group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Kamar Tersedia</p>
                    <p class="mt-1 text-2xl font-bold" x-text="display">0</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center group-hover:-rotate-12 transition-transform duration-300">
                    <i class="fa-solid fa-door-open text-lg text-white"></i>
                </div>
            </div>
            <p class="mt-3 text-xs opacity-90">Dari total {{ $kamar->count() }} kamar</p>
        </div>

        {{-- Card: Pendapatan Bulan Ini --}}
        <div x-data="countUp({{ $transaksi->where('status_pembayaran', 'paid')->sum('total_bayar') }})" x-init="animate"
            class="group rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-violet-500 to-violet-600 text-white relative overflow-hidden">
            <div class="absolute -top-3 -right-3 h-16 w-16 bg-white/10 rounded-full blur-lg group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Pendapatan Bulan Ini</p>
                    <p class="mt-1 text-2xl font-bold" x-text="'Rp ' + formatNumber(display)">Rp 0</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
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
        <div x-data="countUp({{ $transaksi->where('status_pembayaran', 'pending')->count() }})" x-init="animate"
            class="group rounded-xl p-5 shadow-sm hover:shadow-xl transition-all duration-300 bg-gradient-to-br from-amber-500 to-amber-600 text-white relative overflow-hidden">
            <div class="absolute -top-3 -right-3 h-16 w-16 bg-white/10 rounded-full blur-lg group-hover:scale-125 transition-transform duration-500"></div>
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm opacity-90">Transaksi Pending</p>
                    <p class="mt-1 text-2xl font-bold" x-text="display">0</p>
                </div>
                <div class="h-11 w-11 rounded-xl bg-white/20 flex items-center justify-center group-hover:rotate-45 transition-transform duration-300">
                    <i class="fa-solid fa-clock text-lg text-white"></i>
                </div>
            </div>
            <p class="mt-3 text-xs opacity-90">Perlu verifikasi manual</p>
        </div>
    </div>

    <!-- Alpine.js CountUp Utility -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countUp', (target) => ({
                target: target,
                display: 0,
                animate() {
                    const duration = 1200;
                    const start = 0;
                    const end = this.target;
                    const startTime = performance.now();

                    const step = (now) => {
                        const elapsed = now - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        this.display = Math.floor(progress * (end - start) + start);
                        if (progress < 1) {
                            requestAnimationFrame(step);
                        }
                    };
                    requestAnimationFrame(step);
                },
                formatNumber(num) {
                    return num.toLocaleString('id-ID');
                }
            }));
        });
    </script>

    <!-- Table Section -->
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-3 gap-5">
        {{-- Transaksi Terbaru --}}
        <div class="xl:col-span-2 rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Transaksi Terbaru</h2>
                <a href="{{ route('transaksi.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 group">
                    Lihat semua
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1"></i>
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500">
                        <tr>
                            <th class="py-3 px-2 font-medium">Tanggal</th>
                            <th class="py-3 font-medium">Penyewa</th>
                            <th class="py-3 font-medium">Kamar</th>
                            <th class="py-3 font-medium">Total</th>
                            <th class="py-3 text-right font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transaksi->take(3) as $item)
                            <tr class="bg-slate-50/70 rounded-lg hover:bg-slate-100 transition-colors duration-200">
                                <td class="py-3 px-2 rounded-l-lg text-slate-700">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-3 text-slate-800 font-medium">{{ $item->user->name }}</td>
                                <td class="py-3 text-slate-700">{{ $item->kamar->kode_kamar }}</td>
                                <td class="py-3 text-slate-800 font-semibold">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-3 text-right rounded-r-lg">
                                    @if ($item->status_pembayaran === 'paid')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-green-100 text-green-700 font-medium border border-green-200/60">Lunas</span>
                                    @elseif ($item->status_pembayaran === 'pending')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-yellow-100 text-yellow-700 font-medium border border-yellow-200/60">Menunggu</span>
                                    @elseif ($item->status_pembayaran === 'failed')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-red-100 text-red-700 font-medium border border-red-200/60">Gagal</span>
                                    @elseif ($item->status_pembayaran === 'cancelled')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-gray-100 text-gray-700 font-medium border border-gray-200/60">Dibatalkan</span>
                                    @elseif ($item->status_pembayaran === 'expired')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-orange-100 text-orange-700 font-medium border border-orange-200/60">Kadaluarsa</span>
                                    @elseif ($item->status_pembayaran === 'challenge')
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-purple-100 text-purple-700 font-medium border border-purple-200/60">Tantangan</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-xs bg-slate-100 text-slate-700 font-medium border border-slate-200/60">Tidak Diketahui</span>
                                    @endif
                                </td>
                            </tr>
                            <tr class="h-3"></tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-slate-500 py-6">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pengumuman --}}
        <div class="rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-900 tracking-tight">Pengumuman</h2>
                <a href="{{ route('pengumuman-admin') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 group">
                    Kelola
                    <i class="fa-solid fa-arrow-right text-xs transition-transform duration-200 group-hover:translate-x-1"></i>
                </a>
            </div>
            <ul class="space-y-3">
                @forelse ($pengumuman->take(3) as $item)
                    <li class="p-4 rounded-xl border border-slate-100 bg-slate-50/70 hover:bg-slate-100 transition-all duration-200 hover:shadow-sm">
                        <p class="text-sm font-semibold text-slate-900">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-600 mt-1.5 leading-relaxed">{{ Str::limit($item->isi, 40) }}</p>
                    </li>
                @empty
                    <p class="pt-10 text-sm text-center text-slate-500">Belum ada pengumuman</p>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-6 grid grid-cols-1 xl:grid-cols-2 gap-5">
        <!-- Line Chart: Penjualan Mingguan -->
        <div class="rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm h-64">
            <h3 class="text-lg font-bold text-slate-900 mb-3">Penjualan 12 Bulan Terakhir</h3>
            <canvas id="salesChart" class="h-full w-full"></canvas>
        </div>

        <!-- Pie Chart: Distribusi Status Transaksi -->
        <div class="rounded-2xl border border-slate-200/60 bg-white p-6 shadow-sm h-64">
            <h3 class="text-lg font-bold text-slate-900 mb-3">Distribusi Status Transaksi</h3>
            <canvas id="statusChart" class="h-full w-full"></canvas>
        </div>
    </div>

    <!-- Chart.js CDN + Initialization -->
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // === Line Chart (Crypto-like) ===
                const ctx1 = document.getElementById('salesChart').getContext('2d');
                new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: @json($monthlySalesLabels),
                        datasets: [{
                            label: 'Penjualan (Rp)',
                            data: @json($monthlySalesData),
                            borderColor: '#4f46e5', // indigo-600
                            backgroundColor: 'rgba(79, 70, 229, 0.1)',
                            borderWidth: 2,
                            tension: 0.4, // smooth curve like crypto
                            fill: true,
                            pointRadius: 0,
                            pointHoverRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    label: function(context) {
                                        return 'Rp ' + Number(context.parsed.y).toLocaleString('id-ID');
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    maxRotation: 0,
                                    callback: function(value, index, ticks) {
                                        const date = @json($monthlySalesLabels)[value];
                                        return date.split('-').slice(1).join('/'); // MM/DD
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(0,0,0,0.03)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp ' + value.toLocaleString('id-ID');
                                    }
                                }
                            }
                        }
                    }
                });

                // === Pie Chart ===
                const ctx2 = document.getElementById('statusChart').getContext('2d');
                const statusLabels = @json(array_keys($statusCounts));
                const statusData = @json(array_values($statusCounts));

                // Warna berdasarkan status
                const colorMap = {
                    'paid': '#10b981', // emerald-500
                    'pending': '#f59e0b', // amber-500
                    'failed': '#ef4444', // red-500
                    'cancelled': '#6b7280', // gray-500
                    'expired': '#f97316', // orange-500
                    'challenge': '#8b5cf6' // violet-500
                };
                const backgroundColors = statusLabels.map(label => colorMap[label] || '#d1d5db');

                new Chart(ctx2, {
                    type: 'doughnut',
                    data: {
                        labels: statusLabels.map(label => {
                            const mapping = {
                                'paid': 'Lunas',
                                'pending': 'Menunggu',
                                'failed': 'Gagal',
                                'cancelled': 'Dibatalkan',
                                'expired': 'Kadaluarsa',
                                'challenge': 'Tantangan'
                            };
                            return mapping[label] || label;
                        }),
                        datasets: [{
                            data: statusData,
                            backgroundColor: backgroundColors,
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });
            });
        </script>
    @endpush
@endsection
