<?php

namespace App\Jobs;

use App\Services\FonnteService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendBulkWhatsAppAnnouncement implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

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
    public function handle(FonnteService $fonnteService): void
    {
        $total = count($this->numbers);
        // Log::info("Bulk WA dimulai ke {$total} nomor");

        $messages = [];

        foreach ($this->numbers as $index => $number) {
            if (!is_numeric($number) || strlen($number) < 10) {
                continue;
            }

            $messages[] = [
                'target' => $number,
                'message' => $this->message,
                'delay' => (string) ($index + 1),
            ];
        }

        if (empty($messages)) {
            // Log::warning('⚠️ Tidak ada pesan valid untuk dikirim');
            return;
        }

        try {
            $response = $fonnteService->sendBulk($messages);
            // Log::info('Payload ke Fonnte', [
            //     'data' => json_encode($messages),
            // ]);

            if (!isset($response['status']) || $response['status'] !== true) {
                // Log::error('Fonnte menolak bulk', $response);
                throw new \Exception('Fonnte bulk gagal');
            }

            // Log::info('Response Fonnte Bulk', $response);

        } catch (\Throwable $e) {
            // Log::error('Bulk WA gagal', [
            //     'error' => $e->getMessage(),
            // ]);

            throw $e;
        }
    }

}
