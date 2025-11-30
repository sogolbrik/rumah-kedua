<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PengumumanController extends Controller
{
    public function index()
    {
        return view('admin.pengumuman.data', [
            'pengumuman' => Pengumuman::latest()->paginate(3),
        ]);
    }

    public function store(Request $request)
    {
        $validation = $request->validate([
            'judul' => 'required',
            'isi' => 'required',
        ]);

        $message = "*" . $request->judul . "*\n"
            . $request->isi . "\n\n"
            . "— *RumahKedua*";

        $number = User::where('role', 'penghuni')->pluck('telepon')->toArray();
        $this->sendChatWhatsApp($number, $message);

        Pengumuman::create($validation);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim.');
    }

    private function sendChatWhatsApp($numbers, $message)
    {


        foreach ($numbers as $number) {
            try {
                $response = Http::timeout(30)->get("http://localhost:5000/api/Whatsapp/openandsend", [
                    'number' => $number,
                    'message' => $message
                ]);

            } catch (\Exception $e) {
                //
            }

            // Delay antara pengiriman
            sleep(1);
        }
    }
}
