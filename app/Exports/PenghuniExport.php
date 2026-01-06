<?php

namespace App\Exports;

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

class PenghuniExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithEvents,
    WithCustomStartCell
{
    protected $penghuni;
    protected $penghuniMenunggakData;

    public function __construct($penghuni, $penghuniMenunggakData)
    {
        $this->penghuni = $penghuni;
        $this->penghuniMenunggakData = $penghuniMenunggakData;
    }

    public function collection()
    {
        return $this->penghuni;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'Nama Penghuni',
            'Kode Kamar',
            'No. Telepon',
            'Email',
            'Tanggal Masuk',
            'Hari Tunggakan',
            'Status'
        ];
    }

    public function map($item): array
    {
        $hariTunggakan = $this->penghuniMenunggakData->get($item->id);

        return [
            $item->name ?? '—',
            $item->kamar?->kode_kamar ?? '—',
            $item->telepon ?? '—',
            $item->email ?? '—',
            $item->tanggal_masuk
            ? \Carbon\Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y')
            : '—',
            $hariTunggakan ? (int) $hariTunggakan : '—', // kirim sebagai angka (opsional untuk sort/filter)
            $hariTunggakan ? 'Menunggak' : 'Aktif'
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
                $dataCount = $this->penghuni->count();

                // === Judul Laporan ===
                $sheet->setCellValue('A1', 'Laporan Penghuni RumahKedua');
                $sheet->mergeCells('A1:G1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // === Informasi Tambahan: Jumlah Penghuni ===
                $sheet->setCellValue('A2', "Jumlah Penghuni: {$dataCount} orang");
                $sheet->mergeCells('A2:G2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font' => ['italic' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // === Lebar Kolom Otomatis (A–G) ===
                foreach (range('A', 'G') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

            },
        ];
    }
}