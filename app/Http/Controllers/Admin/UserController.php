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
                $q->orderBy('id', 'desc')->limit(1);
            },
            'kamar'
        ])
            ->where('role', 'penghuni')
            ->get();
        $penghuniMenunggak = $penghuni->filter(function ($user) {
            $trx = $user->transaksi->first();

            if (!$trx)
                return false;
            if (!$trx->tanggal_jatuhtempo)
                return false;

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
            'role' => 'nullable|in:admin,penghuni,user',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validation['password'] = bcrypt($request->password);

        // Normalisasi nomor telepon
        if ($request->telepon) {
            $telepon = preg_replace('/\s+/', '', $request->telepon); // hilangkan spasi
            if (str_starts_with($telepon, '+62')) {
                $telepon = substr($telepon, 3);
            } elseif (str_starts_with($telepon, '0')) {
                $telepon = substr($telepon, 1);
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
            'role' => 'nullable|in:admin,user',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if (!empty($request->password)) {
            $validation['password'] = bcrypt($request->password);
        } else {
            $validation['password'] = $user->password;
        }

        // Normalisasi nomor telepon
        if ($request->telepon) {
            $telepon = preg_replace('/\s+/', '', $request->telepon); // hilangkan spasi
            if (str_starts_with($telepon, '+62')) {
                $telepon = substr($telepon, 3);
            } elseif (str_starts_with($telepon, '0')) {
                $telepon = substr($telepon, 1);
            }
            $validation['telepon'] = '62' . $telepon;
        }

        // Handle upload avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Upload avatar baru
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $gambarAvatar = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
            $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
            $validation['avatar'] = $avatarPath;
        } else {
            if ($request->has('existing_image') && empty($request->existing_image)) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $validation['avatar'] = null;
            } else {
                $validation['avatar'] = $user->avatar;
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
        $user = User::findOrFail($id);

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        $kamarIdLama = $user->id_kamar;
        if ($user->role === 'penghuni') {
            if ($kamarIdLama) {
                Kamar::where('id', $kamarIdLama)->update(['status' => 'Tersedia']);
            }
        }

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }

    // Nonaktifkan Penghuni
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
