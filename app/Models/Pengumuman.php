<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
        protected $fillable = [
        'id_user',
        'judul',
        'isi',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
