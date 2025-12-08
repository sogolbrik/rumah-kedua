<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendBulkWhatsAppAnnouncement implements ShouldQueue
{
    use Queueable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 60;
    public $maxExceptions = 3;

    protected array $numbers;
    protected string $message;

    /**
     * Create a new job instance.
     */
    public function __construct(array $numbers, string $message)
    {
        $this->numbers = $numbers;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach ($this->numbers as $index => $number) {
            try {
                // Validasi minimal nomor
                if (!is_numeric($number) || strlen($number) < 10) {
                    Log::warning("Nomor tidak valid: {$number}");
                    continue;
                }

                $response = Http::timeout(30)->get("http://localhost:5000/api/Whatsapp/openandsend", [
                    'number' => $number,
                    'message' => $this->message,
                ]);

                // Opsional: log respons
                if (!$response->successful()) {
                    Log::error("Gagal kirim ke {$number}: " . $response->body());
                } else {
                    Log::info("Berhasil kirim ke {$number}");
                }

            } catch (\Exception $e) {
                Log::error("Exception saat kirim ke {$number}: " . $e->getMessage());
            }

            // Beri jeda 1 detik antar kirim (opsional, bisa diatur)
            if ($index < count($this->numbers) - 1) {
                sleep(1);
            }
        }
    }
}
