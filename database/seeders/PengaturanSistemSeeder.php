<?php

namespace Database\Seeders;

use App\Models\PengaturanSistem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PengaturanSistemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PengaturanSistem::create([
            'nama_kos'   => 'RumahKedua',
            'no_telepon' => '6285704229619',
            'alamat_kos' => 'Jl. Raya Kutorejo No. 45, Kutorejo, Mojokerto, Jawa Timur 61383',
            'email'      => 'rumahkedua@gmail.com',
            'deskripsi'  => 'Temukan kenyamanan seperti di rumah sendiri dengan layanan terbaik dan fasilitas lengkap.',
        ]);
    }
}
