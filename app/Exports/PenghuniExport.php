<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class PenghuniExport implements FromCollection, WithHeadings, WithMapping
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
            ? Carbon::parse($item->tanggal_masuk)->translatedFormat('d F Y')
            : '—',
            $hariTunggakan ? "{$hariTunggakan} hari" : '—',
            $hariTunggakan ? 'Menunggak' : 'Aktif'
        ];
    }
}
