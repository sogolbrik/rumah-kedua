<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class TransaksiExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents,
    WithCustomStartCell
{
    protected $transaksi;
    protected string $periodeLabel;

    public function __construct($transaksi, string $periodeLabel)
    {
        $this->transaksi = $transaksi;
        $this->periodeLabel = $periodeLabel;
    }

    public function collection()
    {
        return $this->transaksi;
    }

    public function startCell(): string
    {
        return 'A3';
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
            'gopay' => 'GoPay',
            'credit_card' => 'Credit Card',
        ];

        $paymentMethod = $paymentTypeMap[$transaksi->midtrans_payment_type]
            ?? ucfirst($transaksi->metode_pembayaran);

        $statusMap = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'cancelled' => 'Dibatalkan',
            'expired' => 'Kadaluarsa',
            'challenge' => 'Dalam Verifikasi',
        ];

        Log::info('Export row', [
            'kode' => $transaksi->kode,
            'total_raw' => $transaksi->total_bayar,
            'total_cast' => (float) $transaksi->total_bayar,
            'type' => gettype($transaksi->total_bayar)
        ]);

        return [
            $transaksi->kode,
            optional($transaksi->created_at)->format('d M Y H:i'),
            optional($transaksi->user)->name,
            optional($transaksi->kamar)->kode_kamar,
            (float) $transaksi->total_bayar,
            $paymentMethod,
            $statusMap[$transaksi->status_pembayaran] ?? 'Tidak Diketahui',
        ];

    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'DBEAFE'],
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $dataCount = $this->transaksi->count();

                // === Judul & Periode (tetap sama) ===
                $sheet->setCellValue('A1', 'Laporan Transaksi RumahKedua');
                $sheet->mergeCells('A1:G1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                $sheet->setCellValue('A2', "Periode: {$this->periodeLabel}");
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // === Auto-width ===
                foreach (range('A', 'G') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // === Format kolom E dan tambah total ===
                $startRow = 4;
                $endRow = $startRow + $dataCount - 1;

                // Pastikan kolom E diformat sebagai angka (bahkan jika kosong)
                if ($dataCount > 0) {
                    $sheet->getStyle("E{$startRow}:E{$endRow}")
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }

                // Tambahkan baris TOTAL (selalu tampilkan, minimal tulisan)
                $totalRow = $endRow + 1;
                $sheet->setCellValue("D{$totalRow}", 'TOTAL PENDAPATAN');

                // Formula SUM hanya jika ada data
                if ($dataCount > 0) {
                    $sheet->setCellValue("E{$totalRow}", "=SUM(E{$startRow}:E{$endRow})");
                } else {
                    $sheet->setCellValue("E{$totalRow}", 0);
                }

                // Format baris total
                $sheet->getStyle("D{$totalRow}:E{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0F2FE'],
                    ],
                ]);

                // Format angka total
                $sheet->getStyle("E{$totalRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}
