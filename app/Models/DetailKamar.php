<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKamar extends Model
{
    protected $fillable = [
        'id_kamar',
        'fasilitas',
    ];

    public function kamar() {
        return $this->belongsTo(Kamar::class);
    }
}
