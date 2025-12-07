@extends('layouts.frontend-main')

@section('title', 'Dashboard Penghuni - RumahKedua')

@section('frontend-main')
    <div x-data="{ openTab: 'overview' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">Halo, {{ auth()->user()->name }}!</h1>
            <p class="text-gray-600 mt-1">Kelola kamar dan pembayaran Anda dengan mudah.</p>
        </div>

        <!-- Alert Jatuh Tempo -->
        @if ($jatuhTempo)
            <div class="mb-8 p-4 bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 rounded-xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h3 class="font-semibold text-amber-800 flex items-center gap-2">
                        <i class="fas fa-exclamation-triangle"></i>
                        Tagihan Segera Jatuh Tempo!
                    </h3>
                    <p class="text-amber-700 mt-1 text-sm">
                        Tanggal jatuh tempo: <span class="font-medium">{{ \Carbon\Carbon::parse($jatuhTempo->tanggal_jatuhtempo)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    </p>
                </div>
                <button @click="$dispatch('open-payment-modal', { kode: '{{ $jatuhTempo->kode }}' })"
                    class="inline-flex items-center gap-2 bg-amber-600 hover:bg-amber-700 text-white px-4 py-2.5 rounded-lg font-medium transition shadow-md hover:shadow-lg">
                    <i class="fas fa-credit-card"></i>
                    Bayar Sekarang
                </button>
            </div>
        @endif

        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button @click="openTab = 'overview'" :class="{ 'border-blue-500 text-blue-600': openTab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700': openTab !== 'overview' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-home mr-2"></i>Info Kamar
                </button>
                <button @click="openTab = 'history'" :class="{ 'border-blue-500 text-blue-600': openTab === 'history', 'border-transparent text-gray-500 hover:text-gray-700': openTab !== 'history' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <i class="fas fa-history mr-2"></i>Riwayat Pembayaran
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div x-show="openTab === 'overview'" class="space-y-6">
            <!-- Kamar Info Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row gap-6">
                        <div class="md:w-1/3 flex justify-center">
                            <img src="{{ Storage::url($kamar->gambar) }}" alt="Kamar {{ $kamar->kode_kamar }}" class="w-full max-w-48 h-48 object-cover rounded-xl border border-gray-200 shadow-sm">
                        </div>
                        <div class="md:w-2/3 space-y-4">
                            <div>
                                <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">
                                    {{ $kamar->status }}
                                </span>
                                <h2 class="text-xl font-bold text-gray-900 mt-2">Kamar {{ $kamar->kode_kamar }}</h2>
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Tipe</p>
                                    <p class="font-medium">{{ $kamar->tipe }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Harga</p>
                                    <p class="font-medium">Rp {{ number_format($kamar->harga, 0, ',', '.') }}/bulan</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Ukuran</p>
                                    <p class="font-medium">{{ $kamar->lebar }} m²</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tanggal Masuk</p>
                                    <p class="font-medium">
                                        {{ auth()->user()->tanggal_masuk? \Carbon\Carbon::parse(auth()->user()->tanggal_masuk)->locale('id')->isoFormat('D MMMM YYYY'): '–' }}
                                    </p>
                                </div>
                            </div>

                            @if ($kamar->deskripsi)
                                <div>
                                    <p class="text-gray-700">{{ $kamar->deskripsi }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Riwayat Pembayaran -->
        <div x-show="openTab === 'history'">
            @if ($riwayat->count())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($riwayat as $transaksi)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="font-mono text-sm font-medium text-blue-600">{{ $transaksi->kode }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaksi->kamar->kode_kamar }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->locale('id')->isoFormat('D MMM YYYY') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $transaksi->durasi }} bulan
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusMap = [
                                                    'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-800'],
                                                    'paid' => ['label' => 'Lunas', 'color' => 'bg-green-100 text-green-800'],
                                                    'failed' => ['label' => 'Gagal', 'color' => 'bg-red-100 text-red-800'],
                                                    'expired' => ['label' => 'Kedaluwarsa', 'color' => 'bg-gray-100 text-gray-800'],
                                                ];
                                                $status = $statusMap[$transaksi->status_pembayaran] ?? ['label' => 'Unknown', 'color' => 'bg-gray-100 text-gray-800'];
                                            @endphp
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['color'] }}">
                                                {{ $status['label'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $riwayat->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-receipt text-gray-400 text-5xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900">Belum ada riwayat pembayaran</h3>
                    <p class="text-gray-500 mt-1">Tagihan pertama Anda akan muncul setelah konfirmasi kamar.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Payment Modal (Placeholder) -->
    <div x-data="{ showModal: false, invoiceKode: '' }" x-on:open-payment-modal.window="showModal = true; invoiceKode = $event.detail.kode" x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;"
        x-transition>
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showModal" class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="showModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-6 pt-6 pb-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pembayaran</h3>
                        <button @click="showModal = false" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="mt-4">
                        <p class="text-gray-700">
                            Anda akan membayar tagihan dengan kode:
                            <span class="font-mono font-bold text-blue-600">#kkasdoadoaso</span>
                        </p>
                        <p class="mt-2 text-sm text-gray-500">
                            Sistem akan mengarahkan Anda ke halaman pembayaran Midtrans.
                        </p>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 rounded-b-2xl">
                    <button @click="showModal = false" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        Batal
                    </button>
                    <form :action="`/pembayaran/${invoiceKode}`" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Lanjutkan ke Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                openTab: 'overview'
            }));
        });
    </script>
@endsection
