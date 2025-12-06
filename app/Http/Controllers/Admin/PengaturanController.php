<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengaturanController extends Controller
{
    public function index()
    {
        return view("admin.pengaturan.data", [
            'pengaturan' => PengaturanSistem::first()
        ]);
    }

    public function update(Request $request)
    {
        $pengaturan = PengaturanSistem::firstOrFail();

        $validated = $request->validate([
            'nama_kos' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'no_telepon' => 'nullable|string|max:20',
            'alamat_kos' => 'nullable|string',
            'deskripsi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Normalisasi nomor telepon (opsional)
        if (!empty($validated['no_telepon'])) {
            $no_telepon = preg_replace('/\s+/', '', $validated['no_telepon']);
            if (Str::startsWith($no_telepon, '+62')) {
                $no_telepon = substr($no_telepon, 3);
            } elseif (Str::startsWith($no_telepon, '0')) {
                $no_telepon = substr($no_telepon, 1);
            }
            $validated['no_telepon'] = '62' . $no_telepon;
        } else {
            $validated['no_telepon'] = $pengaturan->no_telepon;
        }

        // Handle upload logo
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
                Storage::disk('public')->delete($pengaturan->logo);
            }

            // Simpan logo baru
            $extension = $request->file('logo')->getClientOriginalExtension();
            $filename = 'logo_' . time() . '_' . Str::random(10) . '.' . $extension;
            $logoPath = $request->file('logo')->storePubliclyAs('logo', $filename, 'public');
            $validated['logo'] = $logoPath;
        } else {
            // Pertahankan logo lama jika tidak diupload ulang
            $validated['logo'] = $pengaturan->logo;
        }

        // Mapping field form ke kolom database
        $dataToUpdate = [
            'nama_kos'   => $validated['nama_kos'] ?? $pengaturan->nama_kos,
            'email'      => $validated['email'] ?? $pengaturan->email,
            'no_telepon' => $validated['no_telepon'],
            'alamat_kos' => $validated['alamat_kos'] ?? $pengaturan->alamat_kos,
            'deskripsi'  => $validated['deskripsi'] ?? $pengaturan->deskripsi,
            'logo'       => $validated['logo'],
        ];

        $pengaturan->update($dataToUpdate);

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }

    public function hapusLogo()
    {
        $pengaturan = PengaturanSistem::firstOrFail();

        // Hapus logo lama jika ada
        if ($pengaturan->logo && Storage::disk('public')->exists($pengaturan->logo)) {
            Storage::disk('public')->delete($pengaturan->logo);
        }

        // Set logo menjadi null
        $pengaturan->update(['logo' => null]);

        return redirect()->back()->with('success', 'Logo berhasil dihapus.');
    }
}
