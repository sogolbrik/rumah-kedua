<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'id_user',
        'id_kamar',
        'kode',
        'tanggal_pembayaran',
        'tanggal_jatuhtempo',
        'periode_pembayaran',
        'masuk_kamar',
        'durasi',
        'total_bayar',
        'metode_pembayaran',
        'status_pembayaran',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_payment_type',
        'midtrans_response',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }
}
