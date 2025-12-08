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
        DB::table('transaksis')->insert([
            $this->makeTransaksiKhususUser3(),
            $this->makeTransaksi(4, 1, 'paid'),
            $this->makeTransaksi(12, 3, 'pending'),
            $this->makeTransaksi(13, 4, 'expired'),
        ]);
    }

    private function makeTransaksi($user, $kamar, $status)
    {
        $now = Carbon::now();
        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $midOrd = 'MID-' . $kode . '-' . time();
        $midTrx = (string) Str::uuid();

        return [
            'id_user'            => $user,
            'id_kamar'           => $kamar,
            'kode'               => $kode,
            'tanggal_pembayaran' => $now,
            'tanggal_jatuhtempo' => $now->addMonth(),
            'masuk_kamar'        => $now,
            'durasi'             => '1',
            'total_bayar'        => 750000,
            'metode_pembayaran'  => 'midtrans',
            'status_pembayaran'  => $status,
            'midtrans_order_id'  => $midOrd,
            'midtrans_transaction_id' => $status != 'pending' ? $midTrx : null,
            'midtrans_payment_type' => $status == 'expired' ? 'qris' : 'bank_transfer',
            'midtrans_response' => $status == 'paid'
                ? json_encode(['status' => 'settlement', 'bank' => 'bca'])
                : ($status == 'expired'
                    ? json_encode(['status' => 'expire'])
                    : null),
            'expired_at' => $status == 'expired' ? $now->subDay() : $now->addDay(),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    private function makeTransaksiKhususUser3()
    {
        $now = Carbon::now();

        // waktu 1 bulan yang lalu
        $lastMonth = $now->copy()->subMonth();

        $kode = 'INV-' . strtoupper(Str::random(8)) . '-' . date('Ymd');
        $midOrd = 'MID-' . $kode . '-' . time();
        $midTrx = (string) Str::uuid();

        return [
            'id_user'                 => 3,
            'id_kamar'                => 2,
            'kode'                    => $kode,

            // aturan khusus          : 
            'tanggal_jatuhtempo'      => $now->subDay(),          // kemarin
            'masuk_kamar'             => $lastMonth,      // 1 bulan lalu
            'tanggal_pembayaran'      => $lastMonth,      // 1 bulan lalu
            'created_at'              => $lastMonth,
            'updated_at'              => $lastMonth,

            'durasi'                  => '1',
            'total_bayar'             => 750000,
            'metode_pembayaran'       => 'midtrans',
            'status_pembayaran'       => 'paid',

            'midtrans_order_id'       => $midOrd,
            'midtrans_transaction_id' => $midTrx,
            'midtrans_payment_type'   => 'bank_transfer',
            'midtrans_response'       => json_encode(['status' => 'settlement', 'bank' => 'bca']),

            'expired_at'              => $lastMonth->copy()->subDay(), // 1 bulan lalu - 1 hari
        ];
    }


    // DB::table('transaksis')->insert([
    //     // ✅ Transaksi 1-2 - Sudah dibayar
    //     [
    //         'id_user' => 3,
    //         'id_kamar' => 1,
    //         'kode' => $kode,
    //         'tanggal_pembayaran' => $now->subMonth(),
    //         'tanggal_jatuhtempo' => $now,
    //         'masuk_kamar' => $now->subMonth(),
    //         'durasi' => '1',
    //         'total_bayar' => 750000.00,
    //         'metode_pembayaran' => 'midtrans',
    //         'status_pembayaran' => 'paid',
    //         'midtrans_order_id' => $midOrd,
    //         'midtrans_transaction_id' => $midTrx,
    //         'midtrans_payment_type' => 'bank_transfer',
    //         'midtrans_response' => json_encode(['status' => 'settlement', 'bank' => 'bca']),
    //         'expired_at' => $now->addDay(),
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ],
    //     [
    //         'id_user' => 4,
    //         'id_kamar' => 2,
    //         'kode' => $kode,
    //         'tanggal_pembayaran' => $now,
    //         'tanggal_jatuhtempo' => $now->addMonth(),
    //         'masuk_kamar' => $now,
    //         'durasi' => '1',
    //         'total_bayar' => 750000.00,
    //         'metode_pembayaran' => 'midtrans',
    //         'status_pembayaran' => 'paid',
    //         'midtrans_order_id' => $midOrd,
    //         'midtrans_transaction_id' => $midTrx,
    //         'midtrans_payment_type' => 'bank_transfer',
    //         'midtrans_response' => json_encode(['status' => 'settlement', 'bank' => 'bca']),
    //         'expired_at' => $now->addDay(),
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ],

    //     // ✅ Transaksi 3 - Pending
    //     [
    //         'id_user' => 12,
    //         'id_kamar' => 3,
    //         'kode' => $kode,
    //         'tanggal_pembayaran' => $now,
    //         'tanggal_jatuhtempo' => $now->addMonth(),
    //         'masuk_kamar' => $now,
    //         'durasi' => '1',
    //         'total_bayar' => 750000.00,
    //         'metode_pembayaran' => 'midtrans',
    //         'status_pembayaran' => 'pending',
    //         'midtrans_order_id' => $midOrd,
    //         'midtrans_transaction_id' => null,
    //         'midtrans_payment_type' => null,
    //         'midtrans_response' => null,
    //         'expired_at' => $now->addDay(),
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ],

    //     // ✅ Transaksi 4 - Expired
    //     [
    //         'id_user' => 13,
    //         'id_kamar' => 4,
    //         'kode' => $kode,
    //         'tanggal_pembayaran' => $now,
    //         'tanggal_jatuhtempo' => $now->addMonth(),
    //         'masuk_kamar' => $now,
    //         'durasi' => '1',
    //         'total_bayar' => 750000.00,
    //         'metode_pembayaran' => 'midtrans',
    //         'status_pembayaran' => 'expired',
    //         'midtrans_order_id' => $midOrd,
    //         'midtrans_transaction_id' => $midTrx,
    //         'midtrans_payment_type' => 'qris',
    //         'midtrans_response' => json_encode(['status' => 'expire']),
    //         'expired_at' => $now->subDay(),
    //         'created_at' => $now,
    //         'updated_at' => $now,
    //     ],
    // ]);
}
