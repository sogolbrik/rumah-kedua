<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkWhatsAppAnnouncement;
use App\Models\Pengumuman;
use App\Models\User;
use Carbon\Carbon;
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
            'kategori' => 'required|in:Umum,Penting,Perbaikan,Kegiatan',
            'highlight' => 'nullable|boolean',
            'isi' => 'required',
        ]);

        $validation['created_at'] = Carbon::now();
        $validation['updated_at'] = Carbon::now();

        $validation['highlight'] = $request->boolean('highlight');

        if ($validation['highlight']) {
            Pengumuman::where('highlight', true)->update(['highlight' => false]);
        }

        $message = "*" . $validation['judul'] . "*\n"
            . "Kategori: " . $validation['kategori'] . "\n"
            . ($validation['highlight'] ? "🔥 *Highlight* 🔥\n" : "")
            . $validation['isi'] . "\n\n"
            . "*- RumahKedua*";

        $numbers = User::where('role', 'penghuni')
            ->whereNotNull('telepon')
            ->pluck('telepon')
            ->map(function ($n) {
                $clean = preg_replace('/[^0-9]/', '', $n);
                if (str_starts_with($clean, '0')) {
                    $clean = '62' . substr($clean, 1);
                }
                if (str_starts_with($clean, '62') && strlen($clean) >= 10 && strlen($clean) <= 15) {
                    return $clean;
                }
                return null;
            })
            ->filter()
            ->values()
            ->toArray();

        if (!empty($numbers)) {
            SendBulkWhatsAppAnnouncement::dispatch($numbers, $message);
        }

        Pengumuman::create($validation);

        return redirect()->back()->with('success', 'Pengumuman berhasil dikirim.');
    }
}
