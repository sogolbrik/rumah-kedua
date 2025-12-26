<?php

namespace App\Jobs;

use App\Models\Transaksi;
use App\Services\FonnteService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessAutoBlock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;
    public $tries = 3;
    public $maxExceptions = 2;

    public function __construct(public Transaksi $transaksi)
    {
    }

    public function handle(FonnteService $fonnteService): void
    {
        $user = $this->transaksi->user;
        if (!$user || $user->role !== 'penghuni') {
            //Log::info("Transaksi {$this->transaksi->id}: bukan penghuni, lewati blokir.");
            return;
        }

        $kamar = $this->transaksi->kamar;
        if (!$kamar) {
            //Log::warning("Transaksi {$this->transaksi->id}: kamar tidak ditemukan.");
            return;
        }

        $number = $user->telepon;
        if (!$number) {
            //Log::warning("Penghuni {$user->id} tidak punya nomor telepon — blokir tetap dijalankan.");
        }

        $validNumber = null;
        if ($number) {
            if (str_starts_with($number, '08')) {
                $validNumber = '62' . substr($number, 2);
            } elseif (preg_match('/^628[0-9]{8,13}$/', $number)) {
                $validNumber = $number;
            } else {
                //Log::warning("Nomor tidak valid untuk WA: {$number}");
            }
        }

        $message = "🚫 *Akun Telah Diblokir*\n\n" .
            "Halo *{$user->name}*,\n\n" .
            "Karena tagihan *{$this->transaksi->kode}* belum dibayar selama *10 hari* sejak jatuh tempo, " .
            "akun Anda telah *diblokir secara otomatis* oleh sistem.\n\n" .
            "❗ Akses ke kamar *" . ($kamar->kode_kamar ?? $kamar->id) . "* telah *dicabut*.\n" .
            "❗ Status kamar dikembalikan ke *Tersedia*.\n\n" .
            "Jika ingin mengaktifkan kembali, silakan hubungi admin dan lakukan pembayaran.\n\n" .
            "Terima kasih,\n" .
            "*- RumahKedua*";

        if ($validNumber) {
            try {
                $response = $fonnteService->send($validNumber, $message);

                if (isset($response['status']) && in_array($response['status'], ['success', 'queued'])) {
                    //Log::info("✅ Notifikasi blokir WA sukses ke {$validNumber} (Transaksi: {$this->transaksi->kode})");
                } else {
                    //Log::error("❌ Gagal kirim WA blokir untuk {$this->transaksi->kode}: " . $response->body());
                }
            } catch (\Exception $e) {
                //Log::error("URLException saat kirim WA blokir: " . $e->getMessage());
            }
        }

        $user->update([
            'id_kamar' => null,
            'tanggal_masuk' => null,
            'role' => 'user',
        ]);

        $kamar->update(['status' => 'Tersedia']);

        $this->transaksi->update(['diblokir_pada' => now()]);

        //Log::info("🔒 Penghuni {$user->id} diblokir. Kamar {$kamar->id} dikosongkan. Notifikasi dikirim: " . ($validNumber ? 'YA' : 'TIDAK'));
    }
}
