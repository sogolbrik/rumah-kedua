<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailKamar;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.kamar.data', [
            'kamar' => Kamar::with('detailKamar')->latest()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kamar.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                "kode_kamar"  => 'required|max:10|unique:kamars',
                "harga"       => 'required',
                "tipe"        => 'required',
                "lebar"       => 'required',
                "deskripsi"   => 'nullable',
                "gambar"      => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
                "fasilitas"   => 'required|array',
                "fasilitas.*" => 'string',
            ]);

            $harga = str_replace('.', '', $validation['harga']);
            $validation['harga'] = (int) $harga;

            $extension = $request->file('gambar')->getClientOriginalExtension();
            $gambarKamar  = 'kamar_' . time() . '_' . uniqid() . '.' . $extension;
            $gambarPath = $request->file('gambar')->storePubliclyAs('kamar', $gambarKamar, 'public');

            $validation['gambar'] = $gambarPath;
            $validation['status'] = 'Tersedia';

            $validation['deskripsi'] = $request->deskripsi;
            if (empty(trim($validation['deskripsi'] ?? ''))) {
                $validation['deskripsi'] = $this->getDefaultDeskripsi($request->tipe, $request->lebar);
            }

            $kamar = Kamar::create($validation);

            $fasilitasData = collect($validation['fasilitas'])->map(fn($fasilitas) => [
                'id_kamar' => $kamar->id,
                'fasilitas' => $fasilitas,
            ])->toArray();

            DetailKamar::insert($fasilitasData);

            return redirect()->route('kamar.index')->with('success', 'Kamar berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('admin.kamar.form-edit', [
            'kamar' => Kamar::with('detailKamar')->findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $kamar = Kamar::findOrFail($id);

            $validation = $request->validate([
                "kode_kamar"  => 'required|max:10|unique:kamars,kode_kamar,' . $id,
                "harga"       => 'required',
                "tipe"        => 'required',
                "lebar"       => 'required',
                "deskripsi"   => 'nullable',
                "gambar"      => 'sometimes|image|mimes:jpg,png,jpeg,webp|max:2048',
                "fasilitas"   => 'required|array',
                "fasilitas.*" => 'string',
            ]);

            // Format harga
            $harga = str_replace('.', '', $validation['harga']);
            $validation['harga'] = (int) $harga;

            // Handle gambar
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($kamar->gambar && Storage::disk('public')->exists($kamar->gambar)) {
                    Storage::disk('public')->delete($kamar->gambar);
                }

                // Upload gambar baru
                $extension = $request->file('gambar')->getClientOriginalExtension();
                $photoBed  = 'kamar_' . time() . '_' . uniqid() . '.' . $extension;
                $photoPath = $request->file('gambar')->storePubliclyAs('kamar', $photoBed, 'public');
                $validation['gambar'] = $photoPath;
            } else {
                // Jika tidak ada gambar baru, gunakan gambar lama atau hapus jika dihapus
                if ($request->has('existing_image') && empty($request->existing_image)) {
                    // Hapus gambar lama
                    if ($kamar->gambar && Storage::disk('public')->exists($kamar->gambar)) {
                        Storage::disk('public')->delete($kamar->gambar);
                    }
                    $validation['gambar'] = null;
                } else {
                    // Pertahankan gambar lama
                    $validation['gambar'] = $kamar->gambar;
                }
            }

            // Handle deskripsi
            $validation['deskripsi'] = $request->deskripsi;
            if (empty(trim($validation['deskripsi'] ?? ''))) {
                $validation['deskripsi'] = $this->getDefaultDeskripsi($request->tipe, $request->lebar);
            }

            // Update data kamar
            $kamar->update($validation);

            // Handle fasilitas
            // Hapus fasilitas lama
            DetailKamar::where('id_kamar', $kamar->id)->delete();

            // Insert fasilitas baru
            $fasilitasData = collect($validation['fasilitas'])->map(fn($fasilitas) => [
                'id_kamar' => $kamar->id,
                'fasilitas' => $fasilitas,
            ])->toArray();

            DetailKamar::insert($fasilitasData);

            return redirect()->route('kamar.index')->with('success', 'Kamar berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari kamar berdasarkan ID
            $kamar = Kamar::findOrFail($id);

            // Hapus gambar dari storage jika ada
            if ($kamar->gambar && Storage::disk('public')->exists($kamar->gambar)) {
                Storage::disk('public')->delete($kamar->gambar);
            }

            // Hapus fasilitas terkait
            DetailKamar::where('id_kamar', $kamar->id)->delete();

            // Hapus kamar
            $kamar->delete();

            return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function getDefaultDeskripsi($tipe, $lebar)
    {
        $defaultDeskripsi = [
            'Standard' => "Kamar tipe Standard dengan luas {$lebar} m² yang nyaman dan hemat. Dilengkapi dengan fasilitas dasar untuk memenuhi kebutuhan tinggal Anda. Lokasi strategis dan akses mudah ke fasilitas umum.",

            'Medium' => "Kamar tipe Medium dengan luas {$lebar} m² yang lebih luas dan nyaman. Menyediakan fasilitas lengkap untuk kenyamanan tinggal harian. Cocok untuk mahasiswa atau profesional yang mengutamakan kenyamanan.",

            'Exclusive' => "Kamar tipe Exclusive dengan luas {$lebar} m² yang mewah dan premium. Dilengkapi dengan fasilitas terbaik untuk pengalaman tinggal yang exceptional. Desain modern dan perhatian terhadap detail untuk kenyamanan maksimal."
        ];

        return $defaultDeskripsi[$tipe] ?? "Kamar {$tipe} dengan luas {$lebar} m² yang nyaman dan dilengkapi berbagai fasilitas penunjang.";
    }
}
