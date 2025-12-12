<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penghuni = User::with([
            'transaksi' => function ($q) {
                $q->orderBy('id', 'desc')->limit(1); // transaksi terakhir
            },
            'kamar'
        ])
            ->where('role', 'penghuni')
            ->get();
        $penghuniMenunggak = $penghuni->filter(function ($user) {
            $trx = $user->transaksi->first();

            if (!$trx)
                return false; // tidak punya transaksi → bukan menunggak
            if (!$trx->tanggal_jatuhtempo)
                return false;

            // jatuh tempo < hari ini → menunggak
            return Carbon::parse($trx->tanggal_jatuhtempo)
                ->lt(Carbon::today());
        });

        return view('admin.user.data', [
            'users' => User::with('kamar')->latest()->paginate(10),
            'kamar' => Kamar::select('id', 'kode_kamar', 'tipe', 'status')->get(),
            'penghuniMenunggak' => $penghuniMenunggak
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email|max:255',
            'password' => 'nullable|string|min:8',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'role' => 'nullable|in:admin,penghuni,user',
            'status_penghuni' => 'nullable|in:aktif,nonaktif,menunggak',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ktp' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            $gambarAvatar = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
            $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
            $validation['avatar'] = $avatarPath;
        }

        // Handle upload KTP
        if ($request->file('ktp')) {
            $extension = $request->file('ktp')->getClientOriginalExtension();
            $gambarKtp = 'ktp' . time() . '_' . uniqid() . '.' . $extension;
            $ktpPath = $request->file('ktp')->storePubliclyAs('ktp', $gambarKtp, 'public');
            $validation['ktp'] = $ktpPath;
        }

        $user = User::create($validation);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
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
        $user = User::findOrFail($id);
        return view('admin.user.form-edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'sometimes|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'kota' => 'nullable|string|max:100',
            'provinsi' => 'nullable|string|max:100',
            'role' => 'nullable|in:admin,user',
            'status_penghuni' => 'nullable|in:aktif,nonaktif,menunggak',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ktp' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
            $gambarAvatar = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
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
            $gambarKtp = 'ktp' . time() . '_' . uniqid() . '.' . $extension;
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

        $user->update($validation);

        return redirect()->route('user.index')->with('success', 'User berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
            $user->tanggal_masuk = null;
            $user->id_kamar = null;
        }

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
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

        $user->role = 'user';
        $user->id_kamar = null;
        $user->save();

        return redirect()->back()->with('success', 'Penghuni berhasil dinonaktifkan.');
    }

}
