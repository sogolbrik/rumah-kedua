<?php

namespace App\Http\Controllers\frontend\user;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PenghuniController extends Controller
{
    public function index()
    {
        $user = User::with('kamar', 'transaksi')->find(Auth::id());

        $transaksis = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_pembayaran', 'desc')
            ->paginate(10);

        $totalTransaksi = $transaksis->total();

        $totalBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->sum('total_bayar');

        $terakhirBayar = Transaksi::where('id_user', $user->id)
            ->where('status_pembayaran', 'paid')
            ->orderBy('tanggal_pembayaran', 'desc')
            ->value('tanggal_pembayaran'); // Carbon instance atau null

        // Ambil transaksi terakhir (tanggal_jatuhtempo terbesar) milik user
        $transaksiTerakhir = Transaksi::where('id_user', $user->id)
            ->orderBy('tanggal_jatuhtempo', 'desc') // Urutkan dari terbaru
            ->first(); // Ambil satu record pertama (yg terakhir)

        // Cek apakah transaksi terakhir ada dan tanggal_jatuhtempo-nya kurang dari hari ini
        $menunggak = false; // Default ke false
        if ($transaksiTerakhir) {
            // Membandingkan tanggal jatuh tempo dengan tanggal hari ini (format Y-m-d)
            $menunggak = $transaksiTerakhir->tanggal_jatuhtempo < now()->toDateString();
        }

        return view('frontend.user.penghuni', compact(
            'user',
            'transaksis',
            'totalTransaksi',
            'totalBayar',
            'terakhirBayar',
            'menunggak'
        ));
    }

    public function profil()
    {
        return view('frontend.user.profil-penghuni');
    }

    public function update(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = User::findOrFail(Auth::id());
        $user->update($validation);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);
        $user = User::findOrFail(Auth::id());
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password lama tidak sesuai.',
            ]);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function updateAvatar(Request $request)
    {
        // Validasi avatar
        $validation = $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::findOrFail(Auth::id());

        // Hapus avatar lama jika ada
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Upload avatar baru
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->getClientOriginalExtension();
            $gambarAvatar = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
            $avatarPath = $request->file('avatar')->storePubliclyAs('avatar', $gambarAvatar, 'public');
            $validation['avatar'] = $avatarPath;
        }

        $user->update($validation);

        return back()->with('success', 'Avatar berhasil diperbarui.');
    }
}
