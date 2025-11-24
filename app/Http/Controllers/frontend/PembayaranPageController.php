<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class PembayaranPageController extends Controller
{
    public function pembayaran($id){
        return view('frontend.pembayaran', [
            'kamar' => Kamar::with('detailKamar')->findOrFail($id),
        ]);
    }
}
