<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.galeri.data', [
            'galeri' => Galeri::latest()->paginate(12),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.galeri.form');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            "gambar.*" => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
        ]);

        $uploadedGambar = [];

        foreach ($request->file('gambar') as $image) {
            $extension = $image->getClientOriginalExtension();
            $gambarGaleri = 'galeri_' . time() . '_' . uniqid() . '.' . $extension;
            $gambarPath = $image->storePubliclyAs('galeri', $gambarGaleri, 'public');
            $uploadedGambar[] = ['gambar' => $gambarPath];
        }

        foreach ($uploadedGambar as $gambarData) {
            Galeri::create($gambarData);
        }

        session()->flash('success', 'Galeri berhasil ditambahkan');

        // Hanya return JSON — karena AJAX-only
        return response()->json([
            'success' => true,
            'message' => 'Galeri berhasil ditambahkan',
            'redirect' => route('galeri.index'),
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->gambar && Storage::disk('public')->exists($galeri->gambar)) {
            Storage::disk('public')->delete($galeri->gambar);
        }
        $galeri->delete();

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil dihapus');
    }
}
