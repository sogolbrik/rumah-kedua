<?php

namespace App\Exports;

use App\Models\Kamar;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class KamarExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents,
    WithCustomStartCell
{
    protected $kamar;
    protected string $filterLabel;

    public function __construct($kamar, string $filterLabel)
    {
        $this->kamar = $kamar;
        $this->filterLabel = $filterLabel;
    }

    public function collection()
    {
        return $this->kamar;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Kode Kamar',
            'Harga',
            'Tipe',
            'Lebar (m²)',
            'Status',
        ];
    }

    public function map($kamar): array
    {
        $statusLabel = match (strtolower($kamar->status)) {
            'tersedia' => 'Tersedia',
            'terisi' => 'Terisi',
            default => 'Tidak Diketahui',
        };

        $harga = is_numeric($kamar->harga) ? (float) $kamar->harga : 0;

        return [
            $kamar->kode_kamar ?? '—',
            $harga, // angka mentah
            $kamar->tipe ?? '—',
            $kamar->lebar ?? '—',
            $statusLabel,
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
                $dataCount = $this->kamar->count();

                // === Judul Laporan ===
                $sheet->setCellValue('A1', 'Laporan Kamar RumahKedua');
                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // === Filter Label (menggantikan "Periode") ===
                $sheet->setCellValue('A2', "Filter: {$this->filterLabel}");
                $sheet->mergeCells('A2:E2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // === Lebar Kolom Otomatis ===
                foreach (range('A', 'E') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // === Format kolom Harga (kolom B) sebagai angka ===
                $startRow = 4;
                $endRow = $startRow + $dataCount - 1;

                if ($dataCount > 0) {
                    $sheet->getStyle("B{$startRow}:B{$endRow}")
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                }

                // === Baris Total (opsional: total nilai kamar) ===
                $totalRow = $endRow + 1;
                $sheet->setCellValue("A{$totalRow}", 'TOTAL NILAI KAMAR:');
                $sheet->setCellValue("B{$totalRow}", "=SUM(B{$startRow}:B{$endRow})");

                // Format baris total
                $sheet->getStyle("A{$totalRow}:B{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E0F2FE'],
                    ],
                ]);

                // Format angka total
                $sheet->getStyle("B{$totalRow}")
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            },
        ];
    }
}