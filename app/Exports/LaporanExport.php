<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanExport implements FromArray, WithHeadings
{
    protected $data;
    protected $type;

    public function __construct($data, $type)
    {
        // Pastikan $data adalah collection atau array sebelum dipanggil toArray()
        $this->data = is_array($data) ? $data : $data->toArray();
        $this->type = $type;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return match ($this->type) {
            'penghuni' => ['ID', 'Nama', 'Email', 'Telepon', 'Kamar', 'Tanggal Masuk', 'Status'],
            'pembayaran' => ['ID', 'Invoice', 'Penghuni', 'Kamar', 'Tanggal Bayar', 'Jatuh Tempo', 'Total', 'Metode', 'Status'],
            'kamar' => ['ID', 'Kode', 'Harga', 'Tipe', 'Status', 'Penghuni'],
            default => ['Data'],
        };
    }
}