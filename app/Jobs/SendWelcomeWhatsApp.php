<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendWelcomeWhatsApp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 30;
    public $maxExceptions = 2;
    public $tries = 3; // Coba ulang maksimal 3x

    protected string $number;
    protected string $name;
    protected string $email;
    protected string $password;

    /**
     * Create a new job instance.
     */
    public function __construct(string $number, string $name, string $email, string $password)
    {
        $this->number = $number;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $message = "Halo *{$this->name}*! 👋\n\n" .
                "Terima kasih sudah mendaftar di *RumahKedua*.\n\n" .
                "Berikut akun Anda:\n" .
                "📧 Email: {$this->email}\n" .
                "🔑 Password: {$this->password}\n\n" .
                "❗ *Simpan baik-baik akun anda!!*\n\n" .
                "Sekarang kamu bisa:\n" .
                "> *Cari & pesan kamar kos* langsung dari Website\n" .
                "> *Pantau status pembayaran* dengan mudah\n" .
                "> *Dapat update kamar kosong* lebih cepat\n\n" .
                "Jika butuh bantuan, cukup balas pesan ini ya.\n" .
                "- *RumahKedua*";

            // Validasi dasar nomor
            if (!preg_match('/^628[0-9]{8,13}$/', $this->number)) {
                Log::warning("Nomor WhatsApp tidak valid untuk welcome message: {$this->number}");
                return;
            }

            $response = Http::timeout(30)->get("http://localhost:5000/api/Whatsapp/openandsend", [
                'number' => $this->number,
                'message' => $message
            ]);

            if (!$response->successful()) {
                Log::error("Gagal kirim welcome WA ke {$this->number}: " . $response->body());
            } else {
                Log::info("Berhasil kirim welcome WA ke {$this->number}");
            }

        } catch (\Exception $e) {
            Log::error("Exception saat kirim welcome WA ke {$this->number}: " . $e->getMessage());
            // Job akan otomatis di-retry karena implements ShouldQueue
            throw $e; // Penting: lempar ulang agar sistem tahu ini gagal
        }
    }
}
