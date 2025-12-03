<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $transaksi;

    public function __construct($transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function collection()
    {
        return $this->transaksi;
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'Penyewa',
            'Kamar',
            'Total Bayar',
            'Metode Pembayaran',
            'Status',
        ];
    }

    public function map($transaksi): array
    {
        $paymentTypeMap = [
            'bank_transfer' => 'Bank Transfer',
            'qris' => 'QRIS',
            'credit_card' => 'Credit Card',
        ];

        $paymentMethod = $paymentTypeMap[$transaksi->midtrans_payment_type] ?? 'Cash';

        $statusMap = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            'challenge' => 'Dalam Tantangan',
        ];

        $statusLabel = $statusMap[strtolower($transaksi->status_pembayaran)] ?? 'Tidak Diketahui';

        return [
            $transaksi->kode ?? '—',
            $transaksi->created_at?->format('d M Y H:i') ?? '—',
            $transaksi->user?->name ?? '—',
            $transaksi->kamar?->kode_kamar ?? '—',
            'Rp ' . number_format($transaksi->total_bayar, 0, ',', '.'),
            $paymentMethod,
            $statusLabel,
        ];
    }
}