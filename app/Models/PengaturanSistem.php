<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaturanSistem extends Model
{
    protected $fillable = [
        'nama_kos',
        'no_telepon',
        'alamat_kos',
        'email',
        'deskripsi',
        'logo',
    ];
}
