<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'highlight', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
