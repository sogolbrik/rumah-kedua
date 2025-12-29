<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SetupStorageKamar extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-storage-kamar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Menyiapkan storage kamar...');

        // Pastikan symbolic link ada
        if (!file_exists(public_path('storage'))) {
            $this->call('storage:link');
        }

        // Folder tujuan
        $targetDir = 'kamar';

        // Folder sumber dummy
        $sourcePath = public_path('assets/image/dummy');

        // Daftar file dummy
        $files = [
            'exclusive.jpg',
            'medium.jpg',
            'standard.jpg',
        ];

        // Buat folder kamar jika belum ada
        Storage::disk('public')->makeDirectory($targetDir);

        foreach ($files as $file) {
            $sourceFile = $sourcePath . '/' . $file;
            $targetFile = $targetDir . '/' . $file;

            if (!File::exists($sourceFile)) {
                $this->warn("File {$file} tidak ditemukan, dilewati.");
                continue;
            }

            // Jangan overwrite jika sudah ada
            if (Storage::disk('public')->exists($targetFile)) {
                $this->line("{$file} sudah ada, dilewati.");
                continue;
            }

            Storage::disk('public')->put(
                $targetFile,
                File::get($sourceFile)
            );

            $this->info("{$file} berhasil disalin.");
        }

        $this->info('Setup storage kamar selesai.');
    }
}
