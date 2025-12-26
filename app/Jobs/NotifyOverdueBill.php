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

class NotifyOverdueBill implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;
    public $tries = 3;
    public $maxExceptions = 2;

    protected Transaksi $transaksi;

    public function __construct(Transaksi $transaksi)
    {
        $this->transaksi = $transaksi;
    }

    public function handle(FonnteService $fonnteService): void
    {
        try {
            $user = $this->transaksi->user;
            if (!$user || $user->role !== 'penghuni') {
                //Log::info("Transaksi ID {$this->transaksi->id} tidak terkait penghuni.");
                return;
            }

            $number = $user->telepon;
            if (!$number) {
                //Log::warning("Penghuni ID {$user->id} tidak punya nomor telepon.");
                return;
            }

            if (str_starts_with($number, '08')) {
                $number = '62' . substr($number, 2);
            } elseif (!preg_match('/^628[0-9]{8,13}$/', $number)) {
                //Log::warning("Nomor tidak valid untuk WA: {$number}");
                return;
            }

            $message = "⚠️ *Tagihan Jatuh Tempo*\n\n" .
                "Halo *{$user->name}*,\n\n" .
                "Tagihan dengan kode *{$this->transaksi->kode}* untuk periode *" . ($this->transaksi->durasi . ' bulan' ?? '1 bulan') . "* telah melewati tanggal jatuh tempo pada *" . now()->parse($this->transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y') . "*.\n\n" .
                "Mohon segera lakukan pembayaran untuk menghindari pemblokiran layanan.\n\n" .
                "⚠️ *Perhatian:* Apabila pembayaran belum dilakukan dalam *10 hari ke depan*, maka layanan akan *diblokir secara otomatis* oleh sistem.\n\n" .
                "Terima kasih,\n" .
                "*- RumahKedua*";

            $response = $fonnteService->send($number, $message);

            if (isset($response['status']) && in_array($response['status'], ['success', 'queued'])) {
                // Log::info("✅ Notifikasi WA sukses ke {$number} (Transaksi: {$this->transaksi->kode})");
                $this->transaksi->update(['notifikasi_jatuh_tempo_terkirim_pada' => now()]);
            } else {
                // Log::error("❌ Gagal kirim WA via Fonnte untuk {$this->transaksi->kode}", $response);
                throw new \Exception('Fonnte API returned error: ' . json_encode($response));
            }

        } catch (\Exception $e) {
            //Log::error("Job gagal untuk transaksi {$this->transaksi->kode}: " . $e->getMessage());
            throw $e;
        }
    }
}
