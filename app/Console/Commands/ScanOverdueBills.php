<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Transaksi;
use App\Jobs\NotifyOverdueBill;
use App\Jobs\NotifyWarningBeforeBlock;
use App\Jobs\ProcessAutoBlock;

class ScanOverdueBills extends Command
{
    protected $signature = 'bill:scan-overdue';
    protected $description = 'Scan transaksi dengan tanggal_jatuhtempo lewat, kirim notifikasi (tanpa ubah data)';

    public function handle(): void
    {
        $now = now();

        // 1. Tagihan jatuh tempo (hari ke-0+): kirim notifikasi jatuh tempo
        $jatuhTempo = Transaksi::where('tanggal_jatuhtempo', '<', $now)
            ->whereNull('notifikasi_jatuh_tempo_terkirim_pada')
            ->whereNull('diblokir_pada')
            ->whereHas('user', fn($q) => $q->where('role', 'penghuni'))
            ->with('user')
            ->get();

        foreach ($jatuhTempo as $t) {
            NotifyOverdueBill::dispatch($t);
            $this->info("📩 Notif jatuh tempo: {$t->kode}");
        }

        // 2. Peringatan 3 hari sebelum blokir (hari ke-7 sejak jatuh tempo)
        // Blokir terjadi di hari ke-10 → peringatan di hari ke-7
        $peringatan = Transaksi::whereDate('tanggal_jatuhtempo', '<=', $now->copy()->subDays(7))
            ->whereDate('tanggal_jatuhtempo', '>', $now->copy()->subDays(8))
            ->whereNull('notifikasi_peringatan_blokir_terkirim_pada')
            ->whereNull('diblokir_pada')
            ->whereHas('user', fn($q) => $q->where('role', 'penghuni'))
            ->with('user')
            ->get();

        foreach ($peringatan as $t) {
            NotifyWarningBeforeBlock::dispatch($t);
            $this->info("⚠️ Notif peringatan blokir: {$t->kode}");
        }

        // 3. Proses blokir otomatis (hari ke-10 sejak jatuh tempo)
        $harusDiblokir = Transaksi::whereDate('tanggal_jatuhtempo', '<=', $now->copy()->subDays(10))
            ->whereNull('diblokir_pada')
            ->whereHas('user', fn($q) => $q->where('role', 'penghuni'))
            ->with(['user', 'kamar'])
            ->get();

        foreach ($harusDiblokir as $t) {
            ProcessAutoBlock::dispatch($t);
            $this->info("🔒 Blokir otomatis: {$t->kode}");
        }

        if ($jatuhTempo->isEmpty() && $peringatan->isEmpty() && $harusDiblokir->isEmpty()) {
            $this->info('✅ Tidak ada tindakan diperlukan.');
        }
    }
}
