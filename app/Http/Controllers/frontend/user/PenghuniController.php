<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PenghuniController extends Controller
{
    //
    public function index()
    {
        return view('frontend.user.penghuni');
    }
}
