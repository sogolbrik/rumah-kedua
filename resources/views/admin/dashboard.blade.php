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

    <!-- Table Section -->
    <div class="mt-8 grid grid-cols-1 xl:grid-cols-3 gap-5">
        {{-- Transaksi Terbaru --}}
        <div x-data="{ hoveredStatus: null }"
            class="xl:col-span-2 rounded-2xl border border-slate-200/40 bg-gradient-to-br from-white to-slate-50 p-6 shadow-[0_4px_20px_-6px_rgba(0,0,0,0.08)] hover:shadow-md transition-all duration-300 ease-out transform overflow-hidden relative">
            <!-- Accent top bar -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-cyan-500 to-emerald-500 rounded-t-2xl"></div>

            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight bg-clip-text bg-gradient-to-r from-slate-800 to-slate-600">
                    Transaksi Terbaru
                </h2>
                <a href="{{ route('transaksi.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-cyan-600 hover:text-cyan-700 group transition-colors duration-200">
                    Lihat semua
                    <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <div class="space-y-4">
                @forelse ($transaksi->take(5) as $item)
                    <div
                        class="flex items-center justify-between p-4 rounded-xl border border-slate-200/50 bg-white/70 backdrop-blur-sm hover:bg-white transition-all duration-250 hover:shadow-[0_4px_12px_-4px_rgba(0,0,0,0.1)]">
                        <!-- Tanggal -->
                        <div class="text-xs font-medium text-slate-500 whitespace-nowrap">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </div>

                        <!-- Penyewa -->
                        <div class="text-slate-800 font-semibold truncate max-w-[120px] md:max-w-[140px] mx-auto">
                            {{ $item->user->name }}
                        </div>

                        <!-- Status (dengan Alpine.js hover effect) -->
                        <div x-on:mouseenter="hoveredStatus = '{{ $item->id }}'" x-on:mouseleave="hoveredStatus = null" class="relative">
                            @php
                                $statusMap = [
                                    'paid' => ['label' => 'Lunas', 'color' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200'],
                                    'pending' => ['label' => 'Menunggu', 'color' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200'],
                                    'failed' => ['label' => 'Gagal', 'color' => 'bg-rose-100', 'text' => 'text-rose-800', 'border' => 'border-rose-200'],
                                    'cancelled' => ['label' => 'Dibatalkan', 'color' => 'bg-slate-100', 'text' => 'text-slate-800', 'border' => 'border-slate-200'],
                                    'expired' => ['label' => 'Kadaluarsa', 'color' => 'bg-orange-100', 'text' => 'text-orange-800', 'border' => 'border-orange-200'],
                                    'challenge' => ['label' => 'Tantangan', 'color' => 'bg-violet-100', 'text' => 'text-violet-800', 'border' => 'border-violet-200'],
                                    'default' => ['label' => 'Tidak Diketahui', 'color' => 'bg-slate-100', 'text' => 'text-slate-600', 'border' => 'border-slate-200'],
                                ];
                                $status = $statusMap[$item->status_pembayaran] ?? $statusMap['default'];
                            @endphp

                            <span :class="{
                                '{{ $status['color'] }} {{ $status['text'] }} border {{ $status['border'] }}': true,
                            }"
                                class="px-3 py-1.5 rounded-full text-xs font-bold transition-all duration-200" :class="hoveredStatus === '{{ $item->id }}' ? 'scale-105 shadow-sm' : ''">
                                {{ $status['label'] }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center">
                        <div class="mb-2 text-slate-400">
                            <i class="fa-regular fa-credit-card text-2xl"></i>
                        </div>
                        <p class="text-slate-500 text-sm font-medium">Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pengumuman --}}
        <div x-data="{ hovered: null }"
            class="rounded-2xl border border-slate-200/40 bg-gradient-to-br from-white to-slate-50 p-6 shadow-[0_4px_16px_-6px_rgba(0,0,0,0.07)] hover:shadow-md transition-all duration-300 ease-out transform overflow-hidden relative">
            <!-- Accent top bar -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-t-2xl"></div>

            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-bold text-slate-800 tracking-tight bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700">
                    Pengumuman
                </h2>
                <a href="{{ route('pengumuman-admin') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-indigo-600 hover:text-indigo-700 group transition-all duration-200">
                    Kelola
                    <i class="fa-solid fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>

            <ul class="space-y-4">
                @forelse ($pengumuman->take(3) as $item)
                    <li x-on:mouseenter="hovered = '{{ $item->id }}'" x-on:mouseleave="hovered = null"
                        class="relative p-4 rounded-xl border border-slate-200/50 bg-white/80 backdrop-blur-sm transition-all duration-250 hover:shadow-[0_6px_14px_-5px_rgba(0,0,0,0.12)] hover:-translate-y-0.5 overflow-hidden group">
                        <!-- Subtle hover highlight -->
                        <div x-show="hovered === '{{ $item->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                            class="absolute inset-0 bg-indigo-50/30 rounded-xl -z-10 pointer-events-none"></div>

                        <p class="text-sm font-bold text-slate-900 group-hover:text-indigo-900 transition-colors duration-200 line-clamp-1">
                            {{ $item->judul }}
                        </p>
                        <p class="text-xs text-slate-600 mt-2 leading-relaxed line-clamp-2">
                            {{ Str::limit($item->isi, 60) }}
                        </p>
                    </li>
                @empty
                    <li class="py-8 text-center">
                        <div class="mb-3 text-slate-400">
                            <i class="fa-regular fa-bell-slash text-2xl"></i>
                        </div>
                        <p class="text-sm text-slate-500 font-medium">Belum ada pengumuman</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-8 grid grid-cols-1 xl:grid-cols-2 gap-5">
        <!-- Line Chart: Penjualan Mingguan -->
        <div
            class="rounded-2xl border border-slate-200/40 bg-gradient-to-br from-white to-slate-50 p-5 shadow-[0_4px_16px_-6px_rgba(0,0,0,0.06)] h-64 overflow-hidden relative hover:shadow-md transition-all duration-300 ease-out">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-cyan-400 to-blue-500"></div>
            <div class="flex items-center gap-2 mb-3">
                <i class="fa-solid fa-chart-line text-cyan-500 text-sm"></i>
                <h3 class="text-lg font-bold text-slate-800">Penjualan 12 Bulan Terakhir</h3>
            </div>
            <div class="h-[calc(100%-28px)]">
                <canvas id="salesChart" class="h-full w-full"></canvas>
            </div>
        </div>

        <!-- Pie Chart: Distribusi Status Transaksi -->
        <div
            class="rounded-2xl border border-slate-200/40 bg-gradient-to-br from-white to-slate-50 p-5 shadow-[0_4px_16px_-6px_rgba(0,0,0,0.06)] h-64 overflow-hidden relative hover:shadow-md transition-all duration-300 ease-out">
            <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-purple-400 to-pink-500"></div>
            <div class="flex items-center gap-2 mb-3">
                <i class="fa-solid fa-chart-pie text-purple-500 text-sm"></i>
                <h3 class="text-lg font-bold text-slate-800">Distribusi Status Transaksi</h3>
            </div>
            <div class="h-[calc(100%-28px)]">
                <canvas id="statusChart" class="h-full w-full"></canvas>
            </div>
        </div>
    </div>

    <!-- Ranking Kamar Terbaik -->
    <div class="mt-8">
        <h2 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-crown text-amber-500"></i>
            Kamar Penghasil Terbaik (12 Bulan)
        </h2>

        <div class="space-y-3">
            @forelse ($topKamar as $index => $kamar)
                @php
                    $rank = $index + 1;
                    $badgeColor = match ($rank) {
                        1 => 'bg-amber-100 text-amber-800 border-amber-300',
                        2 => 'bg-gray-100 text-gray-800 border-gray-300',
                        3 => 'bg-amber-50 text-amber-700 border-amber-200',
                        default => 'bg-slate-100 text-slate-800 border-slate-300',
                    };
                    $glowColor = match ($rank) {
                        1 => 'shadow-[0_0_12px_-4px_rgba(251,191,36,0.4)]',
                        2 => 'shadow-[0_0_12px_-4px_rgba(156,163,175,0.3)]',
                        3 => 'shadow-[0_0_12px_-4px_rgba(251,191,36,0.2)]',
                        default => '',
                    };
                    $medalColor = match ($rank) {
                        1 => 'amber-600',
                        2 => 'gray-600',
                        3 => 'amber-700',
                    }
                @endphp
                

                <div class="flex items-center justify-between p-4 rounded-xl border border-slate-200/60 bg-white hover:bg-slate-50 transition-colors duration-200 {{ $glowColor }}">
                    <!-- Badge Peringkat -->
                    <div class="flex items-center gap-4">
                        <div class="{{ $badgeColor }} w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm border shadow-sm">
                            {{ $rank }}
                            <i class="fa fa-medal text-{{ $medalColor }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-slate-900 text-sm">{{ $kamar->kode_kamar }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $kamar->total_transaksi }} transaksi</p>
                        </div>
                    </div>

                    <!-- Pendapatan -->
                    <div class="text-right">
                        <p class="font-bold text-slate-900">Rp {{ number_format($kamar->total_pendapatan, 0, ',', '.') }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Total pendapatan</p>
                    </div>
                </div>
            @empty
                <div class="py-6 text-center text-slate-500 text-sm">
                    <i class="fa-regular fa-face-frown mb-1"></i><br>
                    Belum ada transaksi dalam 12 bulan terakhir
                </div>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/chart-js/chart.js') }}"></script>
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
                    layout: {
                        padding: {
                            bottom: 10
                        }
                    },
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
                    layout: {
                        padding: {
                            bottom: 30
                        }
                    },
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
@endpush
