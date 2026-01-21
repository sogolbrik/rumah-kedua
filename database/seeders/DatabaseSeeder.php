<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TransaksiSeeder::class,
            UserSeeder::class,
            KamarSeeder::class,
            PengaturanSistemSeeder::class,
            PengumumanSeeder::class,
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin credentials: admin@kos.com / admin123');
        $this->command->info('Penghuni credentials: john@kos.com / john123');
        $this->command->info('User credentials: sogol@kos.com / sogol123');
    }
}
