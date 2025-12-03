<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KamarExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kamar;

    public function __construct($kamar)
    {
        $this->kamar = $kamar;
    }

    public function collection()
    {
        return $this->kamar;
    }

    public function headings(): array
    {
        return [
            'kode_kamar',
            'harga',
            'tipe',
            'lebar',
            'status',
        ];
    }

    public function map($kamar): array
    {
        $statusLabel = $kamar->status === 'tersedia' ? 'Tersedia' : 'Terisi';

        return [
            $kamar->kode_kamar ?? '—',
            'Rp ' . number_format($kamar->harga, 0, ',', '.'),
            $kamar->tipe ?? '—',
            $kamar->lebar ?? '—',
            $statusLabel,
        ];
    }
}