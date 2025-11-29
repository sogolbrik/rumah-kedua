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
                    <p class="mt-1 text-2xl font-semibold text-slate-900">
                        {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->where('status', 'Tersedia')->count()) * 100, 0) : 0 }}%</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-building-user"></i>
                </div>
            </div>
            <div class="mt-4 h-2 w-full rounded-full bg-slate-100">
                <div class="h-2 rounded-full bg-blue-600"
                    style="width: {{ $kamar->where('status', 'Terisi')->count() ? round(($kamar->where('status', 'Terisi')->count() / $kamar->where('status', 'Tersedia')->count()) * 100, 0) : 0 }}%"></div>
            </div>
        </div>

        {{-- Card: Kamar Tersedia --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Kamar Tersedia</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $kamar->where('status', 'Tersedia')->count() }}</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-door-open"></i>
                </div>
            </div>
            <p class="mt-3 text-xs text-slate-500">Dari total {{ $kamar->count() }} kamar</p>
        </div>

        {{-- Card: Pendapatan Bulan Ini --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Pendapatan Bulan Ini</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">Rp {{ number_format($transaksi->where('status_pembayaran', 'paid')->sum('total_bayar'), 0, ',', '.') }}</p>
                </div>
                <div class="h-10 w-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                    <i class="fa-solid fa-wallet"></i>
                </div>
            </div>
            {{-- <p class="mt-3 text-xs text-blue-700 bg-blue-50 inline-flex items-center gap-1 px-2 py-0.5 rounded">
                <i class="fa-solid fa-arrow-{{ $selisih >= 0 ? 'up' : 'down' }}"></i> {{ $selisih >= 0 ? '+' : '' }}{{ number_format($selisih, 1) }}% dari bulan lalu
            </p> --}}
        </div>

        {{-- Card: Transaksi Pending --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Transaksi Pending</p>
                    <p class="mt-1 text-2xl font-semibold text-slate-900">{{ $transaksi->where('status_pembayaran', 'pending')->count() }}</p>
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
                <a href="{{ route('transaksi.index') }}" class="text-sm text-blue-700 hover:underline">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-left text-slate-500 border-b border-slate-200">
                        <tr>
                            <th class="py-2">Tanggal</th>
                            <th class="py-2">Penyewa</th>
                            <th class="py-2">Kamar</th>
                            <th class="py-2">Total Bayar</th>
                            <th class="py-2 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($transaksi as $item)
                            <tr>
                                <td class="py-2">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="py-2">{{ $item->user->name }}</td>
                                <td class="py-2">{{ $item->kamar->kode_kamar }}</td>
                                <td class="py-2">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-2 text-right">
                                    @if ($item->status_pembayaran === 'paid')
                                        <span class="px-2 py-1 rounded text-xs bg-green-50 text-green-700">Lunas</span>
                                    @elseif ($item->status_pembayaran === 'pending')
                                        <span class="px-2 py-1 rounded text-xs bg-yellow-50 text-yellow-700">Menunggu</span>
                                    @elseif ($item->status_pembayaran === 'failed')
                                        <span class="px-2 py-1 rounded text-xs bg-red-50 text-red-700">Gagal</span>
                                    @elseif ($item->status_pembayaran === 'cancelled')
                                        <span class="px-2 py-1 rounded text-xs bg-gray-50 text-gray-700">Dibatalkan</span>
                                    @elseif ($item->status_pembayaran === 'expired')
                                        <span class="px-2 py-1 rounded text-xs bg-orange-50 text-orange-700">Kadaluarsa</span>
                                    @elseif ($item->status_pembayaran === 'challenge')
                                        <span class="px-2 py-1 rounded text-xs bg-purple-50 text-purple-700">Tantangan</span>
                                    @else
                                        <span class="px-2 py-1 rounded text-xs bg-slate-50 text-slate-700">Tidak Diketahui</span>
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

        {{-- Pengumuman --}}
        <div class="rounded-xl border border-slate-200 bg-white p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-base font-semibold text-slate-900">Pengumuman</h2>
                <a href="{{ route('pengumuman-admin') }}" class="text-sm text-blue-700 hover:underline">Kelola</a>
            </div>
            <ul class="space-y-3">
                @forelse ($pengumuman->take(3) as $item)
                    <li class="p-3 rounded-lg border border-slate-100 bg-white">
                        <p class="text-sm font-medium text-slate-900">{{ $item->judul }}</p>
                        <p class="text-xs text-slate-600">{{ $item->isi }}</p>
                    </li>
                @empty
                    <p class="pt-15 text-sm text-center text-slate-900">Belum ada pengumuman</p>
                @endforelse
            </ul>
        </div>
    </div>
@endsection
