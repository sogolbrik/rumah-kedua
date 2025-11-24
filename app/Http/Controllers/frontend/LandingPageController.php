<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\Kamar;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function landingPage()
    {
        $standard = Kamar::with('detailKamar')
            ->where('tipe', 'Standard')
            ->orderByRaw("CASE WHEN status = 'Tersedia' THEN 0 ELSE 1 END")
            ->first();

        $medium = Kamar::with('detailKamar')
            ->where('tipe', 'Medium')
            ->orderByRaw("CASE WHEN status = 'Tersedia' THEN 0 ELSE 1 END")
            ->first();

        $exclusive = Kamar::with('detailKamar')
            ->where('tipe', 'Exclusive')
            ->orderByRaw("CASE WHEN status = 'Tersedia' THEN 0 ELSE 1 END")
            ->first();

        $lat = -7.53526776112375;
        $lng = 112.51447516193055;
        $mapUrl = $this->generateMapUrl($lat, $lng);

        return view('frontend.landing-page', [
            // 'kamar' => Kamar::with('detailKamar')->get(),
            'standard' => $standard,
            'medium' => $medium,
            'exclusive' => $exclusive,
            'mapUrl' => $mapUrl
        ]);
    }

    public function galeri()
    {
        return view('frontend.galeri', [
            'galeri' => Galeri::get()
        ]);
    }

    public function generateMapUrl($lat, $lng)
    {
        return "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3041.499784962985!2d{$lng}!3d{$lat}!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2s{$lat}%2C{$lng}!5e0!3m2!1sid!2sid";
    }

}
