<?php

namespace App\Jobs;

use App\Models\Transaksi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyWarningBeforeBlock implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Transaksi $transaksi)
    {
    }

    public function handle(): void
    {
        $user = $this->transaksi->user;
        if (!$user || $user->role !== 'penghuni')
            return;

        $number = $user->telepon;
        if (!$number || !str_starts_with($number, '08') && !preg_match('/^628/', $number)) {
            //Log::warning("Nomor tidak valid untuk {$user->id}");
            return;
        }

        if (str_starts_with($number, '08')) {
            $number = '62' . substr($number, 2);
        }

        $message = "⚠️ *Peringatan Blokir Layanan*\n\n" .
            "Halo *{$user->name}*,\n\n" .
            "Tagihan *{$this->transaksi->kode}* telah melewati jatuh tempo.\n" .
            "❗ *Dalam 3 hari lagi*, akun Anda akan *diblokir* dan akses kamar dicabut jika belum bayar.\n\n" .
            "Segera lakukan pembayaran untuk menghindari ini!\n\n" .
            "Terima kasih,\n" .
            "*- RumahKedua*";

        $response = Http::timeout(30)->get('http://localhost:5000/api/Whatsapp/openandsend', [
            'number' => $number,
            'message' => $message,
        ]);

        if ($response->successful()) {
            $this->transaksi->update(['notifikasi_peringatan_blokir_terkirim_pada' => now()]);
            //Log::info("✅ Peringatan blokir dikirim: {$this->transaksi->kode}");
        } else {
            throw new \Exception('Gagal kirim WA');
        }
    }
}
