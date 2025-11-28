@extends('layouts.admin-main')

@section('title', 'Pembayaran Transaksi')

@section('admin-main')
    <div class="min-h-screen w-full bg-gradient-to-br from-slate-50 to-slate-100/50 pt-0 pb-8">
        <div class="w-full">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Pembayaran Transaksi</h1>
                    <p class="mt-1 text-sm text-slate-600">Selesaikan pembayaran untuk melanjutkan proses sewa</p>
                </div>
                <a href="{{ route('transaksi.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm ring-1 ring-slate-200 transition-all hover:bg-slate-50 hover:shadow">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali
                </a>
            </div>

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50/50 p-4">
                    <div class="flex items-center gap-2 text-emerald-800">
                        <i class="fa-solid fa-circle-check"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-rose-200 bg-rose-50/50 p-4">
                    <div class="flex items-center gap-2 text-rose-800">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Informasi Transaksi -->
                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-lg">
                                    <i class="fa-solid fa-receipt"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Detail Transaksi</h2>
                                    <p class="text-sm text-slate-600">Informasi lengkap transaksi yang perlu dibayar</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-6">
                                <!-- Status & Kode -->
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-sm font-medium text-slate-600">Status Pembayaran</p>
                                        <div class="mt-2">
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-800 border border-yellow-200">
                                                <i class="fa-solid fa-clock text-xs"></i>
                                                Menunggu Pembayaran
                                            </span>
                                        </div>
                                    </div>
                                    <div class="rounded-xl bg-slate-50 p-4">
                                        <p class="text-sm font-medium text-slate-600">Kode Transaksi</p>
                                        <p class="mt-2 text-lg font-bold text-slate-900">{{ $transaksi->kode }}</p>
                                        @if ($transaksi->midtrans_order_id)
                                            <p class="mt-1 text-xs text-slate-500">Order ID: {{ $transaksi->midtrans_order_id }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Informasi Pelanggan & Kamar -->
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                                                <i class="fa-solid fa-user"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-900">Informasi Pelanggan</h3>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-slate-600">Nama:</span>
                                                <span class="text-sm font-medium text-slate-900">{{ $transaksi->user->name }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-slate-600">Email:</span>
                                                <span class="text-sm font-medium text-slate-900">{{ $transaksi->user->email }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="rounded-xl border border-slate-200 p-4">
                                        <div class="flex items-center gap-3 mb-3">
                                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-cyan-100 text-cyan-600">
                                                <i class="fa-solid fa-door-closed"></i>
                                            </div>
                                            <h3 class="font-semibold text-slate-900">Informasi Kamar</h3>
                                        </div>
                                        <div class="space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-sm text-slate-600">Kamar:</span>
                                                <span class="text-sm font-medium text-slate-900">{{ $transaksi->kamar->kode_kamar }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-sm text-slate-600">Tipe:</span>
                                                <span class="text-sm font-medium text-slate-900">{{ $transaksi->kamar->tipe }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Waktu -->
                                <div class="rounded-xl border border-amber-200 bg-amber-50/50 p-4">
                                    <div class="flex items-center gap-3 mb-3">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                                            <i class="fa-solid fa-clock"></i>
                                        </div>
                                        <h3 class="font-semibold text-amber-900">Batas Waktu Pembayaran</h3>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-sm text-amber-700">
                                            Selesaikan pembayaran sebelum:
                                        </p>
                                        <p class="text-lg font-bold text-amber-900">
                                            {{ $transaksi->expired_at->format('d M Y H:i') }}
                                        </p>
                                    </div>
                                    <div class="mt-2">
                                        <div class="h-2 w-full bg-amber-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-amber-500 rounded-full animate-pulse" style="width: 80%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Pembayaran -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-slate-200">
                        <div class="border-b border-slate-200 bg-gradient-to-r from-emerald-50 to-green-50 px-6 py-5">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-600 text-white shadow-lg">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Ringkasan Pembayaran</h2>
                                    <p class="text-sm text-slate-600">Total yang perlu dibayarkan</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-4">
                                <!-- Total Bayar -->
                                <div class="rounded-xl bg-gradient-to-r from-emerald-500 to-green-500 p-4 text-white">
                                    <p class="text-sm font-medium opacity-90">Total Bayar</p>
                                    <p class="text-2xl font-bold">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
                                </div>

                                <!-- Detail Biaya -->
                                <div class="space-y-3">
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-600">Harga Kamar/bulan:</span>
                                        <span class="font-medium text-slate-900">Rp {{ number_format($transaksi->kamar->harga, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-600">Durasi:</span>
                                        <span class="font-medium text-slate-900">{{ $transaksi->durasi }}</span>
                                    </div>
                                    <div class="flex justify-between text-sm">
                                        <span class="text-slate-600">Metode:</span>
                                        <span class="font-medium text-slate-900 capitalize">{{ $transaksi->metode_pembayaran }}</span>
                                    </div>
                                </div>

                                <!-- Container Snap -->
                                <div id="snap-container" class="mt-6">
                                    @if ($transaksi->metode_pembayaran === 'midtrans' && isset($transaksi->midtrans_response['snap_token']))
                                        <button id="pay-button"
                                            class="w-full rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 py-3.5 text-sm font-semibold text-white shadow-lg shadow-blue-500/30 transition-all hover:shadow-xl hover:shadow-blue-500/40 focus:outline-none focus:ring-4 focus:ring-blue-500/20">
                                            <i class="fa-solid fa-lock mr-2"></i>
                                            Bayar Sekarang
                                        </button>
                                    @else
                                        <div class="rounded-xl bg-slate-100 p-4 text-center">
                                            <i class="fa-solid fa-info-circle text-slate-400 text-lg mb-2"></i>
                                            <p class="text-sm text-slate-600">Metode pembayaran tidak tersedia</p>
                                        </div>
                                    @endif
                                </div>

                                <!-- Informasi Keamanan -->
                                <div class="rounded-xl bg-slate-50 p-4 border border-slate-200">
                                    <div class="flex items-center gap-2 text-sm text-slate-600">
                                        <i class="fa-solid fa-shield-check text-emerald-500"></i>
                                        <span>Transaksi aman dan terenkripsi</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($transaksi->metode_pembayaran === 'midtrans' && !empty($transaksi->midtrans_response['snap_token']))
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const payButton = document.getElementById('pay-button');
                const snapToken = '{{ $transaksi->midtrans_response['snap_token'] }}';

                if (payButton && snapToken) {
                    payButton.addEventListener('click', function() {
                        const originalText = payButton.innerHTML;
                        payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memuat Pembayaran...';
                        payButton.disabled = true;

                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                // Cukup redirect — notifikasi akan muncul via session di halaman tujuan
                                window.location.href = "/payment/check?orderId={{ $transaksi->midtrans_order_id }}";
                            },
                            onPending: function(result) {
                                // Redirect ke daftar transaksi — di sana bisa tampilkan status pending via session jika perlu
                                window.location.href = '{{ route('transaksi.index') }}';
                            },
                            onError: function(result) {
                                // Opsional: bisa redirect ke check juga, atau langsung ke index
                                window.location.href = "/payment/check?orderId={{ $transaksi->midtrans_order_id }}";
                            },
                            onClose: function() {
                                // Kembali ke halaman transaksi (tanpa notifikasi khusus, karena dibatalkan)
                                window.location.href = '{{ route('transaksi.index') }}';
                            }
                        });
                    });
                }
            });
        </script>
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                fetch(`/payment/check?orderId={{ $transaksi->midtrans_order_id }}`);
            });
        </script>
    @endif
@endsection
