@extends('layouts.admin-main')

@section('title', 'Dashboard')

@section('admin-main')
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card: Hunian Terisi --}}
        <div x-data="countUp({{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->count()) * 100, 0) : 0 }})" x-init="animate" class="group relative overflow-hidden rounded-[2rem] bg-slate-900 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 rounded-2xl bg-white/10 flex items-center justify-center text-white transition-transform group-hover:scale-110">
                        <i class="fa-solid fa-people-roof text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Occupancy Rate</span>
                </div>
                <p class="text-4xl font-black text-white" x-text="display + '%'"></p>
                <p class="text-xs font-medium text-slate-400 mt-1">Rasio Unit Terisi</p>

                <div class="mt-4 h-1.5 w-full rounded-full bg-white/10 overflow-hidden">
                    <div class="h-full rounded-full bg-blue-500 transition-all duration-1000 ease-out shadow-[0_0_12px_rgba(59,130,246,0.6)]" :style="'width: ' + display + '%'"></div>
                </div>
            </div>
            <div class="absolute -right-6 -bottom-6 text-white/5 text-8xl transition-transform group-hover:scale-110">
                <i class="fa-solid fa-building"></i>
            </div>
        </div>

        {{-- Card: Kamar Tersedia --}}
        <div x-data="countUp({{ $kamar->where('status', 'Tersedia')->count() }})" x-init="animate"
            class="group relative overflow-hidden rounded-[2rem] bg-white border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <div class="relative z-10 text-slate-900">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 transition-transform group-hover:rotate-12">
                        <i class="fa-solid fa-door-open text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Available Units</span>
                </div>
                <p class="text-4xl font-black" x-text="display"></p>
                <p class="text-xs font-medium text-slate-500 mt-1">Total {{ $kamar->count() }} Kamar</p>
                <div class="mt-4 flex items-center gap-2">
                    <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-emerald-600 uppercase">Siap Huni</span>
                </div>
            </div>
        </div>

        {{-- Card: Pendapatan --}}
        <div x-data="countUp({{ $transaksi->where('status_pembayaran', 'paid')->sum('total_bayar') }})" x-init="animate"
            class="group relative overflow-hidden rounded-[2rem] bg-white border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-wallet text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Revenue Month</span>
                </div>
                <p class="text-2xl font-black text-slate-900" x-text="'Rp ' + formatNumber(display)"></p>
                @php
                    $bulanIni = \Carbon\Carbon::now()->startOfMonth();
                    $bulanLalu = \Carbon\Carbon::now()->subMonth()->startOfMonth();
                    $penjualanBulanIni = $transaksi->where('status_pembayaran', 'paid')->where('created_at', '>=', $bulanIni)->sum('total_bayar');
                    $penjualanBulanLalu = $transaksi->where('status_pembayaran', 'paid')->where('created_at', '>=', $bulanLalu)->where('created_at', '<', $bulanIni)->sum('total_bayar');
                    $persentasePerubahan = $penjualanBulanLalu > 0 ? round((($penjualanBulanIni - $penjualanBulanLalu) / $penjualanBulanLalu) * 100, 1) : ($penjualanBulanIni > 0 ? 100 : 0);
                    $trendNaik = $persentasePerubahan >= 0;
                @endphp
                <p class="mt-3 text-[10px] font-bold inline-flex items-center gap-1.5 px-3 py-1 rounded-lg {{ $trendNaik ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                    <i class="fa-solid fa-arrow-{{ $trendNaik ? 'up' : 'down' }}"></i>
                    {{ abs($persentasePerubahan) }}% vs Bulan Lalu
                </p>
            </div>
        </div>

        {{-- Card: Pending --}}
        <div x-data="countUp({{ $transaksi->where('status_pembayaran', 'pending')->count() }})" x-init="animate"
            class="group relative overflow-hidden rounded-[2rem] bg-white border border-slate-200 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="h-12 w-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-600 transition-transform group-hover:rotate-45">
                        <i class="fa-solid fa-circle-exclamation text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-tighter text-slate-400">Action Required</span>
                </div>
                <p class="text-4xl font-black text-slate-900" x-text="display"></p>
                <p class="text-xs font-medium text-slate-500 mt-1">Transaksi Menunggu</p>
                <div class="mt-4">
                    <a href="{{ route('transaksi.index') }}" class="text-[10px] font-black text-amber-600 uppercase border-b-2 border-amber-200 hover:border-amber-600 transition-colors">
                        Cek Verifikasi &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 rounded-[2.5rem] bg-white border border-slate-200 p-8 shadow-sm relative">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Statistik Pendapatan</h3>
                    <p class="text-xs text-slate-500 font-medium">Visualisasi tren keuangan 12 bulan terakhir</p>
                </div>
                <div class="h-10 w-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-400">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
            <div class="h-72">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <div class="rounded-[2.5rem] bg-slate-900 p-8 shadow-xl relative overflow-hidden">
            <div class="relative z-10">
                <h3 class="text-lg font-black text-white mb-1">Top Performers</h3>
                <p class="text-xs text-slate-400 font-medium mb-6">Unit dengan Penjualan tertinggi tahun ini</p>

                <div class="space-y-4">
                    @forelse ($topKamar as $index => $kamar)
                        @php $rank = $index + 1; @endphp
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors group">
                            <div class="flex items-center gap-4">
                                <div
                                    class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center text-sm font-black text-white border border-white/10 group-hover:bg-blue-600 transition-colors">
                                    {{ $rank }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white uppercase">{{ $kamar->kode_kamar }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $kamar->total_transaksi }} Booking</p>
                                </div>
                            </div>
                            @php
                                $pendapatan = $kamar->total_pendapatan;
                                if ($pendapatan >= 1000000) {
                                    $nilai = round($pendapatan / 1000000, 1);
                                    if (fmod($nilai, 1) == 0) {
                                        $nilai = (int) $nilai;
                                    }
                                    $satuan = 'JT';
                                } elseif ($pendapatan >= 1000) {
                                    $nilai = round($pendapatan / 1000);
                                    $satuan = 'K';
                                } else {
                                    $nilai = $pendapatan;
                                    $satuan = '';
                                }
                            @endphp
                            <p class="text-sm font-black text-white">Rp{{ $nilai }}{{ $satuan }}</p>
                        </div>
                    @empty
                        <p class="text-center text-slate-500 py-10 text-xs italic">Data belum tersedia</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        {{-- Transaksi Terbaru --}}
        <div class="rounded-[2.5rem] bg-white border border-slate-200 p-8 shadow-sm">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">Recent Activity</h3>
                <a href="{{ route('transaksi.index') }}"
                    class="h-8 w-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 hover:bg-blue-600 hover:text-white transition-all shadow-sm">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
            <div class="space-y-3">
                @foreach ($transaksi->take(5) as $item)
                    <div class="flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="h-10 w-10 rounded-full bg-slate-100 border-4 border-white shadow-sm flex items-center justify-center text-slate-400 text-xs font-black">
                                {{ substr($item->user->name, 0, 2) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-800">{{ $item->user->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold tracking-widest uppercase">{{ $item->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @php
                            $colorMap = [
                                'paid' => 'bg-emerald-500 text-white',
                                'pending' => 'bg-amber-400 text-white',
                                'failed' => 'bg-rose-500 text-white',
                            ];
                            $statusLabel = [
                                'paid' => 'Success',
                                'pending' => 'Pending',
                                'failed' => 'Failed',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-tighter {{ $colorMap[$item->status_pembayaran] ?? 'bg-slate-200 text-slate-600' }}">
                            {{ $statusLabel[$item->status_pembayaran] ?? $item->status_pembayaran }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Status Distribution --}}
        <div class="rounded-[2.5rem] bg-white border border-slate-200 p-8 shadow-sm flex flex-col items-center">
            <div class="w-full text-left mb-6">
                <h3 class="text-lg font-black text-slate-900">Transaction Pulse</h3>
                <p class="text-xs text-slate-500 font-medium">Distribusi status pembayaran saat ini</p>
            </div>
            <div class="relative w-full h-64">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .chart-container {
            position: relative;
            margin: auto;
            height: 100%;
            width: 100%;
        }
    </style>
@endsection

@push('scripts')
    <script src="{{ asset('assets/vendor/chart-js/chart.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Line Chart Styling
            const ctx1 = document.getElementById('salesChart').getContext('2d');
            const gradient = ctx1.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: @json($monthlySalesLabels),
                    datasets: [{
                        data: @json($monthlySalesData),
                        borderColor: '#2563eb',
                        borderWidth: 4,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#2563eb',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 10
                                },
                                color: '#94a3b8'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: 'bold',
                                    size: 10
                                },
                                color: '#94a3b8'
                            }
                        }
                    }
                }
            });

            // Doughnut Chart
            const ctx2 = document.getElementById('statusChart').getContext('2d');
            new Chart(ctx2, {
                type: 'doughnut',
                data: {
                    labels: @json(array_keys($statusCounts)),
                    datasets: [{
                        data: @json(array_values($statusCounts)),
                        backgroundColor: ['#10b981', '#fbbf24', '#ef4444', '#64748b', '#f97316', '#8b5cf6'],
                        borderWidth: 8,
                        borderColor: '#ffffff',
                        hoverOffset: 20
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                font: {
                                    weight: 'bold',
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        });

        // Alpine.js Components 
        document.addEventListener('alpine:init', () => {
            Alpine.data('countUp', (target) => ({
                target: target,
                display: 0,
                animate() {
                    let start = 0;
                    const duration = 1500;
                    const startTime = performance.now();
                    const step = (now) => {
                        const progress = Math.min((now - startTime) / duration, 1);
                        this.display = Math.floor(progress * (this.target - start) + start);
                        if (progress < 1) requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                },
                formatNumber(num) {
                    return num.toLocaleString('id-ID');
                }
            }));

            Alpine.data('realtimeClock', () => ({
                time: '',
                init() {
                    this.updateTime();
                    setInterval(() => this.updateTime(), 1000);
                },
                updateTime() {
                    this.time = new Date().toLocaleString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });
                }
            }));
        });
    </script>
@endpush
