<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkWhatsAppAnnouncement;
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
            . "> *-RumahKedua*";

        $numbers = User::where('role', 'penghuni')
            ->whereNotNull('telepon')
            ->pluck('telepon')
            ->map(function ($n) {
                // Hanya ambil angka
                $clean = preg_replace('/[^0-9]/', '', $n);
                // Konversi 08... → 628...
                if (str_starts_with($clean, '0')) {
                    $clean = '62' . substr($clean, 1);
                }
                // Pastikan mulai dengan 62 dan panjang ≥ 10 & ≤ 15
                if (str_starts_with($clean, '62') && strlen($clean) >= 10 && strlen($clean) <= 15) {
                    return $clean;
                }
                return null; // Akan difilter
            })
            ->filter()
            ->values()
            ->toArray();

        if (!empty($numbers)) {
            // Kirim ke queue (background)
            SendBulkWhatsAppAnnouncement::dispatch($numbers, $message);
        }

        Pengumuman::create($validation);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim.');
    }
}
