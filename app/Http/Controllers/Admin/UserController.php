<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.user.data', [
            'users' => User::with('kamar')->latest()->paginate(10),
            'kamar' => Kamar::select('id', 'kode_kamar', 'tipe', 'status')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kamar = Kamar::where('status', 'Tersedia')->get(['id', 'kode_kamar', 'tipe']);
        return view('admin.user.form', [
            'kamar' => $kamar
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validation = $request->validate([
                'id_kamar'        => 'nullable|exists:kamars,id',
                'name'            => 'required|string|max:255',
                'email'           => 'required|unique:users,email|max:255',
                'password'        => 'nullable|string|min:8',
                'telepon'         => 'nullable|string|max:20',
                'alamat'          => 'nullable|string|max:255',
                'kota'            => 'nullable|string|max:100',
                'provinsi'        => 'nullable|string|max:100',
                'tanggal_masuk'   => 'nullable|date',
                'role'            => 'nullable|in:admin,penghuni,user',
                'status_penghuni' => 'nullable|in:aktif,nonaktif,menunggak',
                'avatar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'ktp'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $validation['password'] = bcrypt($request->password);

            // Normalisasi nomor telepon
            if ($request->telepon) {
                $telepon = preg_replace('/\s+/', '', $request->telepon); // hilangkan spasi
                if (str_starts_with($telepon, '+62')) {
                    $telepon = substr($telepon, 3); // hilangkan +62
                } elseif (str_starts_with($telepon, '0')) {
                    $telepon = substr($telepon, 1); // hilangkan 0 di depan
                }
                $validation['telepon'] = '62' . $telepon;
            }

            // Handle upload avatar
            if ($request->file('avatar')) {
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $gambarAvatar  = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
                $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
                $validation['avatar'] = $avatarPath;
            }

            // Handle upload KTP
            if ($request->file('ktp')) {
                $extension = $request->file('ktp')->getClientOriginalExtension();
                $gambarKtp  = 'ktp' . time() . '_' . uniqid() . '.' . $extension;
                $ktpPath = $request->file('ktp')->storePubliclyAs('ktp', $gambarKtp, 'public');
                $validation['ktp'] = $ktpPath;
            }

            if ($request->role == 'penghuni') {
                $validation['tanggal_masuk'] = now();
                $validation['status_penghuni'] = 'aktif';
            }

            $user = User::create($validation);

            if ($user->id_kamar) {
                Kamar::where('id', $user->id_kamar)->update(['status' => 'Terisi']);
            }

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
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
        $kamar = Kamar::where('status', 'Tersedia')->get(['id', 'kode_kamar', 'tipe']);
        $user  = User::with('kamar')->findOrFail($id);
        return view('admin.user.form-edit', [
            'kamar' => $kamar,
            'user'  => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $validation = $request->validate([
                'id_kamar'        => 'nullable|exists:kamars,id',
                'name'            => 'required|string|max:255',
                'email'           => 'sometimes|unique:users,email,' . $user->id,
                'password'        => 'nullable|string|min:8',
                'telepon'         => 'nullable|string|max:20',
                'alamat'          => 'nullable|string|max:255',
                'kota'            => 'nullable|string|max:100',
                'provinsi'        => 'nullable|string|max:100',
                'tanggal_masuk'   => 'nullable|date',
                'role'            => 'nullable|in:admin,penghuni,user',
                'status_penghuni' => 'nullable|in:aktif,nonaktif,menunggak',
                'avatar'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'ktp'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            // Jika password tidak diubah → tetap pakai yang lama
            if (!empty($request->password)) {
                $validation['password'] = bcrypt($request->password);
            } else {
                $validation['password'] = $user->password;
            }

            // Normalisasi nomor telepon
            if ($request->telepon) {
                $telepon = preg_replace('/\s+/', '', $request->telepon); // hilangkan spasi
                if (str_starts_with($telepon, '+62')) {
                    $telepon = substr($telepon, 3); // hilangkan +62
                } elseif (str_starts_with($telepon, '0')) {
                    $telepon = substr($telepon, 1); // hilangkan 0 di depan
                }
                $validation['telepon'] = '62' . $telepon;
            }

            // Handle upload avatar
            if ($request->hasFile('avatar')) {
                // Hapus avatar lama jika ada
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                // Upload avatar baru
                $extension = $request->file('avatar')->getClientOriginalExtension();
                $gambarAvatar  = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
                $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
                $validation['avatar'] = $avatarPath;
            } else {
                // Jika tidak ada avatar baru, gunakan avatar lama atau hapus jika dihapus
                if ($request->has('existing_image') && empty($request->existing_image)) {
                    // Hapus avatar lama
                    if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                        Storage::disk('public')->delete($user->avatar);
                    }
                    $validation['avatar'] = null;
                } else {
                    // Pertahankan avatar lama
                    $validation['avatar'] = $user->avatar;
                }
            }

            // Handle upload KTP
            if ($request->hasFile('ktp')) {
                // Hapus ktp lama jika ada
                if ($user->ktp && Storage::disk('public')->exists($user->ktp)) {
                    Storage::disk('public')->delete($user->ktp);
                }

                // Upload ktp baru
                $extension = $request->file('ktp')->getClientOriginalExtension();
                $gambarKtp  = 'ktp' . time() . '_' . uniqid() . '.' . $extension;
                $ktpPath = $request->file('ktp')->storePubliclyAs('ktp', $gambarKtp, 'public');
                $validation['ktp'] = $ktpPath;
            } else {
                // Jika tidak ada ktp baru, gunakan ktp lama atau hapus jika dihapus
                if ($request->has('existing_image') && empty($request->existing_image)) {
                    // Hapus ktp lama
                    if ($user->ktp && Storage::disk('public')->exists($user->ktp)) {
                        Storage::disk('public')->delete($user->ktp);
                    }
                    $validation['ktp'] = null;
                } else {
                    // Pertahankan ktp lama
                    $validation['ktp'] = $user->ktp;
                }
            }

            $roleLama = $user->role;
            $kamarIdLama = $user->id_kamar;

            // --- Role & kamar logic BEFORE update DB ---
            $newRole = $request->input('role', $user->role);
            $newKamarId = $request->input('id_kamar', $user->id_kamar);

            // jika role berubah dari penghuni -> bukan penghuni
            if ($roleLama === 'penghuni' && $newRole !== 'penghuni') {
                if ($kamarIdLama) {
                    Kamar::where('id', $kamarIdLama)->update(['status' => 'Tersedia']);
                }
                $validation['status_penghuni'] = null;
                $validation['tanggal_masuk'] = null;
                $validation['id_kamar'] = null;
            }

            // jika role jadi penghuni
            if ($newRole === 'penghuni') {
                $validation['status_penghuni'] = 'aktif';
                $validation['tanggal_masuk'] = now();
                // kalau ada kamar baru dipilih
                if (!empty($newKamarId)) {
                    // jika ada kamar lama beda dengan kamar baru -> buat kamar lama tersedia
                    if ($kamarIdLama && $kamarIdLama != $newKamarId) {
                        Kamar::where('id', $kamarIdLama)->update(['status' => 'Tersedia']);
                    }
                    // set kamar baru jadi terisi
                    Kamar::where('id', $newKamarId)->update(['status' => 'Terisi']);
                    $validation['id_kamar'] = $newKamarId;
                } else {
                    // kalau tidak memilih kamar baru, pertahankan kamar lama (jika ada)
                    if ($kamarIdLama) {
                        Kamar::where('id', $kamarIdLama)->update(['status' => 'Terisi']);
                        $validation['id_kamar'] = $kamarIdLama;
                    } else {
                        // tidak punya kamar, biarkan null (atau bisa paksa validasi agar wajib pilih kamar)
                        $validation['id_kamar'] = null;
                    }
                }
            }

            $user->update($validation);

            return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
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
            // Cari User berdasarkan ID
            $user = User::findOrFail($id);

            // Hapus gambar dari storage jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            if ($user->ktp && Storage::disk('public')->exists($user->ktp)) {
                Storage::disk('public')->delete($user->ktp);
            }

            // Hapus User
            $user->delete();

            $kamarIdLama = $user->id_kamar;
            if ($user->role === 'penghuni') {
                if ($kamarIdLama) {
                    Kamar::where('id', $kamarIdLama)->update(['status' => 'Tersedia']);
                }
                $validation['status_penghuni'] = null;
                $validation['tanggal_masuk'] = null;
                $validation['id_kamar'] = null;
            }

            return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // Status Penghuni
    //Nonaktifkan
    public function nonaktifkan($id)
    {
        $user = User::findOrFail($id);
        if ($user->role !== 'penghuni') {
            return redirect()->back()->with('error', 'Hanya penghuni yang dapat dinonaktifkan.');
        }

        if ($user->id_kamar) {
            Kamar::where('id', $user->id_kamar)->update(['status' => 'Tersedia']);
        }

        $user->status_penghuni = 'nonaktif';
        $user->id_kamar = null;
        $user->save();


        return redirect()->back()->with('success', 'Status penghuni berhasil diubah menjadi nonaktif.');
    }

    //Aktifkan
    public function aktifkan(Request $request, $id)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamars,id',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'id_kamar'       => $request->id_kamar,
            'tanggal_masuk'  => now(),
            'status_penghuni' => 'aktif',
        ]);

        // update kamar jadi Terisi
        if ($user->id_kamar) {
            Kamar::where('id', $user->id_kamar)->update(['status' => 'Terisi']);
        }
    }
}
