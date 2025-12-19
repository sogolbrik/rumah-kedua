<?php

namespace App\Jobs;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyWelcomeResident implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;
    public $tries = 3;
    public $maxExceptions = 2;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Reload user jika perlu (opsional, tapi aman)
        $user = $this->user->fresh() ?? $this->user;

        if ($user->role !== 'penghuni' || !$user->id_kamar || !$user->tanggal_masuk) {
            //Log::warning("User {$user->id} bukan penghuni saat job dijalankan — batalkan notifikasi.");
            return;
        }

        $number = $user->telepon;
        if (!$number) {
            //Log::warning("User {$user->id} tidak punya nomor telepon.");
            return;
        }

        // Normalisasi nomor
        if (str_starts_with($number, '08')) {
            $number = '62' . substr($number, 1);
        } elseif (!preg_match('/^628[0-9]{8,13}$/', $number)) {
            //Log::warning("Nomor tidak valid untuk WA: {$number}");
            return;
        }

        // Ambil nama kamar
        $kamarName = $user->kamar?->kode_kamar ?? "Kamar {$user->id_kamar}" ?? 'Kamar Anda';

        // Format tanggal
        $tanggalMasuk = Carbon::parse($user->tanggal_masuk)->translatedFormat('d F Y');

        $message = "🎉 *Selamat Datang di RumahKedua!*\n\n" .
            "Halo *{$user->name}*,\n\n" .
            "Anda telah *resmi menjadi penghuni* mulai *{$tanggalMasuk}*.\n" .
            "Kamar Anda: *{$kamarName}*.\n\n" .
            "Semoga nyaman dan betah tinggal di sini! 🏠\n\n" .
            "Jika ada kebutuhan atau pertanyaan, jangan ragu hubungi admin.\n\n" .
            "Terima kasih,\n" .
            "*- Tim RumahKedua*";

        try {
            $response = Http::timeout(30)->get('http://localhost:5000/api/Whatsapp/openandsend', [
                'number' => $number,
                'message' => $message,
            ]);

            if ($response->successful()) {
                //Log::info("✅ WA selamat datang sukses ke {$number} (User: {$user->id})");
            } else {
                //Log::error("❌ Gagal kirim WA untuk user {$user->id}: " . $response->body());
            }
        } catch (\Exception $e) {
            //Log::error("URLException di NotifyWelcomeResident: " . $e->getMessage());
            throw $e;
        }
    }
}
