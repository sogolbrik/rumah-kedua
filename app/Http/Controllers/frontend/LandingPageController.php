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
        return view('frontend.landing-page', [
            'kamar' => Kamar::get()
        ]);
    }

    public function galeri()
    {
        return view('frontend.galeri', [
            'galeri' => Galeri::get()
        ]);
    }
}
