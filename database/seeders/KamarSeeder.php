<?php

namespace Database\Seeders;

use App\Models\DetailKamar;
use App\Models\Kamar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KamarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kamars = [
            // Standard Rooms
            [
                'kode_kamar' => 'A-101',
                'harga' => 1500000,
                'tipe' => 'Standard',
                'lebar' => 12.5,
                'deskripsi' => 'Kamar Standard nyaman dengan luas 12.5m², cocok untuk penghuni tunggal dengan fasilitas lengkap untuk kebutuhan sehari-hari.',
                'gambar' => 'kamar/standard.jpg',
                'status' => 'Terisi'
            ],
            [
                'kode_kamar' => 'A-102',
                'harga' => 1450000,
                'tipe' => 'Standard',
                'lebar' => 12.0,
                'deskripsi' => 'Kamar Standard dengan desain minimalis, luas 12m² dilengkapi dengan fasilitas standar yang memadai.',
                'gambar' => 'kamar/standard.jpg',
                'status' => 'Terisi'
            ],
            [
                'kode_kamar' => 'A-103',
                'harga' => 1550000,
                'tipe' => 'Standard',
                'lebar' => 13.0,
                'deskripsi' => 'Kamar Standard luas 13m² dengan ventilasi yang baik, cocok untuk kenyamanan maksimal.',
                'gambar' => 'kamar/standard.jpg',
                'status' => 'Tersedia'
            ],

            // Medium Rooms
            [
                'kode_kamar' => 'B-201',
                'harga' => 2200000,
                'tipe' => 'Medium',
                'lebar' => 18.0,
                'deskripsi' => 'Kamar Medium dengan luas 18m², dilengkapi fasilitas tambahan untuk kenyamanan lebih.',
                'gambar' => 'kamar/medium.jpg',
                'status' => 'Tersedia'
            ],
            [
                'kode_kamar' => 'B-202',
                'harga' => 2300000,
                'tipe' => 'Medium',
                'lebar' => 19.5,
                'deskripsi' => 'Kamar Medium nyaman dengan luas 19.5m², memiliki ruang yang lebih luas dan fasilitas lengkap.',
                'gambar' => 'kamar/medium.jpg',
                'status' => 'Tersedia'
            ],
            [
                'kode_kamar' => 'B-203',
                'harga' => 2100000,
                'tipe' => 'Medium',
                'lebar' => 17.5,
                'deskripsi' => 'Kamar Medium dengan desain modern, luas 17.5m² cocok untuk profesional muda.',
                'gambar' => 'kamar/medium.jpg',
                'status' => 'Tersedia'
            ],
            [
                'kode_kamar' => 'B-204',
                'harga' => 2400000,
                'tipe' => 'Medium',
                'lebar' => 20.0,
                'deskripsi' => 'Kamar Medium premium dengan luas 20m², view yang bagus dan fasilitas terbaik di kelasnya.',
                'gambar' => 'kamar/medium.jpg',
                'status' => 'Tersedia'
            ],

            // Exclusive Rooms
            [
                'kode_kamar' => 'C-301',
                'harga' => 3500000,
                'tipe' => 'Exclusive',
                'lebar' => 25.0,
                'deskripsi' => 'Kamar Exclusive mewah dengan luas 25m², dilengkapi dengan fasilitas premium dan furniture berkualitas tinggi.',
                'gambar' => 'kamar/exclusive.jpg',
                'status' => 'Tersedia'
            ],
            [
                'kode_kamar' => 'C-302',
                'harga' => 3800000,
                'tipe' => 'Exclusive',
                'lebar' => 28.0,
                'deskripsi' => 'Kamar Exclusive suite dengan luas 28m², memiliki ruang living area terpisah dan kamar mandi mewah.',
                'gambar' => 'kamar/exclusive.jpg',
                'status' => 'Tersedia'
            ],
            [
                'kode_kamar' => 'C-303',
                'harga' => 3200000,
                'tipe' => 'Exclusive',
                'lebar' => 24.0,
                'deskripsi' => 'Kamar Exclusive dengan desain elegan, luas 24m² menawarkan kenyamanan maksimal dengan privacy terjamin.',
                'gambar' => 'kamar/exclusive.jpg',
                'status' => 'Tersedia'
            ],
        ];

        // Fasilitas berdasarkan tipe
        $fasilitasByTipe = [
            'Standard' => [
                'Kasur & Bantal',
                'Lemari',
                'Meja dan Kursi',
                'K. Mandi Dalam',
                'Kaca',
                'WI-FI',
                'Tempat Sampah',
                'Listrik',
                'Jendela dan Tirai',
                'Stopkontak'
            ],
            'Medium' => [
                'Kasur & Bantal',
                'Lemari',
                'Meja dan Kursi',
                'K. Mandi Dalam',
                'Kaca',
                'TV',
                'WI-FI',
                'Tempat Sampah',
                'Listrik',
                'Jendela dan Tirai',
                'Stopkontak',
                'Rak Sepatu',
                'Kipas Angin'
            ],
            'Exclusive' => [
                'Kasur & Bantal',
                'Lemari',
                'Meja dan Kursi',
                'K. Mandi Dalam',
                'Kaca',
                'TV',
                'Dapur Pribadi',
                'WI-FI',
                'Tempat Sampah',
                'Listrik',
                'Jendela dan Tirai',
                'Stopkontak',
                'Rak Sepatu',
                'AC'
            ]
        ];

        foreach ($kamars as $kamarData) {
            // Create kamar
            $kamar = Kamar::create($kamarData);

            // Create detail fasilitas
            $fasilitas = $fasilitasByTipe[$kamarData['tipe']];

            $detailKamarData = [];
            foreach ($fasilitas as $fasilitasItem) {
                $detailKamarData[] = [
                    'id_kamar' => $kamar->id,
                    'fasilitas' => $fasilitasItem,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DetailKamar::insert($detailKamarData);
        }
    }
}
