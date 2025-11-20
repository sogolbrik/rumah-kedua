<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.galeri.data', [
            'galeri' => Galeri::latest()->paginate(10),
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

        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $image) {
                $extension = $image->getClientOriginalExtension();
                $gambarGaleri = 'galeri_' . time() . '_' . uniqid() . '.' . $extension;
                $gambarPath = $image->storePubliclyAs('galeri', $gambarGaleri, 'public');

                $uploadedGambar[] = ['gambar' => $gambarPath];
            }
        }

        foreach ($uploadedGambar as $gambarData) {
            Galeri::create($gambarData);
        }

        return redirect()->route('galeri.index')->with('success', 'Galeri berhasil ditambahkan');
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
        //
    }
}
