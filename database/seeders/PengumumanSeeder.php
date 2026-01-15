<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengumumen')->insert([
            [
                'judul' => 'Pembayaran Bulanan Kos',
                'isi' => 'Diharapkan seluruh penghuni Kos Rumah Kedua melakukan pembayaran bulanan sebelum tanggal jatuh tempo. Keterlambatan pembayaran dapat mengganggu kenyamanan bersama.',
                'kategori' => 'Umum',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'highlight' => false,
            ],
            [
                'judul' => 'Peraturan Baru Kos',
                'isi' => 'Peraturan baru kos akan diberlakukan mulai bulan depan. Setiap penghuni wajib menandatangani perjanjian baru untuk menyesuaikan dengan sistem kos yang lebih tertib.',
                'kategori' => 'Penting',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'highlight' => true,
            ],
            [
                'judul' => 'Perawatan Air dan Listrik',
                'isi' => 'Akan dilakukan perawatan instalasi air dan listrik pada hari Minggu. Mohon pengertian seluruh penghuni karena kemungkinan terjadi gangguan sementara.',
                'kategori' => 'Perbaikan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'highlight' => false,
            ],
            [
                'judul' => 'Kebersihan Area Bersama',
                'isi' => 'Seluruh penghuni diharapkan menjaga kebersihan area bersama seperti dapur dan kamar mandi umum demi kenyamanan bersama.',
                'kategori' => 'Kegiatan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'highlight' => false,
            ],
        ]);
    }
}
