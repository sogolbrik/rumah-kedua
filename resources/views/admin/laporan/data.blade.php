@extends('layouts.admin-main')

@section('title', 'Laporan')

@section('admin-main')
    <div class="p-4 sm:p-6 lg:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Laporan Sistem</h1>
            <p class="text-gray-600">Kelola dan ekspor data penghuni, keuangan, kamar, dan lainnya.</p>
        </div>

        <!-- Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-6 overflow-x-auto pb-2">
                @php
                    $tabs = [
                        'penghuni' => 'Penghuni',
                        'keuangan' => 'Keuangan',
                        'pembayaran' => 'Pembayaran',
                        'kamar' => 'Kamar',
                        'tagihan' => 'Tagihan',
                        'aktivitas' => 'Aktivitas',
                    ];
                @endphp
                @foreach ($tabs as $key => $label)
                    <a href="{{ route('laporan.index', ['laporan' => $key]) }}"
                        class="whitespace-nowrap pb-2 px-1 border-b-2 text-sm font-medium transition-colors duration-150
                        {{ request('laporan', 'penghuni') === $key ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Filter & Export -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <!-- Filter Section -->
            <div class="w-full sm:w-auto">
                @if ($laporan === 'penghuni')
                    <form class="flex flex-wrap gap-2" x-show="activeTab === 'penghuni'" x-cloak>
                        <select name="kamar" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Kamar</option>
                            @foreach ($kamarList ?? [] as $k)
                                <option value="{{ $k->id }}">{{ $k->kode_kamar }}</option>
                            @endforeach
                        </select>
                        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="menunggak">Menunggak</option>
                        </select>
                        <input type="date" name="tanggal_masuk" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Filter</button>
                    </form>
                @elseif($laporan === 'keuangan')
                    <form x-show="activeTab === 'keuangan'" x-cloak class="flex flex-wrap gap-2">
                        <select name="periode" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            <option value="hari" {{ request('periode') == 'hari' ? 'selected' : '' }}>Harian</option>
                            <option value="minggu" {{ request('periode') == 'minggu' ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulan" {{ request('periode') == 'bulan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="tahun" {{ request('periode') == 'tahun' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">Terapkan</button>
                    </form>
                @endif
            </div>

            <!-- Export Buttons -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('laporan.export', ['type' => 'pdf', 'laporan' => $laporan]) }}"
                    class="inline-flex items-center justify-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    PDF
                </a>
                <a href="{{ route('laporan.export', ['type' => 'excel', 'laporan' => $laporan]) }}"
                    class="inline-flex items-center justify-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <a href="{{ route('laporan.export', ['type' => 'csv', 'laporan' => $laporan]) }}"
                    class="inline-flex items-center justify-center gap-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    CSV
                </a>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="space-y-6">
            @if ($laporan === 'penghuni')
                <!-- Penghuni -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Daftar Penghuni</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (['Nama', 'Email', 'Kamar', 'Tgl Masuk', 'Status', 'Durasi'] as $col)
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($penghuni ?? [] as $p)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $p->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->kamar?->kode_kamar ?? '–' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $p->tanggal_masuk ? \Carbon\Carbon::parse($p->tanggal_masuk)->format('d M Y') : '–' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $p->status_penghuni === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $p->status_penghuni ?: '–' }}
                                                </span>
                                            </td>
                                            {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $p->tanggal_masuk ? now()->parse($p->tanggal_masuk)->diffInDays() . ' hari' : '–' }}
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">Tidak ada data penghuni.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if ($laporan === 'keuangan')
                <!-- Keuangan -->
                <div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Pendapatan</h3>
                            <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($pendapatan ?? 0, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pendapatan (7 Hari Terakhir)</h3>
                            <canvas id="pendapatanChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            @endif

            @if ($laporan === 'pembayaran')
                <!-- Pembayaran -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Riwayat Pembayaran</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (['Invoice', 'Penghuni', 'Kamar', 'Jatuh Tempo', 'Total', 'Metode', 'Status'] as $col)
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($transaksis ?? [] as $t)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $t->kode }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->user?->name ?? '–' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->kamar?->kode_kamar ?? '–' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->tanggal_jatuhtempo->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($t->metode_pembayaran) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($t->status_pembayaran === 'paid') bg-green-100 text-green-800
                                            @elseif($t->status_pembayaran === 'pending') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                                    {{ ucfirst($t->status_pembayaran) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">Tidak ada transaksi.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if (isset($transaksis) && $transaksis->hasPages())
                            <div class="px-6 py-4 border-t border-gray-100">
                                {{ $transaksis->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if ($laporan === 'kamar')
                <!-- Kamar -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">Analisis Kamar</h2>
                        <div class="mb-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">Occupancy Rate:</span>
                                <span class="text-xl font-bold text-blue-600">{{ $occupancyRate ?? 0 }}%</span>
                            </div>
                            <div class="mt-3 w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $occupancyRate ?? 0 }}%"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-800 mb-3">Status Kamar</h3>
                                <ul class="space-y-2">
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Terisi</span>
                                        <span class="font-medium">{{ $terisi ?? 0 }}</span>
                                    </li>
                                    <li class="flex justify-between">
                                        <span class="text-gray-600">Kosong</span>
                                        <span class="font-medium">{{ $kosong ?? 0 }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-medium text-gray-800 mb-3">Kamar Kosong Terlama</h3>
                                <ul class="space-y-2">
                                    @forelse ($kamarKosongLama ?? [] as $k)
                                        <li class="text-sm text-gray-700">{{ $k->kode_kamar }}<br><span class="text-xs text-gray-500">Sejak {{ $k->updated_at->format('d M Y') }}</span></li>
                                    @empty
                                        <li class="text-sm text-gray-500">Tidak ada kamar kosong.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($laporan === 'tagihan')
                <!-- Tagihan -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h2 class="text-lg font-semibold text-gray-800">Daftar Tagihan</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach (['Invoice', 'Penghuni', 'Jatuh Tempo', 'Status', 'Total'] as $col)
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $col }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($tagihan ?? [] as $t)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $t->kode }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->user?->name ?? '–' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $t->tanggal_jatuhtempo->format('d M Y') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                            @if ($t->status_tagihan === 'Lunas') bg-green-100 text-green-800
                                            @elseif($t->status_tagihan === 'Telat') bg-red-100 text-red-800
                                            @elseif($t->status_tagihan === 'Jatuh Tempo') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                                    {{ $t->status_tagihan }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($t->total_bayar, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">Tidak ada tagihan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            @if ($laporan === 'aktivitas')
                <!-- Aktivitas -->
                <div>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-2">Laporan Aktivitas Admin</h2>
                        <p class="text-gray-600">Fitur ini memerlukan integrasi dengan sistem logging (misal: <code class="bg-gray-100 px-1 rounded">owen-it/laravel-auditing</code>).</p>
                        <div class="mt-4">
                            <a href="https://github.com/owen-it/laravel-auditing" target="_blank" class="inline-flex items-center gap-1 text-blue-600 hover:underline">
                                Pelajari cara mengaktifkan
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('laporan', () => ({
                    init() {
                        @if ($laporan === 'keuangan')
                            const ctx = document.getElementById('pendapatanChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: @json(array_column($chartData ?? [], 'date')),
                                    datasets: [{
                                        label: 'Pendapatan (Rp)',
                                        data: @json(array_column($chartData ?? [], 'total')),
                                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                                        borderColor: 'rgb(59, 130, 246)',
                                        borderWidth: 1
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
                                            ticks: {
                                                callback: function(value) {
                                                    return 'Rp ' + value.toLocaleString();
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        @endif
                    }
                }));
            });
        </script>
    @endpush
@endsection
