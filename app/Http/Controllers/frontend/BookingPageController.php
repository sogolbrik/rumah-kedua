<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;

class BookingPageController extends Controller
{
    public function booking()
    {
        return view("frontend.booking", [
            'kamar' => Kamar::with('detailKamar')->get(),
        ]);
    }

    public function bookingDetail($id) {
        return view('frontend.booking-detail', [
            'kamar' => Kamar::with('detailKamar')->findOrFail($id),
        ]);
    }

    public function pembayaran($id){
        return view('frontend.pembayaran', [
            'kamar' => Kamar::with('detailKamar')->findOrFail($id),
        ]);
    }
}
