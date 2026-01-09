@extends('layouts.frontend-main')

@section('title', 'Invoice Pembayaran - RumahKedua')

@section('frontend-main')
    <div class="min-h-screen bg-slate-50/50 pb-12">
        <div class="bg-white border-b border-slate-200 mt-25 mb-8">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard-penghuni') }}" class="p-2 hover:bg-slate-100 rounded-full transition-colors">
                            <i class="fa-solid fa-arrow-left text-slate-600"></i>
                        </a>
                        <div>
                            <h1 class="text-2xl font-bold text-slate-900">Detail Invoice</h1>
                            <p class="text-sm text-slate-500 font-mono">{{ $transaksi->kode }}</p>
                        </div>
                    </div>

                    <div>
                        @php
                            $statusConfig = match ($transaksi->status_pembayaran) {
                                'paid' => ['bg-emerald-50 text-emerald-700 border-emerald-200', 'LUNAS', 'fa-check-circle'],
                                'pending' => ['bg-amber-50 text-amber-700 border-amber-200', 'PENDING', 'fa-clock'],
                                default => ['bg-slate-100 text-slate-700 border-slate-200', strtoupper($transaksi->status_pembayaran), 'fa-info-circle'],
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

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Informasi Hunian</h3>
                            <i class="fa-solid fa-house-user text-slate-400"></i>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Nama Penghuni</label>
                                    <p class="text-sm font-semibold text-slate-900">{{ $transaksi->user->name ?? '—' }}</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Kontak</label>
                                    <p class="text-sm text-slate-700">{{ $transaksi->user->email ?? '—' }}</p>
                                    <p class="text-xs text-slate-500">{{ $transaksi->user->telepon ?? '—' }}</p>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Detail Kamar</label>
                                    <p class="text-sm font-semibold text-slate-900">{{ $transaksi->kamar->kode_kamar }} ({{ $transaksi->kamar->tipe }})</p>
                                </div>
                                <div>
                                    <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Durasi Sewa</label>
                                    <p class="text-sm text-slate-700 font-medium">{{ $transaksi->durasi }} Bulan</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                            <h3 class="font-bold text-slate-800 italic uppercase tracking-wider text-sm">Rincian Pembayaran</h3>
                            <i class="fa-solid fa-receipt text-slate-400"></i>
                        </div>
                        <div class="p-6">
                            <table class="w-full text-sm text-left">
                                <thead class="text-[10px] font-bold text-slate-500 uppercase border-b border-slate-100">
                                    <tr>
                                        <th class="pb-3">Deskripsi</th>
                                        <th class="pb-3 text-right">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50">
                                    <tr>
                                        <td class="py-4 text-slate-700">Sewa Kamar {{ $transaksi->kamar->kode_kamar }} ({{ $transaksi->durasi }} bln)</td>
                                        <td class="py-4 text-right font-semibold text-slate-900">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="border-t-2 border-slate-100">
                                        <td class="pt-4 font-bold text-slate-900">TOTAL BAYAR</td>
                                        <td class="pt-4 text-right font-extrabold text-indigo-600 text-lg">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @if ($transaksi->midtrans_transaction_id)
                        <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-4 flex items-center gap-4">
                            <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-indigo-600 shadow-sm">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest leading-none">Midtrans Payment ID</p>
                                <p class="text-xs font-mono font-bold text-indigo-700 mt-1">{{ $transaksi->midtrans_transaction_id }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-4 space-y-6">

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 space-y-3">
                        <h3 class="px-2 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Opsi Invoice</h3>

                        <a href="{{ route('user.pembayaran.invoice.preview', $transaksi->id) }}" target="_blank"
                            class="flex items-center justify-between w-full px-4 py-3 bg-slate-900 hover:bg-slate-800 text-white rounded-xl transition-all group">
                            <span class="text-sm font-bold">Preview PDF</span>
                            <i class="fa-solid fa-eye text-slate-400 group-hover:text-white transition-colors"></i>
                        </a>

                        <a href="{{ route('user.pembayaran.invoice.pdf', $transaksi->id) }}"
                            class="flex items-center justify-between w-full px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all shadow-sm shadow-indigo-100 group">
                            <span class="text-sm font-bold">Download PDF</span>
                            <i class="fa-solid fa-download text-indigo-200 group-hover:text-white transition-colors"></i>
                        </a>

                        <div class="pt-2 border-t border-slate-100 mt-4">
                            <p class="text-[10px] text-center text-slate-400 font-medium">
                                Dicetak pada: {{ now()->translatedFormat('d M Y, H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-4 space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="mt-1 w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Tanggal Bayar</p>
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $transaksi->tanggal_pembayaran ? \Carbon\Carbon::parse($transaksi->tanggal_pembayaran)->translatedFormat('d F Y') : '—' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="mt-1 w-2 h-2 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Jatuh Tempo</p>
                                    <p class="text-sm font-bold text-slate-900">
                                        {{ $transaksi->tanggal_jatuhtempo ? \Carbon\Carbon::parse($transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') : '—' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="px-4 text-center">
                        <p class="text-[11px] text-slate-400 leading-relaxed italic">
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
