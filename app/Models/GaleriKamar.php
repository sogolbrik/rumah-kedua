<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriKamar extends Model
{
    protected $table = 'galeri_kamars';
    protected $fillable = ['id_kamar', 'foto'];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'id_kamar');
    }
}
