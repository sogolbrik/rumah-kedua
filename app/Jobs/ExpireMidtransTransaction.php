<?php

namespace App\Jobs;

use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ExpireMidtransTransaction implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Transaksi $transaksi
    ) {
    }

    public function handle(): void
    {
        if ($this->transaksi->status_pembayaran !== 'pending') {
            return;
        }

        $this->transaksi->update([
            'status_pembayaran' => 'expired',
        ]);

    }
}