@extends('layouts.frontend-main')

@section('title', 'Invoice Pembayaran - RumahKedua')

@section('frontend-main')
    <div class="min-h-screen pt-28 pb-20 relative bg-[#fffffe]">
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#3da9fc]/10 rounded-full blur-[120px] -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#90b4ce]/10 rounded-full blur-[100px] -ml-24 -mb-24"></div>
        </div>

        <div class="bg-white border-b border-[#90b4ce]/30 mt-0 mb-8">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-[#90b4ce]/10 rounded-full transition-colors">
                            <i class="fa-solid fa-arrow-left text-[#094067]"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-[#094067]">Detail Invoice</h1>
                            <p class="text-sm text-[#5f6c7b] font-mono">{{ $transaksi->kode }}</p>
                        </div>
                    </div>

                    <div>
                        @php
                            $statusConfig = match ($transaksi->status_pembayaran) {
                                'paid' => ['bg-[#3da9fc]/10 text-[#3da9fc] border-[#3da9fc]/20', 'LUNAS', 'fa-check-circle'],
                                'pending' => ['bg-[#ef4565]/10 text-[#ef4565] border-[#ef4565]/20', 'PENDING', 'fa-clock'],
                                default => ['bg-[#90b4ce]/10 text-[#5f6c7b] border-[#90b4ce]/20', strtoupper($transaksi->status_pembayaran), 'fa-info-circle'],
                            };
                            [$statusClass, $statusLabel, $statusIcon] = $statusConfig;
                        @endphp
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                            <i class="fa-solid {{ $statusIcon }}"></i>
                            {{ $statusLabel }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-2xl border border-[#90b4ce]/20 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#90b4ce]/10 flex justify-between items-center bg-[#90b4ce]/5">
                            <h3 class="font-bold text-[#094067] italic uppercase tracking-wider text-sm">Informasi Hunian</h3>
                            <i class="fa-solid fa-house-user text-[#90b4ce]"></i>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Nama Penghuni</label>
                                    <p class="text-sm font-semibold text-[#094067]">{{ $transaksi->user->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Kontak</label>
                                    <p class="text-sm text-[#5f6c7b]">{{ $transaksi->user->email ?? '—' }}</p>
                                    <p class="text-xs text-[#5f6c7b]/70">{{ $transaksi->user->telepon ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Detail Kamar</label>
                                    <p class="text-sm font-semibold text-[#094067]">{{ $transaksi->kamar->kode_kamar }} ({{ $transaksi->kamar->tipe }})</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Durasi Sewa</label>
                                    <p class="text-sm text-[#5f6c7b] font-medium">{{ $transaksi->durasi }} Bulan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-[#90b4ce]/20 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-[#90b4ce]/10 flex justify-between items-center bg-[#90b4ce]/5">
                            <h3 class="font-bold text-[#094067] italic uppercase tracking-wider text-sm">Rincian Pembayaran</h3>
                            <i class="fa-solid fa-receipt text-[#90b4ce]"></i>
                        </div>
                        <div class="p-6">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] font-bold text-[#90b4ce] uppercase border-b border-[#90b4ce]/10">
                                    <tr>
                                        <th class="pb-3">Deskripsi</th>
                                        <th class="pb-3 text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#90b4ce]/5">
                                    <tr>
                                        <td class="py-4 text-[#5f6c7b]">Sewa Kamar {{ $transaksi->kamar->kode_kamar }} ({{ $transaksi->durasi }} bln)</td>
                                        <td class="py-4 text-right font-semibold text-[#094067]">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-[#90b4ce]/10">
                                        <td class="pt-4 font-bold text-[#094067]">TOTAL BAYAR</td>
                                        <td class="pt-4 text-right font-extrabold text-[#3da9fc] text-lg">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if ($transaksi->midtrans_transaction_id)
                        <div class="bg-[#3da9fc]/5 border border-[#3da9fc]/10 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-[#3da9fc] shadow-sm border border-[#3da9fc]/10">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest leading-none">Midtrans Payment ID</p>
                                <p class="text-xs font-mono font-bold text-[#094067] mt-1">{{ $transaksi->midtrans_transaction_id }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-4 space-y-6">
                    <div class="bg-white rounded-2xl border border-[#90b4ce]/20 shadow-sm p-4 space-y-3">
                        <h3 class="px-2 text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest mb-4">Opsi Invoice</h3>

                        <a href="{{ route('user.pembayaran.invoice.preview', $transaksi->id) }}" target="_blank"
                            class="flex items-center justify-between w-full px-4 py-3 bg-[#094067] hover:opacity-90 text-[#fffffe] rounded-xl transition-all group">
                            <span class="text-sm font-bold">Preview PDF</span>
                            <i class="fa-solid fa-eye text-[#90b4ce] group-hover:text-[#fffffe] transition-colors"></i>
                        </a>

                        <a href="{{ route('user.pembayaran.invoice.pdf', $transaksi->id) }}"
                            class="flex items-center justify-between w-full px-4 py-3 bg-[#3da9fc] hover:opacity-90 text-[#fffffe] rounded-xl transition-all shadow-sm group">
                            <span class="text-sm font-bold">Download PDF</span>
                            <i class="fa-solid fa-download text-[#fffffe]/70 group-hover:text-[#fffffe] transition-colors"></i>
                        </a>

                        <div class="pt-2 border-t border-[#90b4ce]/10 mt-4">
                            <p class="text-[10px] text-center text-[#90b4ce] font-medium">
                                Dicetak pada: {{ now()->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-[#90b4ce]/20 shadow-sm overflow-hidden">
                        <div class="p-4 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-1 w-2 h-2 rounded-full bg-[#3da9fc] shadow-[0_0_8px_rgba(61,169,252,0.5)]"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Tanggal Bayar</p>
                                    <p class="text-sm font-bold text-[#094067]">
                                        {{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="mt-1 w-2 h-2 rounded-full bg-[#ef4565] shadow-[0_0_8px_rgba(239,69,101,0.5)]"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-[#90b4ce] uppercase tracking-widest">Jatuh Tempo</p>
                                    <p class="text-sm font-bold text-[#094067]">
                                        {{ $transaksi->tanggal_jatuhtempo ? \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') : '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 text-center">
                        <p class="text-[11px] text-[#90b4ce] leading-relaxed italic">
                            "Invoice ini adalah bukti pembayaran yang sah dan dihasilkan otomatis oleh sistem RumahKedua."
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
@endsection
