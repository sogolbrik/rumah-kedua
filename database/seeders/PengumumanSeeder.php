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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Perawatan Air dan Listrik',
                'isi' => 'Akan dilakukan perawatan instalasi air dan listrik pada hari Minggu. Mohon pengertian seluruh penghuni karena kemungkinan terjadi gangguan sementara.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'judul' => 'Kebersihan Area Bersama',
                'isi' => 'Seluruh penghuni diharapkan menjaga kebersihan area bersama seperti dapur dan kamar mandi umum demi kenyamanan bersama.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
