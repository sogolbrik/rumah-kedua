<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index(){
        return view("admin.pengaturan.data", [
            'pengaturan' => PengaturanSistem::first()
        ]);
    }

    public function update(Request $request){
        //
    }
}
