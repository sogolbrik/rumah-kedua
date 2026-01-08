<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.fonnte.api_key');
        $this->apiUrl = config('services.fonnte.api_url');
    }

    /**
     * Kirim pesan WhatsApp via Fonnte
     *
     * @param string $target Nomor WhatsApp (tanpa +62, cukup 08xx atau 628xx)
     * @param string $message Isi pesan
     * @param array $options Opsional: ['countryCode', 'delay', dll]
     * @return array Response dari API
     */
    public function send(string $target, string $message, array $options = []): array
    {
        $payload = array_merge([
            'target' => $target,
            'message' => $message,
        ], $options);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiKey,
            ])->withOptions([
                        'verify' => false, // nonaktifkan SSL verify (development only!)
                        'timeout' => 30,
                    ])->post($this->apiUrl, $payload);

            $result = $response->json();

            // Log::info('Fonnte API Response', [
            //     'target' => $target,
            //     'status' => $response->status(),
            //     'response' => $result,
            // ]);

            return $result;
        } catch (\Exception $e) {
            // Log::error('Fonnte API Error', [
            //     'target' => $target,
            //     'message' => $message,
            //     'error' => $e->getMessage(),
            // ]);

            return ['error' => $e->getMessage()];
        }
    }

    // kirim banyak nomor
    public function sendBulk(array $messages): array
    {
        return Http::withHeaders([
            'Authorization' => $this->apiKey,
        ])
            ->asMultipart()
            ->post($this->apiUrl, [
                [
                    'name' => 'data',
                    'contents' => json_encode($messages),
                ],
            ])
            ->json();
    }

}