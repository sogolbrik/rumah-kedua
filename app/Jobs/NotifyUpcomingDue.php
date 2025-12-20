<?php

namespace App\Jobs;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyUpcomingDue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Transaksi $transaksi)
    {
    }

    public function handle(): void
    {
        $user = $this->transaksi->user;
        if (!$user || $user->role !== 'penghuni') {
            return;
        }

        $number = $user->telepon;
        if (!$number)
            return;

        // Normalisasi ke format internasional
        if (str_starts_with($number, '08')) {
            $number = '62' . substr($number, 1);
        }

        // Validasi format akhir: 628xxxxxxxxxx
        if (!preg_match('/^628[0-9]{8,12}$/', $number)) {
            return;
        }

        $dueDate = Carbon::parse($this->transaksi->tanggal_jatuhtempo)->translatedFormat('d F Y');

        $message = "📅 *Tagihan Akan Jatuh Tempo dalam 7 Hari*\n\n" .
            "Halo *{$user->name}*,\n\n" .
            "Tagihan Anda dengan kode *{$this->transaksi->kode}* akan jatuh tempo pada:\n" .
            "📆 *{$dueDate}*\n\n" .
            "Silakan segera lakukan pembayaran agar layanan tetap aktif.\n\n" .
            "Terima kasih,\n" .
            "*- RumahKedua*";

        $response = Http::timeout(30)->get('http://localhost:5000/api/Whatsapp/openandsend', [
            'number' => $number,
            'message' => $message,
        ]);

        if ($response->successful()) {
            $this->transaksi->update(['notifikasi_hampir_jatuh_tempo_terkirim_pada' => now()]);
        } else {
            throw new \Exception('Gagal mengirim notifikasi WhatsApp: ' . $response->body());
        }
    }
}
