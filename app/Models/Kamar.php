<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $fillable = [
        'kode_kamar',
        'harga',
        'tipe',
        'lebar',
        'deskripsi',
        'gambar',
        'status'
    ];

    public function detailKamar() {
        return $this->hasMany(DetailKamar::class, 'id_kamar');
    }

    public function users() {
        return $this->hasMany(User::class, 'id_kamar');
    }

}
