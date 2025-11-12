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

    protected $casts = [
        'midtrans_response' => 'array',
        'expired_at' => 'datetime',
        'tanggal_pembayaran' => 'date',
        'tanggal_jatuhtempo' => 'date',
        'masuk_kamar' => 'date',
        'total_bayar' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }

    /**
     * Accessor untuk midtrans_response
     */
    public function getMidtransResponseAttribute($value)
    {
        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Mutator untuk midtrans_response
     */
    public function setMidtransResponseAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['midtrans_response'] = json_encode($value);
        } else {
            $this->attributes['midtrans_response'] = $value;
        }
    }
}
