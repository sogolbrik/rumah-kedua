<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kos.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'sogol',
            'email' => 'sogol@kos.com',
            'password' => bcrypt('sogol123'),
            'role' => 'user',
            // 'telepon'  => 6285601398636,
        ]);

        User::create([
            'id_kamar' => 2,
            'name' => 'Penghuni-2',
            'email' => 'penghuni2@kos.com',
            'password' => bcrypt('penghuni2123'),
            'role' => 'penghuni',
            // 'telepon' => null,
            'telepon' => 6287870327957,
            // 'telepon' => 6285601398636,
            // 'telepon' => 6285710786509,
            'tanggal_masuk' => date('Y-m-d'),
        ]);

        User::create([
            'id_kamar' => 1,
            'name' => 'Penghuni',
            'email' => 'penghuni@kos.com',
            'password' => bcrypt('penghuni123'),
            'role' => 'penghuni',
            'telepon' => 6287870327957,
            'tanggal_masuk' => date('Y-m-d'),
        ]);

        $names = ['Budi Santoso', 'Siti Nurhaliza', 'Andi Wijaya', 'Rina Marlina', 'Agus Prasetyo', 'Dewi Lestari', 'Hendra Gunawan', 'Maya Sari', 'Rizki Ramadhan', 'Putri Amelia'];
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $names[$i],
                'email' => strtolower(str_replace(' ', '', $names[$i])) . '@kos.com',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]);
        }
    }
}
