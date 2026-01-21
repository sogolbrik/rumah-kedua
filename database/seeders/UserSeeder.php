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
            'telepon' => 6287870327957,
            'role' => 'user',
        ]);

        User::create([
            'id_kamar' => 2,
            'name' => 'John Doe',
            'email' => 'john@kos.com',
            'password' => bcrypt('john123'),
            'role' => 'penghuni',
            'telepon' => 6287870327957,
            'tanggal_masuk' => date('Y-m-d'),
        ]);

        User::create([
            'id_kamar' => 1,
            'name' => 'Jane Doe',
            'email' => 'jane@kos.com',
            'password' => bcrypt('jane123'),
            'role' => 'penghuni',
            'telepon' => null,
            'tanggal_masuk' => date('Y-m-d'),
        ]);

        $nama = ['Budi Santoso', 'Siti Nurhaliza', 'Andi Wijaya', 'Rina Marlina', 'Agus Prasetyo', 'Dewi Lestari', 'Hendra Gunawan', 'Maya Sari', 'Rizki Ramadhan', 'Putri Amelia'];
        for ($i = 0; $i < 10; $i++) {
            User::create([
                'name' => $nama[$i],
                'email' => strtolower(str_replace(' ', '', $nama[$i])) . '@kos.com',
                'password' => bcrypt('user123'),
                'role' => 'user',
            ]);
        }
    }
}
