@extends('layouts.frontend-main')
@section('title', 'Dashboard Penghuni - RumahKedua')

@section('frontend-main')
    <div x-data="{
        openContact: false,
        detailModal: false,
        detailData: { kode: '', total: '', metode: '', status: '', created_at: '' }
    }" class="min-h-screen bg-gradient-to-br from-indigo-50 to-teal-50 pt-18 pb-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumb -->
            <nav class="text-sm text-indigo-600 mb-5" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-1.5">
                    <li><a href="{{ route('dashboard-penghuni') }}" class="hover:underline font-medium">Dashboard</a></li>
                    <li class="text-indigo-300">/</li>
                    <li class="font-semibold text-indigo-900">Penghuni</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-10">
                <!-- Bagian Kiri: Salam + Info User -->
                <div class="flex items-center gap-4">
                    <!-- Avatar User -->
                    <div class="relative">
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}" class="w-12 h-12 rounded-full ring-2 ring-indigo-200 object-cover">
                        @else
                            <!-- Fallback: Inisial -->
                            <div class="w-12 h-12 rounded-full bg-gradient-to-r from-indigo-500 to-teal-500 flex items-center justify-center text-white font-bold text-sm ring-2 ring-indigo-200">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        @endif
                    </div>

                    <!-- Nama & Role -->
                    <div>
                        <h1 class="text-2xl font-bold text-slate-800">Halo, {{ $user->name }}!</h1>
                        <p class="text-xs font-medium px-2 py-0.5 bg-indigo-100 text-indigo-700 rounded-full w-fit">
                            {{ $user->role ?? 'Penghuni' }}
                        </p>
                    </div>
                </div>

                <!-- Bagian Kanan: Tombol Aksi -->
                <div class="flex flex-wrap gap-3 items-center">
                    <div x-data="{ openProfile: false }" class="relative">
                        <button @click="openProfile = !openProfile"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-xl hover:bg-slate-50 hover:border-slate-400 transition-all duration-200 font-medium">
                            <i class="fa-solid fa-user-gear text-slate-600"></i>
                            <span>Pengaturan</span>
                            <i class="fa-solid fa-chevron-down text-xs opacity-70"></i>
                        </button>

                        <div x:cloak x-show="openProfile" @click.outside="openProfile = false" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-10">
                            <a href="{{ route('profil-penghuni.index') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100">
                                <i class="fa-solid fa-user-edit mr-2 text-slate-500"></i> Edit Profil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 flex items-center">
                                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <button @click="openContact = true"
                        class="group px-5 py-2.5 border-2 border-indigo-200 text-indigo-700 rounded-xl hover:bg-indigo-50 hover:border-indigo-300 transition-all duration-200 font-medium">
                        <i class="fa-solid fa-headset mr-2 group-hover:animate-pulse"></i> Hubungi Admin
                    </button>
                </div>
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Kartu Kamar -->
                <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    @if ($user->kamar)
                        @if ($user->kamar->gambar)
                            <div class="h-40 overflow-hidden">
                                <img src="{{ Storage::url($user->kamar->gambar) }}" alt="Kamar {{ $user->kamar->kode_kamar }}"
                                    class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                            </div>
                        @endif
                        <div class="p-5">
                            <div class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs font-bold mb-2">
                                {{ $user->kamar->tipe }}
                            </div>
                            <h3 class="font-bold text-xl text-slate-800">{{ $user->kamar->kode_kamar }}</h3>
                            <p class="text-slate-600 mt-2 text-sm">{{ Str::limit($user->kamar->deskripsi, 90) }}</p>
                            <div class="mt-4 flex items-center justify-between">
                                <span class="text-sm text-slate-500">Harga</span>
                                <span class="text-lg font-bold text-teal-600">Rp {{ number_format($user->kamar->harga, 0, ',', '.') }}</span>
                            </div>
                            <div class="mt-2 flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full bg-teal-100 text-teal-800 text-xs font-medium">
                                    <i class="fa-solid fa-circle text-teal-500 mr-1 text-xs"></i> Aktif
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12 px-6">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-indigo-100 text-indigo-600 mb-4">
                                <i class="fa-solid fa-door-open text-2xl"></i>
                            </div>
                            <h3 class="font-bold text-lg text-slate-800 mb-2">Belum Punya Kamar?</h3>
                            <p class="text-slate-600 text-sm mb-4">Temukan kamar impian Anda sekarang!</p>
                            <a href="{{ route('booking') }}"
                                class="inline-block px-5 py-2 bg-gradient-to-r from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 text-white rounded-xl shadow transition-all duration-300">
                                Lihat Kamar Tersedia
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Statistik Penghuni -->
                <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 hover:shadow-xl transition-shadow duration-300 p-5 md:col-span-1">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center">
                        <i class="fa-solid fa-chart-line text-indigo-600 mr-2"></i> Statistik Anda
                    </h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-indigo-50 border border-indigo-100">
                            <div class="text-xs text-indigo-600 font-medium">Total Transaksi</div>
                            <div class="text-xl font-bold text-indigo-800 mt-1">{{ $totalTransaksi }}</div>
                        </div>
                        <div class="p-4 rounded-xl bg-teal-50 border border-teal-100">
                            <div class="text-xs text-teal-600 font-medium">Total Bayar</div>
                            <div class="text-xl font-bold text-teal-800 mt-1">Rp {{ number_format($totalBayar, 0, ',', '.') }}</div>
                        </div>
                        <div class="p-4 rounded-xl bg-amber-50 border border-amber-100">
                            <div class="text-xs text-amber-600 font-medium">Terakhir Bayar</div>
                            <div class="text-xl font-bold text-amber-800 mt-1">
                                {{ $terakhirBayar?->translatedFormat('d F Y') ?? '–' }}
                            </div>
                        </div>
                        <div class="p-4 rounded-xl {{ $menunggak ? 'bg-rose-50 border-rose-100' : 'bg-emerald-50 border-emerald-100' }}">
                            <div class="text-xs {{ $menunggak ? 'text-rose-600' : 'text-emerald-600' }} font-medium">Status Tagihan</div>
                            <div class="flex items-center mt-1">
                                <i class="fa-solid {{ $menunggak ? 'fa-triangle-exclamation text-rose-500' : 'fa-circle-check text-emerald-500' }} mr-1"></i>
                                <span class="text-xl font-bold {{ $menunggak ? 'text-rose-800' : 'text-emerald-800' }}">
                                    {{ $menunggak ? 'Menunggak' : 'Lunas' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Kontrak -->
                <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 hover:shadow-xl transition-shadow duration-300 p-5">
                    <h3 class="font-bold text-lg text-slate-800 mb-4 flex items-center">
                        <i class="fa-solid fa-file-contract text-indigo-600 mr-2"></i> Kontrak Anda
                    </h3>
                    @if ($user->kamar)
                        @php
                            $trx = $user->transaksi->sortByDesc('tanggal_pembayaran')->first();
                        @endphp
                        <ul class="space-y-3 text-sm">
                            <li class="flex justify-between border-b pb-2 border-slate-100">
                                <span class="text-slate-500">Tanggal Masuk</span>
                                <span class="font-medium text-slate-800">
                                    {{ $trx?->masuk_kamar?->format('d M Y') ?? '–' }}
                                </span>
                            </li>
                            <li class="flex justify-between border-b pb-2 border-slate-100">
                                <span class="text-slate-500">Durasi</span>
                                <span class="font-medium text-slate-800">
                                    {{ $trx?->durasi ?? '–' }} bulan
                                </span>
                            </li>
                            <li class="flex justify-between">
                                <span class="text-slate-500">Jatuh Tempo</span>
                                <span class="font-medium {{ $trx && $trx->tanggal_jatuhtempo < now() && $trx->status_pembayaran !== 'paid' ? 'text-rose-600' : 'text-slate-800' }}">
                                    {{ $trx?->tanggal_jatuhtempo?->translatedFormat('d F Y') ?? '–' }}
                                </span>
                            </li>
                        </ul>
                    @else
                        <p class="text-slate-500 italic">Belum ada kontrak aktif.</p>
                    @endif
                </div>
            </div>

            <!-- Alert Menunggak -->
            @if ($menunggak)
                <div class="mb-8 p-5 bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center gap-4 animate-fadeIn">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <div class="font-bold text-amber-800">Tagihan Anda Tertunggak!</div>
                        <div class="text-amber-700">Segera lakukan pembayaran untuk menghindari pemutusan layanan.</div>
                    </div>
                    <a href="{{ route('penghuni.pembayaran') }}"
                        class="px-5 py-2 bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white rounded-xl shadow transition-all duration-300 font-medium whitespace-nowrap">
                        Bayar Sekarang
                    </a>
                </div>
            @endif

            <!-- Tabel Transaksi -->
            <div class="bg-white rounded-2xl shadow-lg border border-indigo-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-indigo-100">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center">
                        <i class="fa-solid fa-receipt text-indigo-600 mr-2"></i> Riwayat Transaksi
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-indigo-50 text-indigo-700">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium">#</th>
                                <th class="px-6 py-3 text-left font-medium">Kode</th>
                                <th class="px-6 py-3 text-left font-medium">Tanggal Bayar</th>
                                <th class="px-6 py-3 text-left font-medium">Jatuh Tempo</th>
                                <th class="px-6 py-3 text-left font-medium">Metode</th>
                                <th class="px-6 py-3 text-left font-medium">Status</th>
                                <th class="px-6 py-3 text-right font-medium">Total</th>
                                <th class="px-6 py-3 text-left font-medium">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-indigo-50">
                            @forelse($transaksis as $trx)
                                <tr class="hover:bg-indigo-50 transition-colors duration-200">
                                    <td class="px-6 py-4">{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                                    <td class="px-6 py-4 font-mono text-indigo-700">{{ $trx->kode }}</td>
                                    <td class="px-6 py-4">{{ $trx->tanggal_pembayaran?->format('d M Y') ?? '–' }}</td>
                                    <td class="px-6 py-4">{{ $trx->tanggal_jatuhtempo?->format('d M Y') ?? '–' }}</td>
                                    <td class="px-6 py-4 capitalize">{{ $trx->metode_pembayaran ?? '–' }}</td>
                                    <td class="px-6 py-4">
                                        @switch($trx->status_pembayaran)
                                            @case('paid')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-100 text-teal-800 font-medium text-sm">
                                                    <i class="fa-solid fa-circle-check"></i> Lunas
                                                </span>
                                            @break

                                            @case('pending')
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-800 font-medium text-sm">
                                                    <i class="fa-solid fa-clock"></i> Menunggu
                                                </span>
                                            @break

                                            @default
                                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-800 font-medium text-sm">
                                                    <i class="fa-solid fa-circle-xmark"></i> {{ ucfirst($trx->status_pembayaran) }}
                                                </span>
                                        @endswitch
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-800">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <button x:cloak
                                            @click="detailModal = true; 
                                                detailData.kode = '{{ $trx->kode }}';
                                                detailData.total = 'Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}';
                                                detailData.metode = '{{ ucfirst($trx->metode_pembayaran ?? '–') }}';
                                                detailData.status = '{{ ucfirst($trx->status_pembayaran) }}';
                                                detailData.created_at = '{{ $trx->created_at->format('d M Y H:i') }}';"
                                            class="px-3.5 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                                            Detail
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-12 text-center text-slate-500">
                                            <i class="fa-regular fa-receipt text-2xl mb-2 text-slate-400"></i><br>
                                            Belum ada transaksi.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="px-6 py-4 border-t border-indigo-100">
                        {{ $transaksis->links() }}
                    </div>
                </div>
            </div>

            <!-- Modal: Hubungi Admin -->
            <div x-show="openContact" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" @click.outside="openContact = false" role="dialog" aria-modal="true">
                <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <h3 class="font-bold text-xl text-slate-800 mb-3">Hubungi Admin</h3>
                    <p class="text-slate-600 mb-4">Tim kami siap membantu Anda kapan saja!</p>
                    <ul class="space-y-3">
                        <li class="flex items-center">
                            <div class="w-9 h-9 rounded-full bg-indigo-100 flex items-center justify-center mr-3">
                                <i class="fa-solid fa-phone text-indigo-600"></i>
                            </div>
                            <span>+62 858-7032-7957</span>
                        </li>
                        <li class="flex items-center">
                            <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center mr-3">
                                <i class="fa-solid fa-envelope text-amber-600"></i>
                            </div>
                            <span>rumahkedua@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <a href="https://wa.me/6285870327957" target="_blank" rel="noopener noreferrer" class="flex items-center">
                                <div class="w-9 h-9 rounded-full bg-teal-100 flex items-center justify-center mr-3">
                                    <i class="fa-brands fa-whatsapp text-teal-600"></i>
                                </div>
                                <span>WhatsApp Resmi</span>
                            </a>
                        </li>
                    </ul>
                    <div class="mt-6 flex justify-end">
                        <button @click="openContact = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl font-medium transition-colors duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal: Detail Transaksi -->
            <div x-show="detailModal" x-cloak x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm" @click.outside="detailModal = false" role="dialog" aria-modal="true">
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-5">
                        <h3 class="font-bold text-xl text-slate-800">Detail Transaksi</h3>
                        <button @click="detailModal = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition-colors">
                            <i class="fa-solid fa-xmark text-slate-600"></i>
                        </button>
                    </div>

                    <div class="space-y-3.5 text-sm">
                        <div class="flex justify-between">
                            <span class="text-slate-600">Kode Transaksi</span>
                            <span x-text="detailData.kode" class="font-mono font-semibold text-indigo-700"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Total</span>
                            <span x-text="detailData.total" class="font-bold text-slate-800"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Metode</span>
                            <span x-text="detailData.metode" class="capitalize"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Status</span>
                            <span x-text="detailData.status" class="font-medium"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-600">Dibuat</span>
                            <span x-text="detailData.created_at" class="text-slate-800"></span>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button @click="detailModal = false" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl font-medium transition-colors duration-200">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <style>
                @keyframes fadeIn {
                    from {
                        opacity: 0;
                        transform: translateY(10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .animate-fadeIn {
                    animation: fadeIn 0.4s ease-out forwards;
                }
            </style>

            @vite('resources/js/app.js')
            <script>
                document.addEventListener('alpine:init', () => {
                    Alpine.data('page', () => ({
                        openContact: false,
                        detailModal: false,
                        detailData: {
                            kode: '',
                            total: '',
                            metode: '',
                            status: '',
                            created_at: '',
                        }
                    }))
                })
            </script>
        </div>
    @endsection
