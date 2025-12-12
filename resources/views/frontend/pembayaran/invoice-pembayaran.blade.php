@extends('layouts.frontend-main')
@section('title', 'Invoice Pembayaran - RumahKedua')

@section('frontend-main')
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)" x-show="show" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" class="max-w-3xl mx-auto p-6 rounded-xl shadow-lg mt-25 mb-12 border border-indigo-100 bg-gradient-to-br from-indigo-50/30 to-teal-50/20">

        <!-- Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-indigo-100 text-indigo-600 mb-3">
                <i class="fas fa-file-invoice text-xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Invoice Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-1 flex items-center justify-center gap-1">
                <i class="fas fa-barcode text-xs"></i>
                Nomor: <span class="font-mono font-semibold">{{ $transaksi->kode }}</span>
            </p>
        </div>

        <!-- Status Badge -->
        <div class="flex justify-center mb-6">
            @php
                $statusConfig = match ($transaksi->status_pembayaran) {
                    'paid' => ['bg-green-100 text-green-800', 'Lunas', 'fa-check-circle'],
                    'pending' => ['bg-yellow-100 text-yellow-800', 'Menunggu Pembayaran', 'fa-clock'],
                    'failed' => ['bg-red-100 text-red-800', 'Gagal', 'fa-times-circle'],
                    'cancelled' => ['bg-red-100 text-red-800', 'Dibatalkan', 'fa-ban'],
                    'expired' => ['bg-orange-100 text-orange-800', 'Kadaluarsa', 'fa-hourglass-end'],
                    'challenge' => ['bg-purple-100 text-purple-800', 'Dalam Tantangan', 'fa-question-circle'],
                    default => ['bg-gray-100 text-gray-800', ucfirst($transaksi->status_pembayaran), 'fa-info-circle'],
                };
                [$statusColor, $statusLabel, $statusIcon] = $statusConfig;
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-medium {{ $statusColor }} flex items-center gap-2">
                <i class="fas {{ $statusIcon }}"></i>
                {{ $statusLabel }}
            </span>
        </div>

        <!-- Info Penghuni & Kamar -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Penghuni -->
            <div class="bg-white/80 backdrop-blur-sm p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-user text-indigo-600"></i>
                    <h3 class="font-semibold text-gray-700 text-sm">Penghuni</h3>
                </div>
                <p class="text-gray-900 font-medium">{{ $transaksi->user->name ?? '—' }}</p>
                <p class="text-gray-600 text-sm flex items-center gap-1 mt-1">
                    <i class="fas fa-envelope text-xs"></i> {{ $transaksi->user->email ?? '—' }}
                </p>
                <p class="text-gray-600 text-sm flex items-center gap-1 mt-1">
                    <i class="fas fa-phone text-xs"></i> {{ $transaksi->user->telepon ?? '—' }}
                </p>
            </div>

            <!-- Kamar -->
            <div class="bg-white/80 backdrop-blur-sm p-4 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fas fa-door-open text-teal-600"></i>
                    <h3 class="font-semibold text-gray-700 text-sm">Detail Kamar</h3>
                </div>
                <p class="text-gray-900"><span class="font-medium">Kode:</span> {{ $transaksi->kamar->kode_kamar }}</p>
                <p class="text-gray-700 text-sm mt-1"><span class="font-medium">Tipe:</span> {{ $transaksi->kamar->tipe }}</p>
                <p class="text-gray-700 text-sm mt-1"><span class="font-medium">Durasi:</span> {{ $transaksi->durasi }} bulan</p>
            </div>
        </div>

        <!-- Tanggal & Pembayaran -->
        <div class="grid grid-cols-2 gap-4 mb-8 text-sm bg-white/80 backdrop-blur-sm p-4 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex flex-col">
                <span class="text-gray-500 flex items-center gap-1"><i class="far fa-calendar-check"></i> Tanggal Bayar</span>
                <span class="font-medium mt-1">{{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-gray-500 flex items-center gap-1"><i class="far fa-calendar-times"></i> Jatuh Tempo</span>
                <span class="font-medium mt-1">{{ $transaksi->tanggal_jatuhtempo ? \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') : '—' }}</span>
            </div>
            <div class="flex flex-col">
                <span class="text-gray-500 flex items-center gap-1"><i class="fas fa-money-bill-wave"></i> Metode</span>
                <span class="font-medium mt-1 capitalize">
                    @if ($transaksi->metode_pembayaran === 'midtrans')
                        Midtrans ({{ $transaksi->midtrans_payment_type ?? '—' }})
                    @else
                        Cash
                    @endif
                </span>
            </div>
            <div class="flex flex-col">
                <span class="text-gray-500 flex items-center gap-1"><i class="fas fa-tag"></i> Total Bayar</span>
                <span class="font-bold text-lg text-gray-900 mt-1">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Catatan Tambahan (Midtrans) -->
        @if ($transaksi->midtrans_transaction_id)
            <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-4 mb-6 text-sm flex items-start gap-2">
                <i class="fas fa-receipt text-indigo-600 mt-0.5"></i>
                <div>
                    <p class="font-medium text-indigo-800 mb-1">ID Transaksi Midtrans</p>
                    <p class="text-indigo-700 font-mono text-xs">{{ $transaksi->midtrans_transaction_id }}</p>
                </div>
            </div>
        @endif

        <!-- Tombol Aksi -->
        <div class="flex justify-center gap-3 mt-6">
            <button
                class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-all duration-200 transform hover:scale-[1.02] shadow-md flex items-center gap-2">
                <i class="fas fa-print"></i> Simpan PDF
            </button>
            <a href="{{ route('dashboard-penghuni') }}" class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- Footer kecil -->
        <div class="text-center text-xs text-gray-500 mt-10 pt-4 border-t border-gray-200">
            <i class="fas fa-robot text-xs text-indigo-500"></i>
            Invoice ini dibuat secara otomatis oleh sistem RumahKedua • {{ now()->translatedFormat('d F Y H:i') }}
        </div>
    </div>

@endsection
