<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('transaksis')->insert([
            // ✅ Transaksi 1 - Sudah dibayar
            [
                'id_user' => 1,
                'id_kamar' => 2,
                'kode' => 'INV-' . strtoupper(Str::random(8)),
                'tanggal_pembayaran' => $now->subDays(10),
                'tanggal_jatuhtempo' => $now->subDays(10)->addMonth(),
                'periode_pembayaran' => 'Bulanan',
                'masuk_kamar' => $now->subDays(10),
                'durasi' => '1 bulan',
                'total_bayar' => 750000.00,
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'paid',
                'midtrans_order_id' => 'MID-' . strtoupper(Str::random(6)),
                'midtrans_transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
                'midtrans_payment_type' => 'bank_transfer',
                'midtrans_response' => json_encode(['status' => 'settlement', 'bank' => 'bca']),
                'expired_at' => $now->subDays(9),
                'created_at' => $now->subDays(10),
                'updated_at' => $now->subDays(9),
            ],

            // ✅ Transaksi 2 - Pending
            [
                'id_user' => 2,
                'id_kamar' => 3,
                'kode' => 'INV-' . strtoupper(Str::random(8)),
                'tanggal_pembayaran' => $now,
                'tanggal_jatuhtempo' => $now->addMonth(),
                'periode_pembayaran' => 'Bulanan',
                'masuk_kamar' => $now,
                'durasi' => '1 bulan',
                'total_bayar' => 750000.00,
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'pending',
                'midtrans_order_id' => 'MID-' . strtoupper(Str::random(6)),
                'midtrans_transaction_id' => null,
                'midtrans_payment_type' => null,
                'midtrans_response' => null,
                'expired_at' => $now->addDay(),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // ✅ Transaksi 3 - Expired
            [
                'id_user' => 3,
                'id_kamar' => 4,
                'kode' => 'INV-' . strtoupper(Str::random(8)),
                'tanggal_pembayaran' => $now->subDays(40),
                'tanggal_jatuhtempo' => $now->subDays(10),
                'periode_pembayaran' => 'Bulanan',
                'masuk_kamar' => $now->subDays(40),
                'durasi' => '1 bulan',
                'total_bayar' => 750000.00,
                'metode_pembayaran' => 'midtrans',
                'status_pembayaran' => 'expired',
                'midtrans_order_id' => 'MID-' . strtoupper(Str::random(6)),
                'midtrans_transaction_id' => 'TRX-' . strtoupper(Str::random(10)),
                'midtrans_payment_type' => 'qris',
                'midtrans_response' => json_encode(['status' => 'expire']),
                'expired_at' => $now->subDays(10),
                'created_at' => $now->subDays(40),
                'updated_at' => $now->subDays(10),
            ],
        ]);
    }
}
