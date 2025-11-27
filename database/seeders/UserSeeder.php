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
            'name'     => 'Admin',
            'email'    => 'admin@kos.com',
            'password' => bcrypt('admin123'),
            'role'     => 'admin',
        ]);

        User::create([
        'id_kamar'            => 2,
            'name'            => 'rahmat',
            'email'           => 'rahmat@kos.com',
            'password'        => bcrypt('rahmat123'),
            'role'            => 'penghuni',
            'status_penghuni' => 'aktif',
            'telepon'         => 6285710786509,
            'tanggal_masuk'   => date('Y-m-d'),
        ]);

        for ($i=1; $i < 11; $i++) { 
            User::create([
                'name'     => 'User' . $i,
                'email'    => 'user'. $i .'@kos.com',
                'password' => bcrypt('user123'),
                'role'     => 'user',
            ]);
        }

        User::create([
            'id_kamar'        => 1,
            'name'            => 'Penghuni',
            'email'           => 'penghuni@kos.com',
            'password'        => bcrypt('penghuni123'),
            'role'            => 'penghuni',
            'status_penghuni' => 'aktif',
            'telepon'         => 6281528284601,
            'tanggal_masuk'   => date('Y-m-d'),
        ]);
    }
}
